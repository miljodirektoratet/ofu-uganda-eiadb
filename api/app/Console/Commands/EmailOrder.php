<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EmailOrder as EmailOrderModel;

class EmailOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process email orders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $unprocessedOrderList = EmailOrderModel::where('order_status', 2)->orWhere('order_status', 1)->get();
        
        foreach($unprocessedOrderList as $order) {
            try {
                $output = $this->mailer($this->emailSpliter($order->recipient), $order->subject, 'emails.orderTemplate', ['content' => $order->body],$this->emailSpliter($order->cc), $this->emailSpliter($order->bcc));
                
                $order->update([
                    'number_of_attempts' => \DB::raw('number_of_attempts + 1'),
                    'order_status' => 3,
                    'remarks_from_service' => $output,
                    'updated_by' => 'Email Service',
                    ]);
                } catch(\Exception $e) {
                    $error = $e->getMessage();
                    $order->update([
                        'order_status' => 4,
                        'remarks_from_service' => 'Reason for Failure: '.$error.' \n Original Recipient list: '. $order->recipient,
                        'number_of_attempts' => \DB::raw('number_of_attempts + 1'),
                        'updated_by' => 'Email Service',
                        ]);
                        return $this->info(json_encode(['order_status' => 4]));
                }
        }
        return $this->info(json_encode(['order_status' => 3]));
    }

    private function mailer($toAddresses, $subject, $template, $templateData = [], $ccAddresses = [], $bccAddresses = [])
    {
        $response = null;
        extract($this->mutateMailParams(get_defined_vars()));
        $fromAddress = config('mail.from')['address'];

        $callback = function ($m) use ($fromAddress, $toAddresses, $subject, $ccAddresses, $bccAddresses) {
            $m->from($fromAddress, config('mail.name'));
            $m->to($toAddresses);
            $m->subject($subject);
            ($ccAddresses)? $m->cc($ccAddresses) : '';
            ($bccAddresses)? $m->bcc($bccAddresses) : '';
        };
        \Mail::send($template, $templateData, $callback);
        return $response;
    }

    private function mutateMailParams($paramList)
    {
        extract($paramList);

        if(config('app.env') == 'test') {
            $modifiedSubject = 'TEST ('.$subject.' )';
        }

        $response = null;
        $validatedRecipients = [];
        $failedRecipients = [];
        foreach($toAddresses as $emailAddress) {
            $emailSplit = explode('@', $emailAddress);
            $domain = array_pop($emailSplit);
            if($this->checkMX($domain)) {
                $validatedRecipients[] = $emailAddress;
                continue;
            }
            $failedRecipients[] = $emailAddress;
        }

        //all recipients are invalid
        if(count($failedRecipients) == count($toAddresses)) {
            throw new \Exception('All recipient email(s) are invalid '.implode(', ', $failedRecipients).' (typical: "Domain name does not exist.")');
        }

        // some recipients are invalid
        if(count($failedRecipients)) {
            $response = 'Some recipient emails are invalid '.implode(', ', $failedRecipients).' (typical: "Domain name does not exist.")';
        }

        return [
            'toAddresses' => $validatedRecipients,
            'subject' => $modifiedSubject,
            'template' => $template,
            'templateData' => $templateData,
            'ccAddresses' => $ccAddresses,
            'bccAddresses' => $bccAddresses,
            'response'  => $response,
        ];
    }

    private function checkMX($domain) {
        exec("dig +short MX " . escapeshellarg($domain),$ips);
        if(!isset($ips[0]) || $ips[0] == "") {
                return false;
        }
        return true;
    }

    private function emailSpliter($emails) {
        return preg_split('@;@', $emails, NULL, PREG_SPLIT_NO_EMPTY);
    }
}

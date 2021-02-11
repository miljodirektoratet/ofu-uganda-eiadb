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
                $output = $this->mailer(explode(';', $order->recipient), $order->subject, 'emails.orderTemplate', ['content' => $order->body], explode(';', $order->cc), explode(';', $order->bcc));
                $order->update([
                    'number_of_attempts' => \DB::raw('number_of_attempts + 1'),
                    'order_status' => 3,
                    'remarks_from_service' => null,
                    'updated_by' => 'Email Service',
                    ]);
                } catch(\Exception $e) {
                    $error = $e->getMessage();
                    $order->update([
                        'order_status' => 4,
                        'remarks_from_service' => 'Reason for Failure: '.$error.' \n Failed Emails: '. $order->recipient,
                        'number_of_attempts' => \DB::raw('number_of_attempts + 1'),
                        'updated_by' => 'Email Service',
                        ]);
                        return $error;
                }
        }
        return "done";

    }

    private function mailer($toAddresses, $subject, $template, $templateData = [], $ccAddresses = [], $bccAddresses = [])
    {
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
        return true;
    }

    private function mutateMailParams($paramList)
    {
        if(config('app.env') != 'test') {
            return $paramList;
        }
        $allowedEmails = \App\Role::where('name', 'Role 8')->with(['users' =>  function($query){$query->select('email');}])->get()[0]->users->map(function ($user) {
            return strtolower($user->email);
        })->toArray();

        $removeForeignEmails = function($emailList) use($allowedEmails) {
            $finalList = [];
            if(!is_iterable($emailList)) {
                return [];
            }
            foreach($emailList as $email) {
                if(in_array(strtolower($email), $allowedEmails)) {
                    $finalList[] = $email;
                }
            }
            return $finalList;
        };

        extract($paramList);

        return [
            'toAddresses' => $removeForeignEmails($toAddresses),
            'subject' => 'TEST ('.$subject.' )',
            'template' => $template,
            'templateData' => $templateData,
            'ccAddresses' => $removeForeignEmails($ccAddresses),
            'bccAddresses' => $removeForeignEmails($bccAddresses),
        ];
    }
}

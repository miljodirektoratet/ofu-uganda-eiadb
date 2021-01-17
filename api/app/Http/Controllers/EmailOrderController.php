<?php namespace App\Http\Controllers;

use Response;
use Auth;
use Illuminate\Http\Request;
use \App\EmailOrder;
use \App\EiaPermit;
use \App\Project;

class EmailOrderController extends Controller
{
    private $validatorMethod = [
        'eia' => 'eiaeaIsValid', 
        'ea' => 'eiaeaIsValid', 
        'pl' => 'plIsValid'
    ];

    private $emailBody = [
        'eia' => 'eiaeaBody',
        'ea' => 'eiaeaBody',
        'pl' => 'plBody',
    ];
    private $model = [
        'eia' => 'EiaPermit',
        'ea' => 'ExternalAudit',
        'pl' => 'PermitLicense',
    ];

    private $failedEmailOrder = [
        'order_status' => 0
    ];

    public function orderRequest($orderType, $entityId, $documentId = null, Request $request)
    {
        try {
            if(EmailOrder::where("foreign_id", $entityId)->where("foreign_type", $orderType)->first()) {
                return $this->failedEmailOrder;
            }
            $validator = $this->validatorMethod[$orderType];
            if(! $entity = $this->$validator($orderType, $entityId, $documentId)) {
                return $this->failedEmailOrder;
            }
            return $this->createEmailOrder($orderType, $entity);
        } catch(\Exception $e) {
            return $this->failedEmailOrder;
        }
    }

    private function eiaeaIsValid($orderType, $entityId, $documentId)
    {
        $model = '\App\\'.$this->model[$orderType];
        $withDocument = function ($query) use($documentId)
        {
            $query->where('id', $documentId);
        };
        $entity = $model::with(['documents' => $withDocument])->find($entityId);
        if(!$entity) {
            return false;
        }
        if($orderType == 'ea') {
            $contactObj = \App\EiaPermit::where('project_id', $entity->project_id)->first(['email_contact']);
            $entity->email_contact = $contactObj->email_contact;
        }
        if(strlen($entity->project_id) && 
        count($entity->documents) &&
        in_array($entity->documents[0]->type,[8, 9, 10, 11, 12, 13]) &&
        $entity->documents[0]->number > 0 &&
        strlen($entity->email_contact)
        ) {
            return $entity;
        }
        
        return false;
    }

    private function plIsValid($orderType, $entityId, $documentId=null)
    {
        $model = '\App\\'.$this->model[$orderType];
        $entity = $model::with('project')->find($entityId);
        if(!$entity) {
            return false;
        }
        if(
            $entity->id > 0 &&
            in_array($entity->regulation,[118, 119]) &&
            $entity->application_number > 0 && 
            strlen($entity->email_contact) &&
            strlen($entity->project->title)
            ) {
            return $entity;
        }
        
        return false;
    }

    private function createEmailOrder($orderType, $entity)
    {
        $emailOrderObj = [
            'foreign_id' => $entity->id,
            'foreign_type' => $orderType,
            'subject' => config('emailOrder.subject'),
            'body' => $this->{$this->emailBody[$orderType]}($entity),
            'bcc' => config('emailOrder.bcc'),
            'user_id' => Auth::user()->id,
            'recipient' => $entity->email_contact,
            'created_by' => Auth::user()->name,
            'updated_by' => Auth::user()->name,
            'order_status' => 2
        ];
        $emailOrder = EmailOrder::insert($emailOrderObj);
        return $emailOrderObj;
    }

    private function eiaeaBody($entity)
    {
        return view('emails.eiaEmailOrderBody', [
            'projectTitle'=> Project::find($entity->project_id)->title,
            'documentId'=> $entity->documents[0]->id,
            'documentCode'=> $entity->documents[0]->code,
        ])->render();
    }

    private function plBody($entity)
    {
        return view('emails.plEmailOrderBody', [
            'projectTitle'=> $entity->project->title,
            'permitLicensesId'=> $entity->id,
            'permitLicensesApplicationNumber'=> $entity->application_number,
        ])->render();
    }
}

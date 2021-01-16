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
    private $model = [
        'eia' => 'EiaPermit'
    ];

    private $failedEmailOrder = [
        'order_status' => 0
    ];

    public function orderRequest($orderType, $entityId, Request $request)
    {
        try {
            if(EmailOrder::where("foreign_id", $entityId)->where("foreign_type", $orderType)->first()) {
                return $this->failedEmailOrder;
            }
            $validator = $this->validatorMethod[$orderType];
            if(! $entity = $this->$validator($orderType, $entityId)) {
                return $this->failedEmailOrder;
            }
            return $this->createEmailOrder($orderType, $entity);
        } catch(\Exception $e) {
            return $this->failedEmailOrder;
        }
    }

    private function eiaeaIsValid($orderType, $entityId)
    {
        $model = '\App\\'.$this->model[$orderType];
        $withCertificate = function ($query)
        {
            $query->select('id', 'filename');
        };
        $entity = $model::with('documents')->find($entityId);

        if(!$entity) {
            return false;
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

    private function createEmailOrder($orderType, $entity)
    {
        $emailOrderObj = [
            'foreign_id' => $entity->id,
            'foreign_type' => $orderType,
            'subject' => '',
            'body' => '',
            'user_id' => Auth::user()->id,
            'recipient' => $entity->email_contact,
            'created_by' => Auth::user()->name,
            'order_status' => 2
        ];
        $emailOrder = EmailOrder::insert($emailOrderObj);
        return $emailOrderObj;
    }
}

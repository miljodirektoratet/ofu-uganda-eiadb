<?php namespace App\Http\Controllers;

use Request;
use Response;
use Auth;

class DataAnonymizerController extends Controller
{

    private $action = [
        'org_email_update' => [
            'model' => 'Organisation',
            'field' => 'email'
        ],
        'prac_email_update' => [
            'model' => 'Practitioner',
            'field' => 'email'
        ],
        'pl_email_update' => [
            'model' => 'PermitLicense',
            'field' => 'email_contact'
        ],
        'eia_email_update' => [
            'model' => 'EiaPermit',
            'field' => 'email_contact'
        ],
        'ea_email_update' => [
            'model' => 'ExternalAudit',
            'field' => 'email_contact'
        ],
    ];

    // GET /resource
    public function index(Request $request, $action)
    {

        if(strtolower(config('app.env')) != 'test') {
            return Response::json(['status' => 0], 200);
        }
        try {
            $this->fieldUpdate($action);
        } catch(\Exception $e) {
            return Response::json(['status' => 0], 200);
        }
        return Response::json(['status' => 1], 200);
    }

    private function fieldUpdate($action)
    {
        $field = $this->action[$action]['field'];
        $model = $this->action[$action]['model'];
        (app('\App\\'.$model))::orderBy('id')->chunk(900, function($recordList) use($field, $model)
        {
            foreach ($recordList as $record)
            {
                $record->$field = preg_replace('~@([^;]*)$~','@nema.gdpr', preg_replace('~@([^;]*);~','@nema.gdpr;', $record->$field));
                $record->updated_by = (Auth::user())->name;
                $record->save();
            }
        });
    }

}
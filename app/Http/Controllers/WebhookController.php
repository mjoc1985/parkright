<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function emailImport(Request $data)
    {
        // This is the start of the email import from mandrill feature.
        // To be continued in a later version...
        $return = collect();
        $events = json_decode($data['mandrill_events']);
        $attachments = $events[0]->msg->attachments;

        foreach ($attachments as $file){
           $return->push($file);
        }

        return response([
            'data' => $return[0]
        ], 200);
    }
}

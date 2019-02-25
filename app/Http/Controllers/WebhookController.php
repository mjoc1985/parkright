<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function emailImport(Request $data)
    {
        
        
        //app('log')->debug($mail[0]);

//        $attachments = array();
//        foreach ($mail->msg->attachments as $attachment) {
//            $attachments[] = array(
//                'type' => $attachment->type,
//                'name' => $attachment->name,
//                'content' => $attachment->content,
//            );
//        }
//        //$event = $data->mandrill_events;
//        app('log')->debug($attachments);
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

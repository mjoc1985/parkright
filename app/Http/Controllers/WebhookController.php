<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function emailImport($data)
    {
        return response(
            [
                'data' => $data
            ]
        );
    }
}

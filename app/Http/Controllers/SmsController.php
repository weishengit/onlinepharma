<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    public function index()
    {
        Nexmo::message()->send([
            'to' => '639750239318',
            'from' => 'Online Pharma',
            'text' => 'Test SMS',
        ]);

        echo "Message sent!";
    }
}

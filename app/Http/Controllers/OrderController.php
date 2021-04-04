<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function users()
    {
        return view('admin.reports.user');
    }

    public function orders()
    {
        return view('admin.reports.order');
    }

}

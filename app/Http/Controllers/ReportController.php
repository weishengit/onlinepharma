<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function show($report = null)
    {
        if ($report == 'user') {
            return view('admin.reports.user');
        }
        if ($report == null) {
            return redirect()->route('admin.index')->with('message', 'report not found.');
        }

        return view('admin.reports.show');
    }
}

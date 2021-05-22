<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserReportController extends Controller
{

    public function users(Request $request)
    {
        $request->validate([
            'year' => 'numeric',
            'start' => 'numeric',
            'end' => 'numeric',
        ]);

        $year = $request->input('year') ?? null;
        $month_start = $request->input('start') ?? null;
        $month_end = $request->input('end') ?? null;
        $year = Carbon::createFromDate($year);

        if ($year == null) {
            $year = Carbon::now();
        }


        $start_date = $year->startOfYear();
        $end_date = $start_date->copy()->endOfYear();

        if (($month_start != null || $month_start >= 0) && $month_end != null) {
            $start_date->addMonths($month_start);
            $end_date = $start_date->copy()->addMonths($month_end)->endOfMonth();
        }

        // dd($start_date . ' - ' . $end_date);

        // GET ALL REGISTRATIONS
        $user_count = [];
        $user_array = [];

        $user_registrations = User::whereBetween('created_at', [$start_date, $end_date])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
        });

        // dd($user_registrations);
        $month_name = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        foreach ($user_registrations as $key => $value) {
            $user_count[(int)$key] = count($value);
        }

        // dd($user_count);

        for($month = $month_start+1; $month <= $month_end + 1; $month++){
            if(!empty($user_count[$month])){
                $user_array[$month_name[$month-1]] = $user_count[$month];
            }else{
                $user_array[$month_name[$month-1]] = 0;
            }
        }

        // dd($user_array);
        // GET ALL REGISTRATIONS

        return json_encode($user_array);

    }

}

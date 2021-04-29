<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserReportController extends Controller
{

    public function dashboard_users()
    {
        $months = ["January", "February", "March", "April", "May", "June", "July", "Aughust", "September", "October", "November", "December"];
        $monthNumber = 1;
        $usersDataset = [];
        foreach ($months as $month) {

            $currentYear = now()->startOfYear();
            $selectedDate = Carbon::create($currentYear->year, $monthNumber);

            $usersDataset[$month] = User::whereBetween('created_at', [$selectedDate->firstOfMonth()->toDateTimeString(), $selectedDate->lastOfMonth()->toDateTimeString()])->get()->count();

            $monthNumber++;

        }

        return json_encode($usersDataset);
    }

    public function user_yearly()
    {
        $months = ["January", "February", "March", "April", "May", "June", "July", "Aughust", "September", "October", "November", "December"];
        $current_year = now()->startOfYear();
        $previous_year = now()->startOfYear()->subYear();
        $years = [$previous_year->year, $current_year->year];
        $monthNumber = 1;

        $user_count = [];

        foreach ($years as $year) {
            if ($monthNumber > 12) {
                $monthNumber = 1;
            }
            foreach ($months as $month) {
                $selectedDate = Carbon::create($year, $monthNumber);
                $user_count[$year][$month] = User::whereBetween('created_at', [$selectedDate->firstOfMonth()->toDateTimeString(), $selectedDate->lastOfMonth()->toDateTimeString()])->get()->count();
                $monthNumber++;
            }
        }
        return json_encode($user_count);
    }
}

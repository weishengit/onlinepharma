<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

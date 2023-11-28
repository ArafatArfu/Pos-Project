<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function DashboardPage(Request $request){
        return view('pages.dashboard.dashboard-page');
    }
}

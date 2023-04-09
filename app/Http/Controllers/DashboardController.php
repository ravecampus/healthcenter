<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purok;
use App\Models\User;

class DashboardController extends Controller
{
    public function numberOfDash(){
        $hw = User::where('role', 1)->get();
        $patient = User::where('role', 0)->get();
        $purok = Purok::all();

        $ret = [
            'hworker'=>count($hw), 
            'patient' => count($patient),
            'purok' => count($purok)
        ];

        return response()->json($ret, 200);
    }
}

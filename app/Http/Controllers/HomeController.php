<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $vehicles = [];
        if($request->license_plate){
            $vehicles = Vehicle::where('license_plate', $request->license_plate)->get();
        }
        return view('home', compact('vehicles'));
    }
}

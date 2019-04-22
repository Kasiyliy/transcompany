<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Validator;
use Session;

class VehicleController extends Controller
{

    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicles.index' , compact("vehicles"));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'longitude' =>'required',
            'latitude' =>'required',
            'status' =>'required',
            'license_plate' =>'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }else{
            $vehicle =  new Vehicle();
            $vehicle->fill($request->all());
            $vehicle->save();
            Session::flash('success' , 'Транспартное средство успешно добавлена!');
            return redirect()->back();
        }
    }


    public function delete($id){
        $vehicle = Vehicle::find($id);
        if($vehicle){
            $vehicle->delete();
            Session::flash('success' , 'Транспартное средство успешно удалена!');
        }else{
            Session::flash('error' , 'Транспартное средство не существует!');
        }
        return redirect()->back();
    }


    public function edit($id){
        $vehicle = Vehicle::find($id);
        if(!$vehicle){
            Session::flash('error' , ' Транспартное средство не существует!');
            return redirect()->back();
        }

        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id){
        $vehicle = Vehicle::find($id);
        if(!$vehicle){
            Session::flash('error' , 'Транспартное средство не существует!');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'longitude' =>'required',
            'latitude' =>'required',
            'status' =>'required',
            'license_plate' =>'required',
        ]);

        if ($validator->fails()) {
            Session::flash('error' , 'Ошибка!');
            return redirect()->back()->withErrors($validator);
        }else{
            $vehicle->fill($request->all());
            $vehicle->save();
            Session::flash('success' , 'Транспартное средство успешно обновлена!');
            return redirect()->back();
        }
    }

}

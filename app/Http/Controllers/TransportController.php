<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\LibraryUser;
use App\Models\BookBorrower;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Route;
use App\Models\RoutesStation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class TransportController extends Controller
{
    // Teaching Staffs Methods
    public function teacherVehicles()
    {
        $routes_station = RoutesStation::where('schools_id', Session::get('school_id'))->get();
        $vehicles = Vehicle::where('schools_id', Session::get('school_id'))->get();
        return view('teaching_staffs.transports.vehicles')->with('data', $vehicles)->with('routes_stations', $routes_station);
    }

    public function teacherSaveVehicles(Request $request)
    {
        //return $request->all();
        try {
            DB::beginTransaction();
            $vehicle = new Vehicle;
            $vehicle->schools_id = Session::get('school_id');
            $vehicle->name = $request->name;
            $vehicle->plate_number = $request->plate_number;
            $vehicle->save();
            DB::commit();
            return redirect()->to('/teacher-vehicles')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-vehicles')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherEditVehicles(Request $request)
    {

        try {
            DB::beginTransaction();
            $vehicle = Vehicle::where('schools_id', Session::get('school_id'))->where('id', $request->id)->first();
            $vehicle->name = $request->name;
            $vehicle->plate_number = $request->plate_number;
            $vehicle->save();
            DB::commit();
            return redirect()->to('/teacher-vehicles')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-vehicles')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherDeleteVehicles(Request $request)
    {

        try {
            DB::beginTransaction();
            Vehicle::where('schools_id', Session::get('school_id'))->where('id', $request->id)->delete();
            DB::commit();
            return redirect()->to('/teacher-routes')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-routes')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherRoutes()
    {
        $routes = Route::where('schools_id', Session::get('school_id'))->get();
        return view('teaching_staffs.transports.routes')->with('data', $routes);
    }

    public function teacherSaveRoutes(Request $request)
    {
        //return $request->all();
        try {
            DB::beginTransaction();
            $routes = new Route;
            $routes->schools_id = Session::get('school_id');
            $routes->name = $request->name;
            $routes->save();
            DB::commit();
            return redirect()->to('/teacher-routes')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-routes')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherEditRoutes(Request $request)
    {

        try {
            DB::beginTransaction();
            $routes = Route::where('schools_id', Session::get('school_id'))->where('id', $request->id)->first();
            $routes->name = $request->name;
            $routes->save();
            DB::commit();
            return redirect()->to('/teacher-routes')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-routes')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherDeleteRoutes(Request $request)
    {

        try {
            DB::beginTransaction();
            Route::where('schools_id', Session::get('school_id'))->where('id', $request->id)->delete();
            DB::commit();
            return redirect()->to('/teacher-routes')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-routes')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherStations()
    {
        $stations = RoutesStation::select(
            'routes_stations.id as id',
            'routes_stations.routes_id as routes_id',
            'routes_stations.name as name',
            'routes.name as route_name'
        )
            ->where('routes_stations.schools_id', Session::get('school_id'))
            ->join('routes', 'routes.id', '=', 'routes_stations.routes_id')->get();
        $routes = Route::where('schools_id', Session::get('school_id'))->get();
        // RoutesStation::select('routes_stations.id as id','routes_stations.routes_id as routes_id','routes_stations.name as name')
        //            ->where('routes_stations.schools_id',Session::get('school_id'))
        //            ->join('routes','routes.id','=','routes_stations.routes_id')->get();
        return view('teaching_staffs.transports.stations')->with('data', $stations)->with('routes', $routes);
    }

    public function teacherSaveStations(Request $request)
    {
        //return $request->all();
        try {
            DB::beginTransaction();
            $stations = new RoutesStation;
            $stations->schools_id = Session::get('school_id');
            $stations->name = $request->name;
            $stations->routes_id = $request->routes_id;
            $stations->save();
            DB::commit();
            return redirect()->to('/teacher-stations')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-stations')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherEditStations(Request $request)
    {

        try {
            DB::beginTransaction();
            $stations = RoutesStation::where('schools_id', Session::get('school_id'))->where('id', $request->id)->first();
            $stations->name = $request->name;
            $stations->routes_id = $request->routes_id;
            $stations->save();
            DB::commit();
            return redirect()->to('/teacher-stations')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-stations')->with('error', 'Error Occured....!!!');
        }
    }

    public function teacherDeleteStations(Request $request)
    {

        try {
            DB::beginTransaction();
            RoutesStation::where('schools_id', Session::get('school_id'))->where('id', $request->id)->delete();
            DB::commit();
            return redirect()->to('/teacher-stations')->with('success', 'Successfuly....!!!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->to('/teacher-stations')->with('error', 'Error Occured....!!!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class RedirectController extends Controller
{
    public function manager(){
        $schools = School::where('manager_id',Auth::id())->get();
        return view('manager.index')->with('schools',$schools);
    }

    public function admin(){
        $admin = Admin::where('users_id',Auth::id())->first();
        $school = School::where('id',$admin->schools_id)->first();
        Session::put('school_id',$school->id);
        Session::put('school_name',$school->school_name);
        return view('admin.index');
    }
    public function superAdmin(){
        $data = User::all();
        return view('super_admin.index')->with('data',$data);
    }

   
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SchoolController extends Controller
{

  public function index(Request $request){
    $school = School::where('id',$request->scl)->first();
    Session::put('school_id',$school->id);
    Session::put('school_name',$school->school_name);
    return view('manager.school');
  }

    public function saveSchool(Request $request){
      $input = $request->all();
      $input['manager_id'] = Auth::id();
      School::create($input);
      $schools = School::where('manager_id',Auth::id())->get();
       return redirect()->to('/manager')->with('schools',$schools)->with('success','School Registered Successfully...');
    }

    public function homeDashboard(){
      return view('manager.school');
    }
}

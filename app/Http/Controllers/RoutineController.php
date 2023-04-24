<?php

namespace App\Http\Controllers;

use App\Models\StudentsRoutine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoutineController extends Controller
{
    public function index()
    {
        $data = StudentsRoutine::where('schools_id', Session::get('school_id'))->get();

        return view('teaching_staffs.school_activities.students_routine', compact('data'));
    }

    public function createRoutine(Request $request){
    }
}

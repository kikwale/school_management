<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentsRoutineController extends Controller
{
    public function teacherStudentsRoutine(){
        $data = [];
        return view('teaching_staffs.school_activities.students_routine')->with('data',$data);
    }
}

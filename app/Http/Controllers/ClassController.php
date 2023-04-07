<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\Darasa;
use App\Models\StreamOrComb;
use App\Models\StudentClass;
use App\Models\Term;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{

    public function adminCreateClasses(Request $request){
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        return view('admin.creates.classes')->with('data',$classes);
    }

    public function adminSaveClass(Request $request){

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['schools_id'] = Session::get('school_id');
            Darasa::create($input);
            DB::commit();
            return redirect()->to('admin-create-classes')->with('success','Created Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-classes')->with('error','Error occured');
        }
       
    }

    public function adminEditClass(Request $request){

        try {
            DB::beginTransaction();
            $class = Darasa::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
            $class['name'] = $request['name'];
            $class['numeric_name'] = $request['numeric_name'];
            $class['level'] = $request['level'];
            $class->save();
            DB::commit();
            return redirect()->to('admin-create-classes')->with('success','Edited Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-classes')->with('error','Error occured');
        }
       
    }

    public function adminDeleteClass(Request $request){

        try {

             Darasa::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
            return redirect()->to('admin-create-classes')->with('success','Deleted Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-classes')->with('error','Error occured');
        }
       
    }

    public function teacherClassMember(){
       
       $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
       $students = [];
       $mkondo = "";
       $darasa = ""; 
       $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
      
       $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();
       return view('teaching_staffs.results.class_member')
             ->with('classes',$classes)
             ->with('streams',$streams)
             ->with('current_year',$current_year)
             ->with('male_students','')
             ->with('female_students','')
             ->with('students',$students)
             ->with('index',1)
             ->with('darasa',$darasa)
             ->with('mkondo',$mkondo)
             ->with('total_students','');
    }


    public function teacherClassMembers(Request $request){

        try {
           
        $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
       
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();
        $class = Darasa::where('schools_id',Session::get('school_id'))
               ->where('id',$request->darasas_id)->first();
      
        $stream = StreamOrComb::where('schools_id',Session::get('school_id'))
               ->where('id',$request->streams_id)->first();
             
        $male_students = StudentClass::where('student_classes.schools_id',Session::get('school_id'))
                  ->where('students.gender','Male')
                  ->where('student_classes.academic_years_id',$current_year->id)
                  ->where('student_classes.isCompleted',false)
                  ->where('student_classes.darasas_id',$request->darasas_id)
                  ->where('student_classes.stream_or_combs_id',$request->streams_id)
                  ->join('students','students.id','=','student_classes.students_id')
                   ->count();
        $female_students = StudentClass::where('student_classes.schools_id',Session::get('school_id'))
                  ->where('students.gender','Female')
                  ->where('student_classes.academic_years_id',$current_year->id)
                  ->where('student_classes.isCompleted',false)
                  ->where('student_classes.darasas_id',$request->darasas_id)
                  ->where('student_classes.stream_or_combs_id',$request->streams_id)
                  ->join('students','students.id','=','student_classes.students_id')
                   ->count();

        $students = StudentClass::where('student_classes.schools_id',Session::get('school_id'))
                  ->where('student_classes.academic_years_id',$current_year->id)
                  ->where('student_classes.isCompleted',false)
                  ->where('student_classes.darasas_id',$request->darasas_id)
                  ->where('student_classes.stream_or_combs_id',$request->streams_id)
                  ->join('students','students.id','=','student_classes.students_id')
                   ->get();
        
        return view('teaching_staffs.results.class_member')
              ->with('classes',$classes)
              ->with('streams',$streams)
              ->with('current_year',$current_year)
              ->with('male_students',$male_students)
              ->with('female_students',$female_students)
              ->with('students',$students)
              ->with('index',1)
              ->with('darasa',$class->name)
              ->with('mkondo',$stream->name)
              ->with('total_students',($female_students+$male_students));
        } catch (\Throwable $th) {
            return back()->with('error','Error Occured....!!');
        }
      
    }


   
}

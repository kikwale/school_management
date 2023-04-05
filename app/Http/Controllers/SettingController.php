<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Contribution;
use App\Models\Darasa;
use App\Models\StreamOrComb;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{

    public function adminPromote(Request $request){
       
        $students = Student::where('schools_id',Session::get('school_id'))->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $contributions = Contribution::where('schools_id',Session::get('school_id'))->get();
        $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        return view('admin.settings.students_promotion')
               ->with('students',$students)
               ->with('classes',$classes)
               ->with('contributions',$contributions)
               ->with('year',$year);
       }

       public function adminSavePromote(Request $request){
//  return $request->all();
        try {
        $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('id',$request->academic_years_id)->first();
        $prev_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('year',$year->year - 1)->first();

        DB::beginTransaction();
 
        if ($request->class_to_id == 'COMPLETED') {
      
            StudentClass::where('schools_id',Session::get('school_id'))
            ->where('darasas_id',$request->class_from_id)
            ->where('stream_or_combs_id',$request->stream_id)
            ->where('academic_years_id',$prev_year->id)
            ->where('isCompleted',false)
            ->update(['isCompleted' => true ]);
            DB::commit();
            return redirect()->to('/admin-promote')->with('success','Students Completed Successfully...!!!');
        }
        $students_class = StudentClass::where('schools_id',Session::get('school_id'))
        ->where('darasas_id',$request->class_from_id)
        ->where('stream_or_combs_id',$request->stream_id)
        ->where('academic_years_id',$prev_year->id)
        ->where('isCompleted',false)
        ->get();

      
        foreach ($students_class as $student) {
        
            //check for students
            $students_check = StudentClass::where('schools_id',Session::get('school_id'))
            ->where('darasas_id',$request->class_to_id)
            ->where('students_id',$student->students_id)
            ->where('academic_years_id',$request->academic_years_id)
            ->where('isCompleted',false)
            ->first();
            if ($students_check) {
                continue;
            } else {
                $studentClass = new StudentClass();
                $studentClass->schools_id = Session::get('school_id');
                $studentClass->darasas_id = $request->class_to_id;
                $studentClass->students_id = $student->students_id;
                $studentClass->stream_or_combs_id = $student->stream_or_combs_id;
                $studentClass->academic_years_id = $request->academic_years_id;
                $studentClass->save();
                DB::commit();
            }
            
      
           
        }
            return redirect()->to('/admin-promote')->with('success','Students Promoted Successfully...!!!');
        } catch (\Throwable $th) {
           
            return redirect()->to('/admin-promote')->with('error','Error Encountered...!!!');
        }
       
        
       }

       public function getClasses(Request $request){
        $classes = Darasa::where('schools_id',Session::get('school_id'))->where('level',$request->level)->get();
        $output = '';
        $output .='
        <select onchange="classFromChanged(this.value)" required class=" form-control chzn-select" name="class_from_id" id="class_from_id" >
        <option value=""> Class From</option>
        ';
        foreach ($classes as $class) {
           $output .=' <option value="'.$class->id .'">'.$class->name.'</option>';
        }
        $output .=' </select>';
        return $output;
       }

       public function getClassesTo(Request $request){
        $class_from = Darasa::where('schools_id',Session::get('school_id'))->where('level',$request->level)
                    ->where('id',$request->class_from)->first();
        $classes_to = Darasa::where('schools_id',Session::get('school_id'))->where('level',$request->level)
                    ->where('numeric_name','>',$class_from->numeric_name)->get();
        $output = '';
        $output .='
        <select  required class=" form-control chzn-select" name="class_to_id" id="class_to_id" >
        <option value=""> Class To</option>
        ';
        foreach ($classes_to as $class) {
            $output .=' <option value="'.$class->id .'">'.$class->name.'</option>';
        }
        $output .='<option value="COMPLETED">COMPLETED</option>
        </select>';
        return $output;
       }
  

}

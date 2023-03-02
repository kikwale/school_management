<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\Fee;
use App\Models\Contribution;
use App\Models\StudentFeePayment;
use App\Models\StudentFee;
use App\Models\StudentClass;
use App\Models\StudentsResultSubmission;
use App\Models\ClassSubject;
use App\Models\StudentContribution;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class ResultsController extends Controller
{

    public function mgetClassSubjects(Request $request){
    
      $subjects = ClassSubject::where('class_subjects.darasas_id',$request->class_id)
      ->where('class_subjects.schools_id',Session::get('school_id'))
      ->join('subjects','subjects.id','=','class_subjects.subjects_id')
      ->get();
      Log::info($subjects);
      $output = '';
      $output .='<option value=""></option>';
      foreach($subjects as $subject){
       $output .='<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
      }
      return $output;
    }

    public function index(Request $request){
        
        $students = StudentClass::where('student_classes.darasas_id',$request->class_id)
                    ->where('student_classes.schools_id',Session::get('school_id'))
                    ->where('student_classes.isCurrent',true)
                    ->join('students','students.id','=','student_classes.students_id')
                    ->join('users','users.id','=','students.users_id')
                    ->get();
      
        $subjects = Subject::where('id',$request->subject_id)
                    ->where('schools_id',Session::get('school_id'))
                    ->get();

            $index = 1;
            $darasas_id = $request->class_id;
                return view('manager.results.results_form')
                    ->with('students',$students)
                    ->with('subjects',$subjects)
                    ->with('index',$index)
                    ->with('darasas_id',$request->class_id);
    }

    public function msaveStudentResults(Request $request){

        foreach($request['students_id'] as $key=>$student_id){
           $student = StudentsResultSubmission::where('darasas_id',$request->darasas_id)
            ->where('subjects_id',$request->subjects_id)
            ->where('students_id',$student_id)
            ->where('isCurrent',true)->first();
         if($student == "" && $request['marks'.$student_id] !=""){
            $student_result = new StudentsResultSubmission;
            $student_result->schools_id = Session::get('school_id');
            $student_result->darasas_id = $request->darasas_id;
            $student_result->students_id = $student_id;
            $student_result->subjects_id = $request->subjects_id;
            $student_result->mark = $request['marks'.$student_id];
            $student_result->year = $request->year;
            $student_result->submited_by = Auth::id();
            $student_result->save();
      
         } else {
            continue;
         }

        }
    
      return redirect()->to('/mget-list')->with('success','Results saved Successfuly......!');
    }

    public function mResultsList(){
        $classes = StudentsResultSubmission::
        select('students_result_submissions.darasas_id as darasas_id',
        'students_result_submissions.subjects_id as subjects_id',
        'darasas.class_name as class_name','darasas.level as level',
        'subjects.subject_name as subject_name')
        -> where('students_result_submissions.schools_id',Session::get('school_id'))
        ->where('students_result_submissions.isCurrent',true)
        ->where('students_result_submissions.submited_by',Auth::id())
        ->join('darasas','darasas.id','=','students_result_submissions.darasas_id')
        ->join('subjects','subjects.id','=','students_result_submissions.subjects_id')
        ->groupBy('darasas_id','subjects_id','class_name','level','subject_name')
        ->get();

    $index = 1;
    return view('manager.results.index')
            ->with('classes',$classes)
            ->with('index',$index);
    }

    public function meditResults(Request $request){
      $studentsResultSubmissions = StudentsResultSubmission::select(
        'students_result_submissions.students_id as students_id',
          'users.fname as fname','users.lname as lname','subjects.subject_name as subject_name',
          'students_result_submissions.mark as mark')
          ->where('students_result_submissions.darasas_id',$request->dar)
          ->where('students_result_submissions.subjects_id',$request->sub)
          ->where('students_result_submissions.schools_id',Session::get('school_id'))
          ->where('student_classes.isCurrent',true)
          ->join('student_classes','students_result_submissions.darasas_id','=','student_classes.darasas_id')
          ->join('darasas','students_result_submissions.darasas_id','=','darasas.id')
          ->join('subjects','subjects.id','=','students_result_submissions.subjects_id')
          ->join('students','students.id','=','students_result_submissions.students_id')
          ->join('users','users.id','=','students.users_id')
          ->groupBy('students_id','fname','lname','subject_name','mark')
          ->get();

        $subjects = Subject::where('id',$request->sub)
        ->where('schools_id',Session::get('school_id'))
        ->get();
        $index = 1;
        return view('manager.results.edit')
        ->with('studentsResultSubmissions',$studentsResultSubmissions)
        ->with('subjects',$subjects)
        ->with('index',$index)
        ->with('darasas_id',$request->dar)
        ->with('subjects_id',$request->sub);
    }

    public function meditStudentResults(Request $request){
 
      foreach($request['students_id'] as $key=>$student_id){
        $studentsResultSubmission = StudentsResultSubmission::where('subjects_id',$request->subjects_id)
        ->where('darasas_id',$request->darasas_id)->where('schools_id',Session::get('school_id'))
        ->where('students_id',$student_id)->first();
        $studentsResultSubmission->mark = $request['marks'.$student_id];
        $studentsResultSubmission->save();

      }

      return back()->with('success','Results edited Successfuly...!');
    }
}

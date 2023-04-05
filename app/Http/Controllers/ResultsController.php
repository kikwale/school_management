<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
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
use App\Models\StudentsResult;
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

  public function recordResults(Request $request){
    $teacher = Teacher::where('users_id',Auth::id())->first();
    $classes = StudentsResultSubmission::
    select(
    'students_result_submissions.students_results_id as id',
    'darasas.name as class_name','darasas.level as level',
    'subjects.name as subject_name')
    -> where('students_result_submissions.schools_id',Session::get('school_id'))
    ->where('academic_years.isCurrent',true)
    ->where('students_results.isOpen',false)
    ->where('students_result_submissions.submited_by',Auth::id())
    ->join('darasas','darasas.id','=','students_result_submissions.darasas_id')
    ->join('academic_years','academic_years.id','=','students_result_submissions.academic_years_id')
    ->join('subjects','subjects.id','=','students_result_submissions.subjects_id')
    ->join('students_results','students_results.id','=','students_result_submissions.students_results_id')
    ->groupBy('id','class_name','level','subject_name')
    ->get();
    $teacher_class_subjects = ClassSubject::select('darasas.name as name','darasas.id as id')
                           ->where('class_subjects.schools_id',Session::get('school_id'))
                           ->where('class_subjects.teachers_id',$teacher->id)
                           ->join('darasas','darasas.id','=','class_subjects.darasas_id')
                           ->groupBy('name','id')
                           ->get();
 
    return view('teaching_staffs.results.index')
    ->with('classes',$classes)->with('index',1)
    ->with('teacher_classes',$teacher_class_subjects);
  }

  public function getTeacherStream(Request $request){
    $teacher = Teacher::where('users_id',Auth::id())->first();
    $teacher_class_subjects = ClassSubject::select('subjects.name as subject_name','subjects.id as subject_id'
                              ,'stream_or_combs.name as stream_name',
                              'stream_or_combs.id as stream_id')
    ->where('class_subjects.schools_id',Session::get('school_id'))
    ->where('class_subjects.teachers_id',$teacher->id)
    ->where('class_subjects.darasas_id',$request->class_id)
    ->join('subjects','subjects.id','=','class_subjects.subjects_id')
    ->join('stream_or_combs','stream_or_combs.id','=','class_subjects.stream_or_combs_id')
    ->groupBy('subject_name','subject_id','stream_name','stream_id')
    ->get();
 
    $output ='';
 
    $output .= ' <div class="col-lg-6 col-sm-12 col-md-6">
    <label>Select Stream</label>
    <div class="form-group">
     <select onchange="getTeacherSubject(this.value)" required name="teacher_stream_id" id="teacher_stream_id" class="form-control">
      <option value="">Select Stream</option>';

      foreach ($teacher_class_subjects as $key => $teacher_class_subject) {
      $output .= '   <option value="'. $teacher_class_subject->stream_id .'">'.$teacher_class_subject->stream_name.'</option>';
      }
    $output .= '  </select> </div> </div>';
    return $output;
  }

  public function getTeacherSubject(Request $request){
    $teacher = Teacher::where('users_id',Auth::id())->first();
    $teacher_class_subjects = ClassSubject::select('subjects.name as subject_name','subjects.id as subject_id'
                              ,'stream_or_combs.name as stream_name',
                              'stream_or_combs.id as stream_id')
    ->where('class_subjects.schools_id',Session::get('school_id'))
    ->where('class_subjects.teachers_id',$teacher->id)
    ->where('class_subjects.darasas_id',$request->class_id)
    ->where('class_subjects.stream_or_combs_id',$request->stream_id)
    ->join('subjects','subjects.id','=','class_subjects.subjects_id')
    ->join('stream_or_combs','stream_or_combs.id','=','class_subjects.stream_or_combs_id')
    ->groupBy('subject_name','subject_id','stream_name','stream_id')
    ->get();
    $output ='';
    $output .= '<div class="col-lg-6 col-sm-12 col-md-6">
    <div class="form-group">
    <label>Select Subject</label>
     <select name="teacher_subject_id" id="teacher_subject_id" required class="form-control">
      <option value="">Select Subject</option>';

      foreach ($teacher_class_subjects as $key => $teacher_class_subject) {
      $output .= '   <option value="'. $teacher_class_subject->subject_id .'">'.$teacher_class_subject->subject_name.'</option>';
      }
    $output .= '  </select> </div> </div>';

    return $output;
  }

   public function getClassStudents(Request $request){
    //return $request->all();
    $year = AcademicYear::where('isCurrent',true)->where('schools_id',Session::get('school_id'))->first();
    $subject = Subject::where('schools_id',Session::get('school_id'))->where('id',$request->teacher_subject_id)->first();
    // return $subject;
    $students = StudentClass::where('student_classes.darasas_id',$request->teacher_class_id)
                ->where('student_classes.schools_id',Session::get('school_id'))
                ->where('student_classes.stream_or_combs_id',$request->teacher_stream_id)
                ->where('student_classes.academic_years_id',$year->id)
                ->join('students','students.id','=','student_classes.students_id')
                ->get();
    
    return view('teaching_staffs.results.results_form')->with('students',$students)
            ->with('darasa_id',$request->teacher_class_id)->with('stream_id',$request->teacher_stream_id)
            ->with('subject',$subject)
            ->with('index',1);
   }
   
    public function teacherSaveStudentResults(Request $request){
   
      DB::beginTransaction();
     try {
      $result = new StudentsResult;
      $result->darasas_id = $request->darasas_id;
      $result->year = $request->year_id;
      $result->schools_id = Session::get('school_id');
      $result->title = $request->title;
      $result->results_type = $request['results_type'];
      $result->terms_id = $request->terms_id;
      $result->save();
      DB::commit();
      $result_id = $result->id;

      foreach($request['students_id'] as $key=>$student_id){
      
      
         $student_result = new StudentsResultSubmission;
         $student_result->schools_id = Session::get('school_id');
         $student_result->students_results_id = $result_id;
         $student_result->darasas_id = $request->darasas_id;
         $student_result->students_id = $student_id;
         $student_result->subjects_id = $request->subjects_id;
         $student_result->stream_or_combs_id = $request->streams_id;
         $student_result->mark = $request['marks'.$student_id];
         $student_result->academic_years_id = $request->year_id;
         $student_result->submited_by = Auth::id();
         $student_result->save();
         DB::commit();
   

     }
     return redirect()->to('/record-results')->with('success','Results Recoreded Successfuly.........!!!');
     } catch (\Throwable $th) {
      return $th;
      return redirect()->to('/record-results')->with('error','Error Occured........!!!');
     }
    }

    public function teacherEditResults(Request $request){
    
   //return $request->all();
   $year = AcademicYear::where('isCurrent',true)->where('schools_id',Session::get('school_id'))->first();
   $result = StudentsResult::where('students_results.schools_id',Session::get('school_id'))->
             join('terms','terms.id','=','students_results.terms_id')->where('students_results.id',$request->id)->first();
   // return $subject;
   $students = StudentsResultSubmission::where('students_result_submissions.students_results_id',$request->id)
               ->where('students_results.isOpen',false)
               ->where('students_result_submissions.schools_id',Session::get('school_id'))
               ->join('students_results','students_results.id','=','students_result_submissions.students_results_id')
               ->join('students','students.id','=','students_result_submissions.students_id')
               ->get();
   return view('teaching_staffs.results.edit')->with('students',$students)
           ->with('result',$result)
           ->with('id',$request->id)
           ->with('index',1);
    }

    public function teacherEditStudentsResults(Request $request){
      //return $request->all();
      DB::beginTransaction();
      try {
       $result = StudentsResult::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
    
       $result->title = $request->title;
       $result->results_type = $request['results_type'];
       $result->terms_id = $request->terms_id;
       $result->save();
       DB::commit();
       $result_id = $result->id;
 
       foreach($request['students_id'] as $key=>$student_id){
       
       
          $student_result = StudentsResultSubmission::where('students_results_id',$request->id)
                           ->where('academic_years_id',$request->year_id)
                           ->where('students_id',$student_id)->where('schools_id',Session::get('school_id'))->first();
        
          $student_result->mark = $request['marks'.$student_id];
          $student_result->academic_years_id = $request->year_id;
          $student_result->save();
          DB::commit();
    
 
      }
      return back()->with('success','Results Edited Successfuly.........!!!');
      } catch (\Throwable $th) {
     
       return back()->with('error','Error Occured........!!!');
      }
    }





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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\Darasa;
use App\Models\StreamOrComb;
use App\Models\StudentRollCall;
use App\Models\RollCall;
use App\Models\StudentClass;
use App\Models\ClassSubject;
use App\Models\Subject;
use App\Models\Term;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AttendenceController extends Controller
{
    public function teacherRollcall(){
        $teacher = Teacher::where('schools_id',Session::get('school_id'))->where('users_id',Auth::id())->first();
        // $teacher_class = RollCall::
        //                where('rollcalls.schools_id',Session::get('school_id'))
        //                ->where('student_roll_calls.submited_by',Auth::id())
        //                ->join('student_roll_calls','student_roll_calls.rollcalls_id','=','rollcalls.id')
        //                ->join('darasas','darasas.id','=','rollcalls.darasas_id')
        //                ->join('subjects','subjects.id','=','rollcalls.subjects_id')
        //                ->join('stream_or_combs','stream_or_combs.id','=','rollcalls.stream_or_combs_id')
        //                ->get();
        $teacher_class = [];
        $classes = ClassSubject::where('class_subjects.schools_id',Session::get('school_id'))
                 ->where('class_subjects.teachers_id',$teacher->id)
                 ->select('darasas.id as id','darasas.name as name')
                 ->join('darasas','darasas.id','=','class_subjects.darasas_id')
                 ->groupBy('id','name')
                 ->get();
        return view('teaching_staffs.attendence.rollcall')->with('rollcalls',$teacher_class)
              ->with('index',1)->with('classes',$classes);
    }

    public function teacherRollcallStudents(Request $request){
        $academic_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
       
        $students = StudentClass::where('student_classes.schools_id',Session::get('school_id'))
                  ->where('student_classes.darasas_id',$request->teacher_class_id)
                  ->where('student_classes.stream_or_combs_id',$request->teacher_stream_id)
                  ->where('student_classes.academic_years_id',$academic_year->id)
                  ->join('students','students.id','=','student_classes.students_id')->get();
                 // return $students;
        $subject = Subject::where('schools_id',Session::get('school_id'))->where('id',$request->teacher_subject_id)->first();
       
        return view('teaching_staffs.attendence.rollcall_data')
               ->with('teacher_class_id',$request->teacher_class_id)
               ->with('teacher_stream_id',$request->teacher_stream_id)
               ->with('students',$students)
               ->with('subject',$subject)
               ->with('index',1)
               ->with('academic_year_id',$academic_year->id)
               ->with('teacher_subject_id',$request->teacher_subject_id);
       
    }

    public function teacherSaveStudentRollcall(Request $request){

        try {

            DB::beginTransaction();
            $rollcall = new RollCall();
            $rollcall->schools_id = Session::get('school_id');
            $rollcall->academic_years_id = $request->academic_years_id;
            $rollcall->darasas_id = $request->darasas_id;
            $rollcall->stream_or_combs_id = $request->stream_or_combs_id;
            $rollcall->subjects_id = $request->subjects_id;
            $rollcall->date = $request->date;
            $rollcall->save();
            DB::commit();
            $rollcalls_id = $rollcall->id;

            foreach ($request['students_id'] as $key => $student_id) {
             $student_rollcall = new StudentRollCall();
             $student_rollcall['schools_id'] = Session::get('school_id');
             $student_rollcall['rollcalls_id'] = $rollcalls_id;
             $student_rollcall['students_id'] = $student_id;
             $student_rollcall['status'] = $request['status'.$student_id];
             $student_rollcall['submited_by'] = Auth::id();
             $student_rollcall->save();
             DB::commit();
            }
            return redirect()->to('/teacher-rollcall')->with('success','Successfuly Rollcall is Done....!!!');
        } catch (\Throwable $th) {
            return redirect()->to('/teacher-rollcall')->with('error','Error Occured...!!!');
        }
  
        return $request->all();
    }
}

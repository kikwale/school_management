<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassSubject;
use App\Models\Darasa;
use App\Models\StreamOrComb;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OperationController extends Controller
{
    public function adminClassStudents(Request $request){
        $students = Student::where('schools_id',Session::get('school_id'))->where('isNew',true)->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();
        $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        return view('admin.operations.class_students')
                ->with('data',$students)
                ->with('classes',$classes)
                ->with('streams',$streams)
                ->with('year',$year);
    
    }
    
    public function adminSaveClassStudents(Request $request){
     
         try {
            DB::beginTransaction();
          
           foreach($request['students_id'] as $student_id){
            $class_students = new StudentClass();
            $class_students['schools_id'] = Session::get('school_id');
            $class_students['darasas_id'] = $request['darasas_id'];
            $class_students['students_id'] = $student_id;
            $class_students['academic_years_id'] = $request['academic_years_id'];
            $class_students['stream_or_combs_id'] = $request['stream_or_combs_id'];
            $class_students->save();
            Student::where('schools_id',Session::get('school_id'))->where('id',$student_id)->update(['isNew'=>false]);
            DB::commit();
           }
           return redirect()->to('/admin-class-students')->with('success','Students Registerd Successfuly...!!!');
         } catch (\Throwable $th) {
            return $th;
            return redirect()->to('/admin-class-students')->with('error','Error Occured');
         }
        
    }
    
      public function adminClassSubjects(Request $request){
       $class_subjects = ClassSubject::select(
        'class_subjects.id as id',
        'class_subjects.darasas_id as darasas_id',
        'class_subjects.teachers_id as teachers_id',
        'class_subjects.stream_or_combs_id as stream_or_combs_id',
        'class_subjects.subjects_id as subjects_id',
        'darasas.name as class_name',
       'darasas.level as level',
       'users.fname as fname',
       'subjects.name as subject_name',
       'users.lname as lname',
       'class_subjects.status as status',
       'stream_or_combs.name as stream_name'
       )
       ->join('darasas','darasas.id','=','class_subjects.darasas_id')
       ->join('teachers','teachers.id','=','class_subjects.teachers_id')
       ->join('stream_or_combs','stream_or_combs.id','=','class_subjects.stream_or_combs_id')
       ->join('subjects','subjects.id','=','class_subjects.subjects_id')
       ->join('users','users.id','=','teachers.users_id')
       ->where('class_subjects.schools_id',Session::get('school_id'))->get();
       $subjects = Subject::where('schools_id',Session::get('school_id'))->get();
       $teachers = Teacher::select('users.fname as fname',
                           'users.lname as lname',
                           'teachers.id as id')
                   ->where('teachers.schools_id',Session::get('school_id'))
                  ->join('users','users.id','=','teachers.users_id')->get();
       $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
       $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();
       $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
       return view('admin.operations.class_subjects')->with('data',$class_subjects)
              ->with('subjects',$subjects)
              ->with('teachers',$teachers)
              ->with('classes',$classes)
              ->with('streams',$streams)
              ->with('year',$year);
      }

      public function adminSaveClassSubjects(Request $request){
        try {
            DB::beginTransaction();
            foreach($request['subjects_id'] as $subject_id){
                $class_subject = new ClassSubject;
                $class_subject['schools_id'] = Session::get('school_id');
                $class_subject['darasas_id'] = $request->darasas_id;
                $class_subject['teachers_id'] = $request->teachers_id;
                $class_subject['stream_or_combs_id'] = $request->stream_or_combs_id;
                $class_subject['status'] = $request->status;
                $class_subject['subjects_id'] = $subject_id;
                $class_subject->save();
                DB::commit();
            }
            return redirect()->to('/admin-class-subjects')->with('success','Saved Successfuly....!!');
        } catch (\Throwable $th) {
            return redirect()->to('/admin-class-subjects')->with('error','Error Occured');
        }

      }
      public function adminEditClassSubjects(Request $request){
        try {
            DB::beginTransaction();
           
                $class_subject = ClassSubject::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                $class_subject['darasas_id'] = $request->darasas_id;
                $class_subject['teachers_id'] = $request->teachers_id;
                $class_subject['stream_or_combs_id'] = $request->stream_or_combs_id;
                $class_subject['status'] = $request->status;
                $class_subject['subjects_id'] = $request->subjects_id;
                $class_subject->save();
                DB::commit();
          
            return redirect()->to('/admin-class-subjects')->with('success','Edited Successfuly....!!');
        } catch (\Throwable $th) {
            return redirect()->to('/admin-class-subjects')->with('error','Error Occured');
        }

      }
      public function adminDeleteClassSubjects(Request $request){
        try {
            DB::beginTransaction();
            ClassSubject::where('schools_id',Session::get('school_id'))->where('id',$request->id)->delete();
            DB::commit();
            return redirect()->to('/admin-class-subjects')->with('success','Deleted Successfuly....!!');
        } catch (\Throwable $th) {
            return redirect()->to('/admin-class-subjects')->with('error','Error Occured');
        }

      }
    
      public function adminClassTeachers(Request $request){
        $class_teachers = TeacherClass::select(
         'teacher_classes.id as id',
         'teacher_classes.darasas_id as darasas_id',
         'teacher_classes.teachers_id as teachers_id',
         'teacher_classes.stream_or_combs_id as stream_or_combs_id',
         'darasas.name as class_name',
        'darasas.level as level',
        'users.fname as fname',
        'users.lname as lname',
        'stream_or_combs.name as stream_name'
        )
        ->join('darasas','darasas.id','=','teacher_classes.darasas_id')
        ->join('teachers','teachers.id','=','teacher_classes.teachers_id')
        ->join('stream_or_combs','stream_or_combs.id','=','teacher_classes.stream_or_combs_id')
        ->join('users','users.id','=','teachers.users_id')
        ->where('teacher_classes.schools_id',Session::get('school_id'))->get();
        $teachers = Teacher::select('users.fname as fname',
                            'users.lname as lname',
                            'teachers.id as id')
                    ->where('teachers.schools_id',Session::get('school_id'))
                   ->join('users','users.id','=','teachers.users_id')->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();
        $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        return view('admin.operations.class_teachers')->with('data',$class_teachers)
               ->with('teachers',$teachers)
               ->with('classes',$classes)
               ->with('streams',$streams)
               ->with('year',$year);
       }
 
       public function adminSaveClassTeacher(Request $request){
        
         try {
             DB::beginTransaction();
                $class_teacher = TeacherClass::where('schools_id',Session::get('school_id'))
                                ->where('teachers_id',$request->teachers_id)->where('darasas_id',$request->darasas_id)
                                ->where('stream_or_combs_id',$request->stream_or_combs_id)->first();
                if($class_teacher){
                    return redirect()->to('/admin-class-teachers')->with('error','Teacher has already Registrered');
                }
                 $class_teacher = new TeacherClass;
                 $class_teacher['schools_id'] = Session::get('school_id');
                 $class_teacher['darasas_id'] = $request->darasas_id;
                 $class_teacher['teachers_id'] = $request->teachers_id;
                 $class_teacher['stream_or_combs_id'] = $request->stream_or_combs_id;
                 $class_teacher->save();
                 DB::commit();
          
             return redirect()->to('/admin-class-teachers')->with('success','Saved Successfuly....!!');
         } catch (\Throwable $th) {
             return redirect()->to('/admin-class-teachers')->with('error','Error Occured');
         }
 
       }
       public function adminEditClassTeacher(Request $request){
         try {
             DB::beginTransaction();
            
                 $class_subject = TeacherClass::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                 $class_subject['darasas_id'] = $request->darasas_id;
                 $class_subject['teachers_id'] = $request->teachers_id;
                 $class_subject['stream_or_combs_id'] = $request->stream_or_combs_id;
                 $class_subject->save();
                 DB::commit();
           
             return redirect()->to('/admin-class-teachers')->with('success','Edited Successfuly....!!');
         } catch (\Throwable $th) {
             return redirect()->to('/admin-class-teachers')->with('error','Error Occured');
         }
 
       }
       public function adminDeleteClassTeacher(Request $request){
         try {
             DB::beginTransaction();
             TeacherClass::where('schools_id',Session::get('school_id'))->where('id',$request->id)->delete();
             DB::commit();
             return redirect()->to('/admin-class-teachers')->with('success','Deleted Successfuly....!!');
         } catch (\Throwable $th) {
             return redirect()->to('/admin-class-teachers')->with('error','Error Occured');
         }
 
       }
}

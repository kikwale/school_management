<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\ClassSubject;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class TeachersController extends Controller
{

    public function adminTeachingStaffs(Request $request){
     
        $teachers = Teacher::where('teachers.schools_id',Session::get('school_id'))
        ->join('users','users.id','=','teachers.users_id')->get();
        return view('admin.staffs.teaching_staffs.index')->with('data',$teachers);
    }

    public function adminSaveTeacher(Request $request){
    
        DB::beginTransaction();
          
        try {
 
         $validator = Validator::make($request->all(), [
             'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
         ]);
       
         if ($validator->fails()) {
             $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500 ";
             return redirect()->to('admin-teaching-staffs')->with('error',$error);
         }
         if($request->file()){
             
             $file = $request->file('file');
             $fileName = 'Teacher'.time().'.'.$request->file->extension();
             $file_location = 'school'.'_'.Session::get('school_id').'_'.'user';
            // $filePath = $request->file('file')->storeAs('school'.'_'.Session::get('school_id').'_'.'user', $fileName, 'public');
             $file_path = $file->move($file_location,$fileName);
             $user = new User();
             $user->fname = $request->fname;
             $user->mname = $request->mname;
             $user->lname = $request->lname;
             $user->gender = $request->gender;
             $user->phone = $request->phone;
             $user->email = $request->email;
             $user->photo = $file_path;
             $user->role = $request->role; 
             $user->password = Hash::make($request->phone);
             $user->save();
             $user_id = $user->id;
 
             $teacher = new Teacher();
             $teacher->users_id = $user_id;
             $teacher->schools_id = Session::get('school_id');
             $teacher->salary = $request['salary'];
             $teacher->edu_level = $request['edu_level'];
             $teacher->address	 = $request['address'];
             $teacher->national_id = $request['national_id'];
             $teacher->save();
             DB::commit();
             return redirect()->to('admin-teaching-staffs')->with('success','Teacher saved Successfuly..!');
         } else{
            $user = new User();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role; 
            $user->password = Hash::make($request->phone);
            $user->save();
            $user_id = $user->id;

            $teacher = new Teacher();
            $teacher->users_id = $user_id;
            $teacher->schools_id = Session::get('school_id');
            $teacher->salary = $request['salary'];
            $teacher->edu_level = $request['edu_level'];
            $teacher->address	 = $request['address'];
            $teacher->national_id = $request['national_id'];
            $teacher->save();
            DB::commit();
             return redirect()->to('admin-teaching-staffs')->with('success','Teacher saved Successfuly..!');
         }
        } catch (\Throwable $th) {
         return redirect()->to('admin-teaching-staffs')->with('error','Error occured');
        }
    }

    public function adminEditTeacher(Request $request){

        DB::beginTransaction();
          
        try {
 
         $validator = Validator::make($request->all(), [
             'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
         ]);
       
         if ($validator->fails()) {
             $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500";
             return redirect()->to('admin-teaching-staffs')->with('error',$error);
         }
         if($request->file()){
            if ($request->file_name != "") {
             unlink($request->file_name);
            }
             $file = $request->file('file');
             $fileName = 'Teacher'.time().'.'.$request->file->extension();
             $file_location = 'school'.'_'.Session::get('school_id').'_'.'user';
            // $filePath = $request->file('file')->storeAs('school'.'_'.Session::get('school_id').'_'.'user', $fileName, 'public');
             $file_path = $file->move($file_location,$fileName);
             $user = User::where('id',$request->id)->first();
             $user->fname = $request->fname;
             $user->mname = $request->mname;
             $user->lname = $request->lname;
             $user->gender = $request->gender;
             $user->phone = $request->phone;
             $user->email = $request->email;
             $user->photo = $file_path;
             $user->role = $request->role;
             $user->save();

             $teacher = Teacher::where('users_id',$request->id)->first();
             $teacher->salary = $request['salary'];
             $teacher->edu_level = $request['edu_level'];
             $teacher->address	 = $request['address'];
             $teacher->national_id = $request['national_id'];
             $teacher->save();
             DB::commit();
             return redirect()->to('admin-teaching-staffs')->with('success','Teacher Edited Successfuly..!');
         } else{
            $user = User::where('id',$request->id)->first();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();

            $teacher = Teacher::where('users_id',$request->id)->first();
            $teacher->salary = $request['salary'];
            $teacher->edu_level = $request['edu_level'];
            $teacher->address	 = $request['address'];
            $teacher->national_id = $request['national_id'];
            $teacher->save();
            DB::commit();
             return redirect()->to('admin-teaching-staffs')->with('success','Teacher Edited Successfuly..!');
         }
        } catch (\Throwable $th) {
         return redirect()->to('admin-teaching-staffs')->with('error','Error occured');
        }
      
    }

    public function adminDeleteTeacher(Request $request){
        User::where('id',$request->id)->delete();
        Teacher::where('users_id',$request->id)->delete();
        if ($request->file_name != "") {
            unlink($request->file_name);
           }
        return redirect()->to('admin-teaching-staffs')->with('success','Teacher Deleted Successfuly..!');
    }

    public function mteachers(){
        $teachers = Teacher::where('teachers.schools_id',Session::get('school_id'))
                    ->join('users','users.id','=','teachers.users_id')->get();
        return view('manager.teachers.index')->with('data',$teachers);
    }

    public function msaveTeacher(Request $request){
        $user = new User;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->phone);
        $user->save();
        $user_id = $user->id;

        $teacher = [];
        $teacher = $request->all();
        $teacher['users_id'] = $user->id;
        $teacher['schools_id'] = Session::get('school_id');
        Teacher::create($teacher);
        return redirect()->to('/mteachers')->with('success','New Teacher created Successfuly...!');
    }

    public function meditTeacher(Request $request){

        $user = User::where('id',$request->user_id)->first();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        $teacher = Teacher::where('users_id',$request->user_id)->where('schools_id',Session::get('school_id'))->first();
        $teacher->edu_level = $request->edu_level;
        $teacher->salary = $request->salary;
        $teacher->save();
        return redirect()->to('/mteachers')->with('success','Teacher Edited Successfuly...!');
    }

    public function mdeleteTeacher(Request $request){
        User::where('id',$request->teacher_id)->delete();
        Teacher::where('users_id',$request->teacher_id)->where('schools_id',Session::get('school_id'))->delete();
        return redirect()->to('/mteachers')->with('success','Teacher is Deleted Successfuly...!');
    }

    public function msettingTeacherClass(){
        $teachers_class = TeacherClass::select('teacher_classes.id as id',
        'teacher_classes.darasas_id as darasas_id',
        'teacher_classes.teachers_id as teachers_id',
        'teacher_classes.subjects_id as subjects_id',
        'teacher_classes.teacher_position as teacher_position',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname',
        'darasas.class_name as class_name',
        'darasas.level as level',
        'subjects.subject_name as subject_name'
        )->where('teacher_classes.schools_id',Session::get('school_id'))
        ->join('teachers','teachers.id','=','teacher_classes.teachers_id')
        ->join('darasas','darasas.id','=','teacher_classes.darasas_id')
        ->join('subjects','subjects.id','=','teacher_classes.subjects_id')
        ->join('users','users.id','=','teachers.users_id')->get();

        $teachers = User::where('teachers.schools_id',Session::get('school_id'))
        ->join('teachers','users.id','=','teachers.users_id')->get();

        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $subjects = Subject::where('schools_id',Session::get('school_id'))->get();

       return view('manager.teachers.class')->with('data',$teachers_class)
                                            ->with('teachers',$teachers)
                                            ->with('subjects',$subjects)
                                            ->with('classes',$classes);
    }

 
    public function msaveSettingTeacherClass(Request $request){
     
        $info = [];
        $info['schools_id'] = Session::get('school_id');
        $info['darasas_id'] = $request->darasas_id;
        $info['teachers_id'] = $request->teachers_id;
        $info['teacher_position'] = $request->teacher_position;
    
    foreach($request['subjects_id'] as $key=>$subjects_id){
       $info['subjects_id'] = $subjects_id;
      
       TeacherClass::create($info);
     }
     return redirect()->to('/msetting-teacher-class')->with('success','Data saved Successfuly...!');
    }
    
    public function meditSettingTeacherClass(Request $request){
       
        $class_subject = TeacherClass::where('id',$request->id)
                                    ->where('schools_id',Session::get('school_id'))
                                    ->first();
        $class_subject->darasas_id = $request->darasas_id;                    
        $class_subject->subjects_id = $request->subjects_id;                    
        $class_subject->teacher_position = $request->teacher_position;                      
        $class_subject->save();
        
        return redirect()->to('/msetting-teacher-class')->with('success','Data Edited Successfuly...!');                
    }
    
    public function mdeleteSettingTeacherClass(Request $request){
        TeacherClass::where('id',$request->id)
        ->where('schools_id',Session::get('school_id'))
        ->delete();
        return redirect()->to('/msetting-teacher-class')->with('success','Data Deleted Successfuly...!');   
    }

    public function mfilterSubjects(Request $request){
        $subjects =  ClassSubject::select('subjects.id as id',
        'class_subjects.darasas_id as darasas_id',
        'class_subjects.subjects_id as subjects_id',
        'subjects.subject_name as subject_name'
        )->where('class_subjects.schools_id',Session::get('school_id'))
        ->where('class_subjects.darasas_id',$request->darasas_id)
        ->join('subjects','subjects.id','=','class_subjects.subjects_id')
        ->join('darasas','darasas.id','=','class_subjects.darasas_id')
        ->get();
  Log::info($subjects);
        
      
        if($subjects != ""){
            $output = '';
            $output .='
            <div class="form-group" >
            <label>Teaching Subject</label>
            <select required name="subjects_id[]" id="subjects_id" class="tagging form-select form-control" multiple>
           ';
            foreach ($subjects as $subject){
             $output .='<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
            }
            
           $output .=' </select>
                    </div>';
          return $output;
        }else{
            return 'no data';
        }
        
    }
}

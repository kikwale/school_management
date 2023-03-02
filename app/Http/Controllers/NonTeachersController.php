<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Worker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NonTeachersController extends Controller
{
    public function adminNonTeachingStaffs (Request $request){
     
        $teachers = Worker::where('workers.schools_id',Session::get('school_id'))
        ->join('users','users.id','=','workers.users_id')->get();
        return view('admin.staffs.non_teaching_staffs.index')->with('data',$teachers);
    }

    public function adminSaveNonTeacher(Request $request){
    
        DB::beginTransaction();
          
        try {
 
         $validator = Validator::make($request->all(), [
             'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
         ]);
       
         if ($validator->fails()) {
             $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500 ";
             return redirect()->to('admin-non-teaching-staffs')->with('error',$error);
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
 
             $teacher = new Worker();
             $teacher->users_id = $user_id;
             $teacher->schools_id = Session::get('school_id');
             $teacher->salary = $request['salary'];
             $teacher->edu_level = $request['edu_level'];
             $teacher->address	 = $request['address'];
             $teacher->national_id = $request['national_id'];
             $teacher->save();
             DB::commit();
             return redirect()->to('admin-non-teaching-staffs')->with('success','Teacher saved Successfuly..!');
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

            $teacher = new Worker();
            $teacher->users_id = $user_id;
            $teacher->schools_id = Session::get('school_id');
            $teacher->salary = $request['salary'];
            $teacher->edu_level = $request['edu_level'];
            $teacher->address	 = $request['address'];
            $teacher->national_id = $request['national_id'];
            $teacher->save();
            DB::commit();
             return redirect()->to('admin-non-teaching-staffs')->with('success','Teacher saved Successfuly..!');
         }
        } catch (\Throwable $th) {
         return redirect()->to('admin-non-teaching-staffs')->with('error','Error occured');
        }
    }

    public function adminEditNonTeacher(Request $request){

        DB::beginTransaction();
          
        try {
 
         $validator = Validator::make($request->all(), [
             'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
         ]);
       
         if ($validator->fails()) {
             $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500";
             return redirect()->to('admin-non-teaching-staffs')->with('error',$error);
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

             $teacher = Worker::where('users_id',$request->id)->first();
             $teacher->salary = $request['salary'];
             $teacher->edu_level = $request['edu_level'];
             $teacher->address	 = $request['address'];
             $teacher->national_id = $request['national_id'];
             $teacher->save();
             DB::commit();
             return redirect()->to('admin-non-teaching-staffs')->with('success','Teacher Edited Successfuly..!');
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

            $teacher = Worker::where('users_id',$request->id)->first();
            $teacher->salary = $request['salary'];
            $teacher->edu_level = $request['edu_level'];
            $teacher->address	 = $request['address'];
            $teacher->national_id = $request['national_id'];
            $teacher->save();
            DB::commit();
             return redirect()->to('admin-non-teaching-staffs')->with('success','Teacher Edited Successfuly..!');
         }
        } catch (\Throwable $th) {
         return redirect()->to('admin-non-teaching-staffs')->with('error','Error occured');
        }
      
    }

    public function adminDeleteNonTeacher(Request $request){
        User::where('id',$request->id)->delete();
        Worker::where('users_id',$request->id)->delete();
        if ($request->file_name != "") {
            unlink($request->file_name);
           }
        return redirect()->to('admin-non-teaching-staffs')->with('success','Teacher Deleted Successfuly..!');
    }



    public function mNonTeachers(Request $request){
        $non_teachers = Worker::where('workers.schools_id',Session::get('school_id'))
        ->join('users','users.id','=','workers.users_id')->get();
       return view('manager.non_teachers.index')->with('data',$non_teachers);
    }

    public function msaveNonTeacher(Request $request){
        $user = new User;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = $request->position;
        $user->password = Hash::make($request->phone);
        $user->save();
        $user_id = $user->id;

        $non_teacher = [];
        $non_teacher = $request->all();
        $non_teacher['users_id'] = $user->id;
        $non_teacher['schools_id'] = Session::get('school_id');
        Worker::create($teacher);
        return redirect()->to('/mnon-teachers')->with('success','New Worker created Successfuly...!');
    }

    public function meditNonTeacher(Request $request){

        $user = User::where('id',$request->user_id)->first();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();
        $non_teacher = Worker::where('users_id',$request->user_id)->where('schools_id',Session::get('school_id'))->first();
        $non_teacher->salary = $request->salary;
        $non_teacher->save();
        return redirect()->to('/mnon-teachers')->with('success','Employee Edited Successfuly...!');
    }

    public function mdeleteNonTeacher(Request $request){
        User::where('id',$request->non_teacher_id)->delete();
        Worker::where('users_id',$request->non_teacher_id)->where('schools_id',Session::get('school_id'))->delete();
        return redirect()->to('/mnon-teachers')->with('success','Employee is Deleted Successfuly...!');
    }

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentsParent;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Wazazi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ParentsController extends Controller
{

    public function adminParents(Request $request){
        $parents = Wazazi::where('wazazis.schools_id',Session::get('school_id'))
        ->join('users','users.id','=','wazazis.users_id')->get();
        $students = Student::where('schools_id',Session::get('school_id'))->get();
       return view('admin.admissions.parents')->with('data',$parents)->with('parents',$parents)->with('students',$students);
    }

    public function studentsParent(Request $request){
        $parents = Wazazi::select('users.fname as fname','users.lname as lname','wazazis.id as id')->where('wazazis.schools_id',Session::get('school_id'))
        ->join('users','users.id','=','wazazis.users_id')->get();
        $students = Student::where('schools_id',Session::get('school_id'))->get();
       return view('admin.admissions.students_parent')->with('data',$parents)->with('parents',$parents)->with('students',$students);
    }

    public function adminSaveStudentsParent(Request $request){

        try {
            DB::beginTransaction();
            foreach ($request['students_id'] as $key => $student_id) {
            $students_parent= new StudentsParent();
            $students_parent->schools_id = Session::get('school_id');
            $students_parent->wazazis_id = $request->wazazis_id;
            $students_parent->students_id = $student_id;
            $students_parent->relation = $request->relation;
            $students_parent->save();
            DB::commit();
            }
            return redirect()->to('admin-students-parent')->with('success','Parent Students saved Successfuly..!');

        } catch (\Throwable $th) {
            return redirect()->to('admin-students-parent')->with('error','Error occured');
        }
  
    }

    public function adminSaveParent(Request $request){
      
        DB::beginTransaction();
          
        try {
 
         $validator = Validator::make($request->all(), [
             'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
         ]);
       
         if ($validator->fails()) {
             $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500 ";
             return redirect()->to('admin-parents')->with('error',$error);
         }
         if($request->file()){
             
             $file = $request->file('file');
             $fileName = 'Parent'.time().'.'.$request->file->extension();
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
             $user->role = 'Parent';
             $user->password = Hash::make($request->phone);
             $user->save();
             $user_id = $user->id;
 
             $parent = new Wazazi();
             $parent->users_id = $user_id;
             $parent->schools_id = Session::get('school_id');
             $parent->employment_status = $request['employment_status'];
             $parent->address	 = $request['address'];
             $parent->institute = $request['institute'];
             $parent->position = $request['position'];
             $parent->work = $request['work'];
             $parent->save();
             DB::commit();
             return redirect()->to('admin-parents')->with('success','Parent saved Successfuly..!');
         } else{
            $user = new User();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = 'Parent';
            $user->password = Hash::make($request->phone);
            $user->save();
            $user_id = $user->id;

            $parent = new Wazazi();
            $parent->users_id = $user_id;
            $parent->schools_id = Session::get('school_id');
            $parent->employment_status = $request['employment_status'];
            $parent->address	 = $request['address'];
            $parent->institute = $request['institute'];
            $parent->position = $request['position'];
            $parent->work = $request['work'];
            $parent->save();
            DB::commit();
             return redirect()->to('admin-parents')->with('success','Parent saved Successfuly..!');
         }
        } catch (\Throwable $th) {
         return redirect()->to('admin-parents')->with('error','Error occured');
        }
    }

    public function adminEditParent(Request $request){

        DB::beginTransaction();
          
        try {
 
         $validator = Validator::make($request->all(), [
             'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
         ]);
       
         if ($validator->fails()) {
             $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500";
             return redirect()->to('admin-parents')->with('error',$error);
         }
         if($request->file()){
            if ($request->file_name != "") {
             unlink($request->file_name);
            }
             $file = $request->file('file');
             $fileName = 'Parent'.time().'.'.$request->file->extension();
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
             $user->role = 'Parent';
             $user->save();

             $parent = Wazazi::where('users_id',$request->id)->first();
             $parent->employment_status = $request['employment_status'];
             $parent->address	 = $request['address'];
             $parent->institute = $request['institute'];
             $parent->position = $request['position'];
             $parent->work = $request['work'];
             $parent->save();
             DB::commit();
             return redirect()->to('admin-parents')->with('success','Parent Edited Successfuly..!');
         } else{
            $user = User::where('id',$request->id)->first();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = 'Parent';
            $user->save();

            $parent = Wazazi::where('users_id',$request->id)->first();
            $parent->employment_status = $request['employment_status'];
            $parent->address	 = $request['address'];
            $parent->institute = $request['institute'];
            $parent->position = $request['position'];
            $parent->work = $request['work'];
            $parent->save();
            DB::commit();
             return redirect()->to('admin-parents')->with('success','Teacher Edited Successfuly..!');
         }
        } catch (\Throwable $th) {
         return redirect()->to('admin-parents')->with('error','Error occured');
        }
      
    }

    public function adminDeleteParent(Request $request){
        User::where('id',$request->id)->delete();
        Wazazi::where('users_id',$request->id)->delete();
        if ($request->file_name != "") {
            unlink($request->file_name);
           }
        return redirect()->to('admin-parents')->with('success','Parent Deleted Successfuly..!');
    }


    public function msaveParent(Request $request){
       
        $user = new User;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = 'Parent';
        $user->password = Hash::make($request->phone);
        $user->save();
        $user_id = $user->id;

        $parent = [];
        $parent = $request->all();
        $parent['users_id'] = $user->id;
        $parent['schools_id'] = Session::get('school_id');
        Wazazi::create($parent);
        return redirect()->to('/mparents')->with('success','New Parent created Successfuly...!');
    }

    public function meditParent(Request $request){

        $user = User::where('id',$request->user_id)->first();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();
        $parent = Wazazi::where('users_id',$request->user_id)->where('schools_id',Session::get('school_id'))->first();
        $parent->address = $request->address;
        $parent->work = $request->work;
        $parent->save();
        return redirect()->to('/mparents')->with('success','Teacher Edited Successfuly...!');
    }

    public function mdeleteParent(Request $request){
        User::where('id',$request->parent_id)->delete();
        Wazazi::where('users_id',$request->parent_id)->where('schools_id',Session::get('school_id'))->delete();
        return redirect()->to('/mparents')->with('success','Parent is Deleted Successfuly...!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Maduka;
use App\Models\Mauzo;
use App\Models\User;
use App\Models\School;
use App\Models\YearPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\seller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
     public function index()
     {
   
         if (Auth::user()->role == 'Admin') {
            Session::put('admin_id',Auth::id());
            return redirect()->to('admin');
             
         } 
         if (Auth::user()->role == 'Super Admin') {
            Session::put('super_admin_id',Auth::id());
            return redirect()->to('super-admin');
             
         } 
         if (Auth::user()->role == 'Headmaster') {
             $data = User::all();
             return view('headmaster.index')->with('data',$data);
         } 
         if (Auth::user()->role == 'Accountant') {
             $data = User::all();
             return view('accountant.index')->with('data',$data);
         } 
         if (Auth::user()->role == 'Manager') {

             Session::put('manager_id',Auth::id());
             return redirect()->to('manager');
         } 
         // if (Auth::user()->role == 'Admin') {
         //     $data = User::all();
         //     return view('admin.index')->with('data',$data);
         // } 
         // if (Auth::user()->role == 'Admin') {
         //     $data = User::all();
         //     return view('admin.index')->with('data',$data);
         // } 
        
     }

     public function schoolAdmin(){
        $data = Admin::where('admins.schools_id',Session::get('school_id'))
                ->join('users','users.id','=','admins.users_id')->get();
        //return $data;
        return view('manager.admin.index')->with('data',$data);
     }

     public function schoolAdminSave(Request $request){

        // return $request->all();
        DB::beginTransaction();
          
       try {

        $validator = Validator::make($request->all(), [
            'file' => 'mimes:png,jpg,jpeg|max:1024|dimensions:width=500,height=500',
        ]);
      
        if ($validator->fails()) {
            $error = "The file must not be greater than 1024kb/1M and file should be PNG,JPEG and JPG, Dimension of 500x500";
            return redirect()->to('madmin')->with('error',$error);
        }
        if($request->file()){
            
            $file = $request->file('file');
            $fileName = 'Admin'.time().'.'.$request->file->extension();
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
            $user->role = 'Admin';
            $user->password = Hash::make($request->phone);
            $user->save();
            $user_id = $user->id;

            $admin = new Admin();
            $admin->users_id = $user_id;
            $admin->schools_id = Session::get('school_id');
            $admin->save();
            DB::commit();
            return redirect()->to('madmin')->with('success','Admin saved Successfuly..!');
        } else{
            $user = new User();
            $user->fname = $request->fname;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->role = 'Admin';
            $user->password = Hash::make($request->phone);
            $user->save();
            $user_id = $user->id;

            $admin = new Admin();
            $admin->users_id = $user_id;
            $admin->schools_id = Session::get('school_id');
            $admin->save();
            DB::commit();
            return redirect()->to('madmin')->with('success','Admin saved Successfuly..!');
        }
       } catch (\Throwable $th) {
        return redirect()->to('madmin')->with('error','Error occured');
       }
       
     }
}

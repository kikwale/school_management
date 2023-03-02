<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\Darasa;
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
   
}

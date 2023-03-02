<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Wazazi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ParentsController extends Controller
{
    public function mparents(Request $request){
        $parents = Wazazi::where('wazazis.schools_id',Session::get('school_id'))
        ->join('users','users.id','=','wazazis.users_id')->get();
       return view('manager.parents.index')->with('data',$parents);
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

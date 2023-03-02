<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LibraryController extends Controller
{
    public function mLibrarian(){
        $librarians = Librarian::where('librarians.schools_id',Session::get('school_id'))
                    ->join('users','users.id','=','librarians.users_id')->get();
        return view('manager.librarian.index')->with('data',$librarians);
    }

    public function msaveLibrarian(Request $request){
        $user = new User;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = "Librarian";
        $user->password = Hash::make($request->phone);
        $user->save();
        $user_id = $user->id;

        $librarian = [];
        $librarian = $request->all();
        $librarian['users_id'] = $user->id;
        $librarian['schools_id'] = Session::get('school_id');
        Librarian::create($librarian);
        return redirect()->to('/mLibrarians')->with('success','New Librarian created Successfuly...!');
    }

    public function meditLibrarian(Request $request){

        $user = User::where('id',$request->user_id)->first();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();
        $librarian = Librarian::where('users_id',$request->user_id)->where('schools_id',Session::get('school_id'))->first();
        $librarian->edu_level = $request->edu_level;
        $librarian->salary = $request->salary;
        $librarian->save();
        return redirect()->to('/mLibrarians')->with('success','Librarian Edited Successfuly...!');
    }

    public function mdeleteLibrarian(Request $request){
        User::where('id',$request->teacher_id)->delete();
        Librarian::where('users_id',$request->teacher_id)->where('schools_id',Session::get('school_id'))->delete();
        return redirect()->to('/mLibrarians')->with('success','Librarian is Deleted Successfuly...!');
    }
}

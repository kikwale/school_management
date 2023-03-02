<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TermsController extends Controller
{
    public function adminCreateTerms(){
        $terms = Term::where('schools_id',Session::get('school_id'))->get();
        return view('admin.creates.terms')->with('data',$terms);
    }
    public function adminSaveTerm(Request $request){

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['schools_id'] = Session::get('school_id');
            Term::create($input);
            DB::commit();
            return redirect()->to('admin-create-terms')->with('success','Created Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-terms')->with('error','Error occured');
        }
       
    }

    public function adminEditTerm(Request $request){

        try {
            DB::beginTransaction();
            $term = Term::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
            $term['name'] = $request['name'];
            $term['description'] = $request['description'];
            $term->save();
            DB::commit();
            return redirect()->to('admin-create-terms')->with('success','Edited Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-terms')->with('error','Error occured');
        }
       
    }

    public function adminDeleteTerm(Request $request){

        try {

            Term::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
            return redirect()->to('admin-create-terms')->with('success','Deleted Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-terms')->with('error','Error occured');
        }
       
    }
}

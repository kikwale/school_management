<?php

namespace App\Http\Controllers;

use App\Models\StreamOrComb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StreamCombController extends Controller
{
    public function adminCreateStreamsCombs(){
        $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();
        return view('admin.creates.stream_comb')->with('data',$streams);
    }
    public function adminSaveStreamsComb(Request $request){

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['schools_id'] = Session::get('school_id');
            StreamOrComb::create($input);
            DB::commit();
            return redirect()->to('admin-create-streams-combs')->with('success','Created Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-streams-combs')->with('error','Error occured');
        }
       
    }

    public function adminEditStreamsComb(Request $request){

        try {
            DB::beginTransaction();
            $stream = StreamOrComb::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
            $stream['name'] = $request['name'];
            $stream['description'] = $request['description'];
            $stream->save();
            DB::commit();
            return redirect()->to('admin-create-streams-combs')->with('success','Edited Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-streams-combs')->with('error','Error occured');
        }
       
    }

    public function adminDeleteStreamsComb(Request $request){

        try {

            StreamOrComb::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
            return redirect()->to('admin-create-streams-combs')->with('success','Deleted Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-create-streams-combs')->with('error','Error occured');
        }
       
    }
}

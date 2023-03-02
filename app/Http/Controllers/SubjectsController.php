<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\ClassSubject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SubjectsController extends Controller
{
   public function mSubjects(Request $request){
    $subjects = Subject::where('schools_id',Session::get('school_id'))->get();
        return view('manager.subjects.index')->with('data',$subjects);
   }

   public function msaveSubject(Request $request){
    $subject = new Subject;
    $subject->schools_id = Session::get('school_id');
    $subject->subject_name = $request->subject_name;
    $subject->save();
    return redirect()->to('/mSubjects')->with('success','New Subject created Successfuly...!');
}

public function meditSubject(Request $request){

    $subject = Subject::where('id',$request->subject_id)->where('schools_id',Session::get('school_id'))->first();
    $subject->subject_name = $request->subject_name;
    $subject->save();
    return redirect()->to('/mSubjects')->with('success','Subject Edited Successfuly...!');
}

public function mDeleteSubject(Request $request){
    Subject::where('id',$request->subject_id)->where('schools_id',Session::get('school_id'))->delete();
    return redirect()->to('/mSubjects')->with('success','Subject is Deleted Successfuly...!');
}

public function msettingSubjectsClass(){

    $class_subjects = Darasa::select(
    'class_subjects.id as id',
    'darasas.class_name as class_name',
    'darasas.level as level',
    'subjects.subject_name as subject_name',
    'class_subjects.subjects_id as subjects_id',
    'class_subjects.darasas_id as darasas_id'
    )->where('darasas.schools_id',Session::get('school_id'))
    ->join('class_subjects','class_subjects.darasas_id','=','darasas.id')
    ->join('subjects','subjects.id','=','class_subjects.subjects_id')->get();

     $subjects = Subject::where('schools_id',Session::get('school_id'))->get();
     $classes = Darasa::where('schools_id',Session::get('school_id'))->get();


   return view('manager.subjects.class')->with('data',$class_subjects)
                                       ->with('subjects',$subjects)
                                       ->with('classes',$classes);
}

public function msaveSettingSubjectsClass(Request $request){
 
    $info = [];
    $info['schools_id'] = Session::get('school_id');
    $info['darasas_id'] = $request->darasas_id;

foreach($request['subjects_id'] as $key=>$subjects_id){
   $info['subjects_id'] = $subjects_id;
  
   ClassSubject::create($info);
 }
 return redirect()->to('/msetting-subjects-class')->with('success','Data saved Successfuly...!');
}

public function meditSettingSubjectsClass(Request $request){
   
    $class_subject = ClassSubject::where('id',$request->class_subject_id)
                                ->where('schools_id',Session::get('school_id'))
                                ->first();
    $class_subject->darasas_id = $request->darasas_id;                    
    $class_subject->subjects_id = $request->subject_id;                    
    $class_subject->save();
    
    return redirect()->to('/msetting-subjects-class')->with('success','Data Edited Successfuly...!');                
}

public function mDeleteSettingSubjectsClass(Request $request){
    ClassSubject::where('id',$request->class_subject_id)
    ->where('schools_id',Session::get('school_id'))
    ->delete();
    return redirect()->to('/msetting-subjects-class')->with('success','Data Deleted Successfuly...!');   
}

}

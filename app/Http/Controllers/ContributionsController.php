<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\StudentClass;
use App\Models\ClassSubject;
use App\Models\StudentContribution;
use App\Models\TeacherClass;
use App\Models\ContributionPayment;
use App\Models\Contribution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ContributionsController extends Controller
{

    public function index(){
        $student_contributions = StudentContribution::select('student_contributions.id as id',
        'student_contributions.darasas_id as darasas_id',
        'student_contributions.students_id as students_id',
        'student_contributions.contribution_amount as contribution_amount',
        'student_contributions.description as description',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname',
        'student_classes.year as year',
        'darasas.class_name as class_name',
        'darasas.level as level'
        )->where('student_contributions.schools_id',Session::get('school_id'))
        ->where('student_classes.isCurrent',true)
        ->where('student_contributions.isCurrent',true)
        ->join('students','students.id','=','student_contributions.students_id')
        ->join('student_classes','student_classes.students_id','=','student_contributions.students_id')
        ->join('darasas','darasas.id','=','student_contributions.darasas_id')
        ->join('users','users.id','=','students.users_id')->get();

        $students = User::where('students.schools_id',Session::get('school_id'))
        ->join('students','users.id','=','students.users_id')->get();

        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();

       return view('manager.contributions.index')->with('data',$student_contributions)
                                            ->with('students',$students)
                                            ->with('classes',$classes);
    }

    public function mcontributions(){
        $classes_contributons = Contribution::select(
            'contributions.id as id',
            'contributions.contribution_amount as contribution_amount',
            'contributions.contribution_name as contribution_name',
            'contributions.darasas_id as darasas_id',
            'darasas.class_name as class_name',
            'darasas.level as level'
            )->where('contributions.schools_id',Session::get('school_id'))
             ->join('darasas','darasas.id','=','contributions.darasas_id')->get();
        
             $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
            return view('manager.contributions.contributions')->with('data',$classes_contributons)
            ->with('classes',$classes);
    }

    public function msaveContributions(Request $request){
        $input = $request->all();
        $input['schools_id'] = Session::get('school_id');
        Contribution::create($input);
        return redirect()->to('/mcontributions')->with('success','Contribution saved Successfuly...!');
    }
    public function meditContributions(Request $request){
       $classes_contributons = Contribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
        $classes_contributons->darasas_id = $request->darasas_id;
        $classes_contributons->contribution_amount =$request->contribution_amount;
        $classes_contributons->save();
        return redirect()->to('/mcontributions')->with('success','Contribution Edited Successfuly...!');
    }
    public function mDeleteContributions(Request $request){
        Contribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->delete();
        return redirect()->to('/mcontributions')->with('success','Contribution Deleted Successfuly...!');
    }

    public function msaveSchoolContributions(Request $request){
  
     $student_contribution = StudentContribution::where('id',$request->student_contributions_id)->where('schools_id',Session::get('school_id'))->first();
     $student_contribution['contribution_amount'] = $student_contribution['contribution_amount'] - $request->amount;
     $student_contribution->save();
     $student_payment = new ContributionPayment;
     $student_payment->schools_id = Session::get('school_id');
     $student_payment->student_contributions_id = $request->student_contributions_id;
     $student_payment->methode = $request->methode;
     $student_payment->methode_name = $request->methode_name;
     $student_payment->number = $request->number;
     $student_payment->amount = $request->amount;
     $student_payment->date = $request->date;
     $student_payment->description = $request->description;
     $student_payment->save();
     return redirect()->to('/mschool-contributions')->with('success','Data saved Successfuly...!');

    }

    public function msettingContributions(){
        $student_contributions = StudentContribution::select('student_contributions.id as id',
        'student_contributions.darasas_id as darasas_id',
        'student_contributions.students_id as students_id',
        'student_contributions.contribution_amount as contribution_amount',
        'student_contributions.description as description',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname',
        'student_classes.year as year',
        'darasas.class_name as class_name',
        'darasas.level as level'
        )->where('student_contributions.schools_id',Session::get('school_id'))
        ->where('student_classes.isCurrent',true)
        ->where('student_contributions.isCurrent',true)
        ->join('students','students.id','=','student_contributions.students_id')
        ->join('student_classes','student_classes.students_id','=','student_contributions.students_id')
        ->join('darasas','darasas.id','=','student_contributions.darasas_id')
        ->join('users','users.id','=','students.users_id')->get();


        $students = User::where('students.schools_id',Session::get('school_id'))
        ->join('students','users.id','=','students.users_id')->get();

        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();

       return view('manager.contributions.class')->with('data',$student_contributions)
                                            ->with('students',$students)
                                            ->with('classes',$classes);
    }

 
    public function msaveSettingContributions(Request $request){
     
        $input = $request->all();
        $input['schools_id'] = Session::get('school_id');
    
    foreach($request['students_id'] as $key=>$student_id){
       $input['students_id'] = $student_id;
       $student_class = StudentClass::where('schools_id',Session::get('school_id'))->where('students_id',$student_id)->where('isCurrent',true)->first();
          //tutagroup contribution coz contribution zinaweza kuwa nyingi kwa darasa moja
       $classes_contributon = Contribution::where('schools_id',Session::get('school_id'))->where('darasas_id',$student_class->darasas_id)->first();
       $input['contribution_amount'] = $classes_contributon->contribution_amount;
       $student_contribution = StudentContribution::where('schools_id',Session::get('school_id'))->where('students_id',$student_id)->where('isCurrent',true)->first();

       if($student_contribution == ""){
        StudentContribution::create($input);
       }else{
       continue;
       }
     }
     return redirect()->to('/msetting-contributions')->with('success','Data saved Successfuly...!');
    }
    
    public function meditSettingContributions(Request $request){
       
        $studentContribution = StudentContribution::where('id',$request->id)
                                    ->where('schools_id',Session::get('school_id'))
                                    ->first();
        $studentContribution->darasas_id = $request->darasas_id;                    
        $studentContribution->students_id = $request->students_id;                    
        $studentContribution->contribution_amount = $request->contribution_amount;                      
        $studentContribution->description = $request->description;                      
        $studentContribution->save();
        
        return redirect()->to('/msetting-contributions')->with('success','Data Edited Successfuly...!');                
    }
    
    public function mDeleteSettingContributions(Request $request){
        StudentContribution::where('id',$request->id)
        ->where('schools_id',Session::get('school_id'))
        ->delete();
        return redirect()->to('/msetting-contributions')->with('success','Data Deleted Successfuly...!');   
    }

    public function mfilterStudents(Request $request){
        
        $students =  Darasa::select(
        'students.id as id',
        'student_classes.darasas_id as darasas_id',
        'student_classes.students_id as students_id',
        'student_classes.year as year',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname'
        )->where('student_classes.schools_id',Session::get('school_id'))
        ->where('student_classes.darasas_id',$request->darasas_id)
        ->where('student_classes.isCurrent',true)
        ->join('student_classes','darasas.id','=','student_classes.darasas_id')
        ->join('students','students.id','=','student_classes.students_id')
        ->join('users','users.id','=','students.users_id')
        ->get();

        if($students != ""){
            $output = '';
            $output .='
            <div class="form-group">
            <label>Select Students</label>
            <select required name="students_id[]" style="height:90px;" id="students_id" class="tagging form-select form-control" multiple>
            <option></option>
           ';
            foreach ($students as $student){
             $output .='<option value="'.$student->id.'">'.$student->fname.' - '. $student->lname.'</option>';
            }
            
           $output .=' </select>
                    </div>';
          return $output;
        }else{
            return 'no data';
        }
        
    }
}

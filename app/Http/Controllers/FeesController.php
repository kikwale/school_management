<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Darasa;
use App\Models\Subject;
use App\Models\Fee;
use App\Models\Contribution;
use App\Models\StudentFeePayment;
use App\Models\StudentFee;
use App\Models\StudentClass;
use App\Models\ClassSubject;
use App\Models\StudentContribution;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class FeesController extends Controller
{
    public function index(){
        $student_fees = StudentFee::select('student_fees.id as id',
        'student_fees.darasas_id as darasas_id',
        'student_fees.students_id as students_id',
        'student_fees.fee_amount as fee_amount',
        'student_fees.description as description',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname',
        'student_classes.year as year',
        'darasas.class_name as class_name',
        'darasas.level as level'
        )->where('student_fees.schools_id',Session::get('school_id'))
        ->where('student_classes.isCurrent',true)
        ->where('student_fees.isCurrent',true)
        ->join('student_classes','student_classes.students_id','=','student_fees.students_id')
        ->join('students','students.id','=','student_fees.students_id')
        ->join('darasas','darasas.id','=','student_classes.darasas_id')
        ->join('users','users.id','=','students.users_id')->get();

        $students = User::where('students.schools_id',Session::get('school_id'))
        ->join('students','users.id','=','students.users_id')->get();

        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();

       return view('manager.fees.index')->with('data',$student_fees)
                                            ->with('students',$students)
                                            ->with('classes',$classes);
    }

    public function msaveSchoolFees(Request $request){
  
      
     $student_fees = StudentFee::where('id',$request->student_fees_id)->where('schools_id',Session::get('school_id'))->first();
     $student_fees['fee_amount'] = $student_fees['fee_amount'] - $request->amount;
     $student_fees->save();
     $student_payment = new StudentFeePayment;
     $student_payment->schools_id = Session::get('school_id');
     $student_payment->student_fees_id =$request->student_fees_id;
     $student_payment->methode = $request->methode;
     $student_payment->methode_name = $request->methode_name;
     $student_payment->number = $request->number;
     $student_payment->amount = $request->amount;
     $student_payment->date = $request->date;
     $student_payment->description = $request->description;
     $student_payment->save();
     return redirect()->to('/mschool-fees')->with('success','Data saved Successfuly...!');

    }

    public function mfees(){
    $classes_fees = Fee::select(
    'fees.id as id',
    'fees.fee_amount as fee_amount',
    'fees.darasas_id as darasas_id',
    'darasas.class_name as class_name',
    'darasas.level as level'
    )->where('fees.schools_id',Session::get('school_id'))
     ->join('darasas','darasas.id','=','fees.darasas_id')->get();

     $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
    return view('manager.fees.fees')->with('data',$classes_fees)
    ->with('classes',$classes);
    }

    public function msaveFees(Request $request){
        $input = $request->all();
        $input['schools_id'] = Session::get('school_id');
        Fee::create($input);
        return redirect()->to('/mfees')->with('success','Fee saved Successfuly...!');
    }
    public function meditFees(Request $request){
       $classes_fees = Fee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
        $classes_fees->darasas_id = $request->darasas_id;
        $classes_fees->fee_amount =$request->fee_amount;
        $classes_fees->save();
        return redirect()->to('/mfees')->with('success','Fee Edited Successfuly...!');
    }
    public function mDeleteFees(Request $request){
        Fee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->delete();
        return redirect()->to('/mfees')->with('success','Fee Deleted Successfuly...!');
    }

    public function msettingFees(){
        $student_fees = StudentFee::select('student_fees.id as id',
        'student_fees.darasas_id as darasas_id',
        'student_fees.students_id as students_id',
        'student_fees.fee_amount as fee_amount',
        'student_fees.description as description',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname',
        'student_classes.year as year',
        'darasas.class_name as class_name',
        'darasas.level as level'
        )->where('student_fees.schools_id',Session::get('school_id'))
        ->where('student_classes.isCurrent',true)
        ->where('student_fees.isCurrent',true)
        ->join('student_classes','student_classes.students_id','=','student_fees.students_id')
        ->join('students','students.id','=','student_fees.students_id')
        ->join('darasas','darasas.id','=','student_classes.darasas_id')
        ->join('users','users.id','=','students.users_id')->get();

      
        $students = User::where('students.schools_id',Session::get('school_id'))
        ->join('students','users.id','=','students.users_id')->get();

        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();

       return view('manager.fees.class')->with('data',$student_fees)
                                            ->with('students',$students)
                                            ->with('classes',$classes);
    }

 
    public function msaveSettingFees(Request $request){
     
       $input = $request->all();
        $input['schools_id'] = Session::get('school_id');
    
    foreach($request['students_id'] as $key=>$student_id){
       $input['students_id'] = $student_id;
       $student_class = StudentClass::where('schools_id',Session::get('school_id'))->where('students_id',$student_id)->where('isCurrent',true)->first();
       $classes_fees = Fee::where('schools_id',Session::get('school_id'))->where('darasas_id',$student_class->darasas_id)->first();
       $input['fee_amount'] = $classes_fees->fee_amount;
       $student_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('students_id',$student_id)->where('isCurrent',true)->first();

       if($student_fees == ""){
        StudentFee::create($input);
       }else{
       continue;
       }
     

     }
     return redirect()->to('/msetting-fees')->with('success','Data saved Successfuly...!');
    }
    
    public function meditSettingFees(Request $request){
       
        $student_fee = StudentFee::where('id',$request->id)
                                    ->where('schools_id',Session::get('school_id'))
                                    ->first();
       
        $student_fee->darasas_id = $request->darasas_id;                    
        $student_fee->students_id = $request->students_id;                    
        $student_fee->fee_amount = $request->fee_amount;                      
        $student_fee->description = $request->description;                      
        $student_fee->save();
        
        return redirect()->to('/msetting-fees')->with('success','Data Edited Successfuly...!');                
    }
    
    public function mDeleteSettingFees(Request $request){
        StudentFee::where('id',$request->id)
        ->where('schools_id',Session::get('school_id'))
        ->delete();
        return redirect()->to('/msetting-fees')->with('success','Data Deleted Successfuly...!');   
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

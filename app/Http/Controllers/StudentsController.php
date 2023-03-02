<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Wazazi;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentFeePayment;
use App\Models\StudentFee;
use App\Models\Fee;
use App\Models\Darasa;
use App\Models\Contribution;
use App\Models\StudentContribution;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class StudentsController extends Controller
{
    public function mstudents(Request $request){
        $students = Student::where('students.schools_id',Session::get('school_id'))
        ->join('wazazis','students.parents_id','=','wazazis.id')
        ->join('users','users.id','=','students.users_id')->get();
      
        $parents = User::where('wazazis.schools_id',Session::get('school_id'))
        ->join('wazazis','users.id','=','wazazis.users_id')->get();
       return view('manager.students.index')->with('data',$students)->with('parents',$parents);
    }

    public function msaveStudent(Request $request){
    //    return $request->all();
        $parent = Wazazi::where('id',$request->parents_id)->where('schools_id',Session::get('school_id'))->first();
        $parent_from_users = User::where('id',$parent->users_id)->first();
      
        $user = new User;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $parent_from_users->phone;
        $user->email = $request->email;
        $user->role = 'Student';
        $user->password = Hash::make($request->phone);
        $user->save();
        $user_id = $user->id;

        $student = [];
        $student = $request->all();
        $student['users_id'] = $user->id;
        $student['schools_id'] = Session::get('school_id');
        Student::create($student);
        return redirect()->to('/mstudents')->with('success','New Student created Successfuly...!');
    }

    public function meditStudent(Request $request){
        $parent = Wazazi::where('id',$request->parents_id)->where('schools_id',Session::get('school_id'))->first();
        $parent_from_users = User::where('id',$parent->users_id)->first();
        $user = User::where('id',$request->user_id)->first();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $parent_from_users->phone;
        $user->email = $request->email;
        $user->save();
        $student = Student::where('users_id',$request->user_id)->where('schools_id',Session::get('school_id'))->first();
        $student->parents_id = $request->parents_id;
        $student->RegNo = $request->RegNo;
        $student->save();
        return redirect()->to('/mstudents')->with('success','Student Edited Successfuly...!');
    }

    public function mdeleteStudent(Request $request){
        User::where('id',$request->users_id)->delete();
        Student::where('users_id',$request->users_id)->where('schools_id',Session::get('school_id'))->delete();
        return redirect()->to('/mstudents')->with('success','Student is Deleted Successfuly...!');
    }

    public function msettingStudentClass(){

        $students_class = StudentClass::select('student_classes.id as id',
        'student_classes.darasas_id as darasas_id',
        'student_classes.students_id as students_id',
        'student_classes.year as year',
        'users.fname as fname',
        'users.mname as mname',
        'users.lname as lname',
        'darasas.class_name as class_name',
        'darasas.level as level'
        )->where('student_classes.schools_id',Session::get('school_id'))
        ->join('students','students.id','=','student_classes.students_id')
        ->join('darasas','darasas.id','=','student_classes.darasas_id')
        ->join('users','users.id','=','students.users_id')->where('student_classes.isCurrent',true)->get();

        $students = User::where('students.schools_id',Session::get('school_id'))
        ->join('students','users.id','=','students.users_id')->get();

        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();


       return view('manager.students.class')->with('data',$students_class)
                                            ->with('students',$students)
                                            ->with('classes',$classes);
    }

    public function msaveSettingStudentClass(Request $request){

    foreach($request['students_id'] as $key=>$student_id){
       
        $studentsClass = StudentClass::where('students_id',$student_id)
                                    ->where('schools_id',Session::get('school_id'))
                                    ->where('isCurrent',true)->first();
        
        if($studentsClass == ""){
            $students_class = new  StudentClass;   
            $students_class->students_id = $student_id;
            $students_class->schools_id = Session::get('school_id');
            $students_class->darasas_id = $request['darasas_id'];
            $students_class->year = $request['year'];
            $students_class->isCurrent = true;
            $students_class->save(); 
        } else{
            continue;
          
        }

     }
     return redirect()->to('/msetting-student-class')->with('success','Data saved Successfuly...!');
    }

    public function meditSettingStudentClass(Request $request){
       
        $studentsClass = StudentClass::where('students_id',$request->students_id)
                                    ->where('schools_id',Session::get('school_id'))
                                    ->where('isCurrent',true)->first();
        $studentsClass->darasas_id = $request->darasas_id;                    
        $studentsClass->year = $request->year;                    
        $studentsClass->save();
        
        return redirect()->to('/msetting-student-class')->with('success','Data Edited Successfuly...!');                
    }

    public function mdeleteSettingStudentClass(Request $request){
        StudentClass::where('id',$request->id)
        ->where('schools_id',Session::get('school_id'))
        ->where('isCurrent',true)->delete();
        return redirect()->to('/msetting-student-class')->with('success','Data Deleted Successfuly...!');   
    }

    public function mupgradeSettingStudentClass(Request $request){

        if($request->darasas_from_id == $request->darasas_to_id){
            return back()->with('error','You can not Upgrade the class to same class');
        }

       $students_class = StudentClass::where('darasas_id',$request->darasas_from_id)
        ->where('schools_id',Session::get('school_id'))
        ->where('isCurrent',true)->get();

        
        StudentClass::where('darasas_id',$request->darasas_from_id)
        ->where('schools_id',Session::get('school_id'))
        ->where('isCurrent',true)->update([
            'isCurrent'=>false
        ]);

        $classes_fees = Fee::where('schools_id',Session::get('school_id'))->where('darasas_id',$request->darasas_to_id)->first();
        //tutagroup contribution coz contribution zinaweza kuwa nyingi kwa darasa moja
        $classes_contributon = Contribution::where('schools_id',Session::get('school_id'))->where('darasas_id',$request->darasas_to_id)->first();
   
        foreach($students_class as $student_class){

            $student_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('students_id',$student_class->students_id)->where('isCurrent',true)->first();
            StudentFee::where('schools_id',Session::get('school_id'))->where('students_id',$student_class->students_id)->where('isCurrent',true)
            ->update([
                'isCurrent'=>false
            ]);

            $student_contributions = StudentContribution::where('schools_id',Session::get('school_id'))->where('students_id',$student_class->students_id)->where('isCurrent',true)->first();
            StudentContribution::where('schools_id',Session::get('school_id'))->where('students_id',$student_class->students_id)->where('isCurrent',true)
            ->update([
                'isCurrent'=>false
            ]);
            
            $new_students_class = new StudentClass;
            $new_students_class->schools_id = $student_class->schools_id;
            $new_students_class->darasas_id = $request->darasas_to_id;
            $new_students_class->students_id = $student_class->students_id;
            $new_students_class->year = $request->year;
            $new_students_class->isCurrent = true;
            $new_students_class->save();

            if($student_fees == ""){
                
            } else{
                $new_students_fee = new StudentFee;
                $new_students_fee->schools_id = Session::get('school_id');
                $new_students_fee->darasas_id = $request->darasas_to_id;
                $new_students_fee->students_id = $student_fees->students_id;
                $new_students_fee->fee_amount = $classes_fees->fee_amount;
                $new_students_fee->year = $request->year;
                $new_students_fee->isCurrent = true;
                $new_students_fee->save();
            }
           
            if($student_contributions == ""){
                
            }else{
                $new_student_contributions = new StudentContribution;
                $new_student_contributions->schools_id = Session::get('school_id');
                $new_student_contributions->darasas_id = $request->darasas_to_id;
                $new_student_contributions->students_id = $student_contributions->students_id;
                $new_student_contributions->contribution_amount = $classes_contributon->contribution_amount;
                $new_student_contributions->year = $request->year;
                $new_student_contributions->isCurrent = true;
                $new_student_contributions->save();
            }
      
     
        }
        return redirect()->to('/msetting-student-class')->with('success','Class Students Upgraded Successfuly...!');   
        
    }
}

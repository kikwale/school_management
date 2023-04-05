<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
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
use App\Models\StreamOrComb;
use App\Models\Student;
use App\Models\StudentContribution;
use App\Models\TeacherClass;
use App\Models\StudentsParent;
use App\Models\Wazazi;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Mail\SendReceiptMaillable;

class FeesController extends Controller
{
    public function adminAddFees(){
        $fees = Fee::where('schools_id',Session::get('school_id'))->get();
        return view('admin.fees.index')->with('data',$fees);
    }
    public function adminSaveFee(Request $request){

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['schools_id'] = Session::get('school_id');
            Fee::create($input);
            DB::commit();
            return redirect()->to('admin-add-fees')->with('success','Created Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-add-fees')->with('error','Error occured');
        }
       
    }

    public function adminEditFee(Request $request){

        try {
            DB::beginTransaction();
            $fee = Fee::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
            $fee['name'] = $request['name'];
            $fee['amount'] = $request['amount'];
            $fee->save();
            DB::commit();
            return redirect()->to('admin-add-fees')->with('success','Edited Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-add-fees')->with('error','Error occured');
        }
       
    }

    public function adminDeleteFee(Request $request){

        try {

            Fee::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
            return redirect()->to('admin-add-fees')->with('success','Deleted Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-add-fees')->with('error','Error occured');
        }
       
    }

    public function adminSetFees(Request $request){
       
        $students = Student::where('schools_id',Session::get('school_id'))->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $fees = Fee::where('schools_id',Session::get('school_id'))->get();
        $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        return view('admin.settings.students_fee')
               ->with('students',$students)
               ->with('classes',$classes)
               ->with('fees',$fees)
               ->with('year',$year);
       }

       public function adminSaveSetFee(Request $request){
      
        try {
   
        DB::beginTransaction();
        $students = StudentClass::where('schools_id',Session::get('school_id'))->where('darasas_id',$request->darasas_id)
        ->where('academic_years_id',$request->academic_years_id)->get();
       $fees = Fee::where('schools_id',Session::get('school_id'))->where('id',$request->fees_id)->first();
        foreach ($students as $student) {
          $student_fee = StudentFee::where('schools_id',Session::get('school_id'))->where('darasas_id',$request->darasas_id)->where('students_id',$student->students_id)
           ->where('academic_years_id',$request->academic_years_id)->first();
        if ($student_fee == "") {
           $fee = new StudentFee();
           $fee->schools_id = Session::get('school_id');
           $fee->darasas_id = $request->darasas_id;
           $fee->students_id = $student->students_id;
           $fee->academic_years_id = $request->academic_years_id;
           $fee->fees_id = $request->fees_id;
           $fee->amount = $fees->amount;
           $fee->save();
           DB::commit();
        }
        }
            return redirect()->to('/admin-set-fees')->with('success','Saved Successfully...!!!');
        } catch (\Throwable $th) {
            return redirect()->to('/admin-set-fees')->with('error','Error Encountered...!!!');
        }
       
        
       }

    public function adminCollectFees(Request $request){
    $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
    $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
    $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
    $students = [];
    $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
                        ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                        ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
    $terms = Term::where('schools_id',Session::get('school_id'))->get();
    return view('admin.fees.fees_collection')
           ->with('current_year',$current_year)
           ->with('total_students',$total_students)
           ->with('total_students_fees',$total_students_fees)
           ->with('data',$students)
           ->with('terms',$terms)
           ->with('students_fees_paid',$students_fees_paid);


    }       

    public function adminSaveFeePayment(Request $request){
    
     try {
      DB::beginTransaction();
      $fee = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
      if ($fee->amount <= 0) {
        return redirect()->to('/admin-collect-fees')->with('success','Thanks You!! Your Balance is Empty');
      }
      $fee->amount = $fee->amount - $request->amount;
      $fee->save();

      $paid_fee = new StudentFeePayment();
      $paid_fee->schools_id = Session::get('school_id');
      $paid_fee->student_fees_id = $request->id;
      $paid_fee->methode_name = $request->methode_name;
      $paid_fee->terms_id = $request->terms_id;
      $paid_fee->methode = $request->methode;
      $paid_fee->number = $request->number;
      $paid_fee->amount = $request->amount;
      $paid_fee->date = $request->date;
      $paid_fee->save();
      DB::commit();
      return redirect()->to('/admin-collect-fees')->with('success','Successfuly Payment saved.....!!!');
     } catch (\Throwable $th) {
        return redirect()->to('/admin-collect-fees')->with('error','Error occured.....!!!');
     }
    }

    public function adminEditFeePayment(Request $request){
        try {
            DB::beginTransaction();
            $fee = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
            if ($request->amount == "") {
            $fee->amount = 0;
            $fee->save();
            } else {
                $fee->amount = $request->amount;
                $fee->save();
            }
         
            DB::commit();
            return redirect()->to('/admin-collect-fees')->with('success','Successfuly Fee Updated.....!!!');
           } catch (\Throwable $th) {
              return redirect()->to('/admin-collect-fees')->with('error','Error occured.....!!!');
           }
        
    }

    public function adminGetClasses(Request $request){
        $classes = Darasa::where('schools_id',Session::get('school_id'))->where('level',$request->level)->get();
        Log::info($classes);
        $output = '';
        $output .='<option value=""></option>';
        foreach ($classes as $class) {
          $output .='<option value="'.$class->id.'">'.$class->name.'</option>';
        }
        return $output;
    }

    public function adminGetClassFee(Request $request){

        $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
        $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
        $students = StudentFee::select('student_fees.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_fees.amount as amount')
                    ->join('students','students.id','=','student_fees.students_id')            
                    ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                    ->where('student_fees.darasas_id',$request->darasas_id)
                    ->get();
        $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
                            ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                            ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
        $terms = Term::where('schools_id',Session::get('school_id'))->get();
        return view('admin.fees.fees_collection')
               ->with('current_year',$current_year)
               ->with('total_students',$total_students)
               ->with('total_students_fees',$total_students_fees)
               ->with('data',$students)
               ->with('terms',$terms)
               ->with('students_fees_paid',$students_fees_paid); 
    }

    public function adminViewFeePayments(Request $request){
        $student_fee = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
        $student = Student::where('schools_id',Session::get('school_id'))->where('id',$student_fee->students_id)->first();
        $fee_payments = StudentFeePayment::
                        select('student_fee_payments.id as id',
                        'student_fee_payments.amount as amount',
                        'student_fee_payments.date as date',
                        'terms.name as term_name')->where('terms.schools_id',Session::get('school_id'))
                        ->where('student_fee_payments.student_fees_id',$request->id)
                        ->join('terms','terms.id','=','student_fee_payments.terms_id')->get();
        return view('admin.fees.fee_payments')->with('fee_payments',$fee_payments)
               ->with('student',$student);
       
    }

    public function adminFeeReports(Request $request){

        $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
        $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
        $students = StudentFee::select('student_fees.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_fees.amount as amount')
                    ->join('students','students.id','=','student_fees.students_id')            
                    ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                    ->where('student_fees.darasas_id',$request->darasas_id)
                    ->get();
        $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
                            ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                            ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
        $terms = Term::where('schools_id',Session::get('school_id'))->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
        return view('admin.fees.report')
        ->with('current_year',$current_year)
        ->with('total_students',$total_students)
        ->with('total_students_fees',$total_students_fees)
        ->with('data',$students)
        ->with('terms',$terms)
        ->with('classes',$classes)
        ->with('years',$years)
        ->with('students_fees_paid',$students_fees_paid);
    }

    public function adminGetClassesReport(){
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();

        $output='';
        $output .='<label><sup class="text-danger">*</sup>&nbsp; Select Class</label>
        <select required class=" form-control chzn-" name="darasa_id" id="darasa_id">
        <option value=""></option>';
        foreach ($classes as $key => $class) {
        $output .='
                <option value="'.$class->id.'">'.$class->name.'</option>
                 ';
        }

        $output .= '</select>';
        return $output;
    }

    public function adminGetStream(){
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();

        $output='';
        $output .='<label><sup class="text-danger">*</sup>&nbsp; Select Class</label>
        <select required onchange="getStream(this.value)" class=" form-control chzn-" name="darasa_id" id="darasa_id">
        <option value=""></option>';
        foreach ($classes as $key => $class) {
        $output .='
                <option value="'.$class->id.'">'.$class->name.'</option>
                 ';
        }

        $output .= '</select>';
        return $output;
    }
    
    public function adminGetClassFeeReport(Request $request){
        $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
        $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
        $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
        ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
        ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
        $terms = Term::where('schools_id',Session::get('school_id'))->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
        if ($request->filter_name == 'Class') {
            $students = StudentFee::select('student_fees.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_fees.amount as amount')
            ->join('students','students.id','=','student_fees.students_id')            
            ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$request->year)
            ->where('student_fees.darasas_id',$request->darasa_id)
            ->get();
            return view('admin.fees.report')
            ->with('current_year',$current_year)
            ->with('total_students',$total_students)
            ->with('total_students_fees',$total_students_fees)
            ->with('data',$students)
            ->with('terms',$terms)
            ->with('classes',$classes)
            ->with('years',$years)
            ->with('students_fees_paid',$students_fees_paid);
        }
      
      
    }

    public function adminGetStreamReport(Request $request){
        $streams = StreamOrComb::where('schools_id',Session::get('school_id'))->get();

        $output='';
        $output .='<label><sup class="text-danger">*</sup>&nbsp; Select Stream/Comb</label>
        <select required class=" form-control chzn-" name="stream_id" id="stream_id">
        <option value=""></option>';
        foreach ($streams as $key => $stream) {
        $output .='
                <option value="'.$stream->id.'">'.$stream->name.'</option>
                 ';
        }

        $output .= '</select>';
        return $output;
    }


    //Teaching staffs Methods

    public function teacherAddFees(){
        $fees = Fee::where('schools_id',Session::get('school_id'))->get();
        return view('teaching_staffs.fees.index')->with('data',$fees);
    }
    public function teacherSaveFee(Request $request){

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['schools_id'] = Session::get('school_id');
            Fee::create($input);
            DB::commit();
            return redirect()->to('teacher-add-fees')->with('success','Created Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-add-fees')->with('error','Error occured');
        }
       
    }

    public function teacherEditFee(Request $request){

        try {
            DB::beginTransaction();
            $fee = Fee::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
            $fee['name'] = $request['name'];
            $fee['amount'] = $request['amount'];
            $fee->save();
            DB::commit();
            return redirect()->to('teacher-add-fees')->with('success','Edited Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-add-fees')->with('error','Error occured');
        }
       
    }

    public function teacherDeleteFee(Request $request){

        try {

            Fee::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
            return redirect()->to('teacher-add-fees')->with('success','Deleted Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-add-fees')->with('error','Error occured');
        }
       
    }
    
    public function teacherCollectFees(Request $request){
        $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
        $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
        $students = [];
        $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
                            ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                            ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
        $terms = Term::where('schools_id',Session::get('school_id'))->get();
        return view('teaching_staffs.fees.fees_collection')
               ->with('current_year',$current_year)
               ->with('total_students',$total_students)
               ->with('total_students_fees',$total_students_fees)
               ->with('data',$students)
               ->with('terms',$terms)
               ->with('students_fees_paid',$students_fees_paid);
    
    
        }       
    
        public function teacherSaveFeePayment(Request $request){
        
         try {
          DB::beginTransaction();
          $fee = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
          if ($fee->amount <= 0) {
            return redirect()->to('/teacher-collect-fees')->with('success','Thanks You!! Your Balance is Empty');
          }
          $fee->amount = $fee->amount - $request->amount;
          $fee->save();
    
          $paid_fee = new StudentFeePayment();
          $paid_fee->schools_id = Session::get('school_id');
          $paid_fee->student_fees_id = $request->id;
          $paid_fee->methode_name = $request->methode_name;
          $paid_fee->terms_id = $request->terms_id;
          $paid_fee->methode = $request->methode;
          $paid_fee->number = $request->number;
          $paid_fee->amount = $request->amount;
          $paid_fee->date = $request->date;
          $paid_fee->save();
          DB::commit();
          return redirect()->to('/teacher-collect-fees')->with('success','Successfuly Payment saved.....!!!');
         } catch (\Throwable $th) {
            return redirect()->to('/teacher-collect-fees')->with('error','Error occured.....!!!');
         }
        }
    
        public function teacherEditFeePayment(Request $request){
            try {
                DB::beginTransaction();
                $fee = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                if ($request->amount == "") {
                $fee->amount = 0;
                $fee->save();
                } else {
                    $fee->amount = $request->amount;
                    $fee->save();
                }
             
                DB::commit();
                return redirect()->to('/teacher-collect-fees')->with('success','Successfuly Fee Updated.....!!!');
               } catch (\Throwable $th) {
                  return redirect()->to('/teacher-collect-fees')->with('error','Error occured.....!!!');
               }
            
        }

        public function teacherGetClassFee(Request $request){

            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students = StudentFee::select('student_fees.id as id',
                        'students.fname as fname',
                        'students.lname as lname',
                        'students.photo as photo',
                        'student_fees.amount as amount')
                        ->join('students','students.id','=','student_fees.students_id')            
                        ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                        ->where('student_fees.darasas_id',$request->darasas_id)
                        ->get();
            $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
                                ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                                ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            return view('teaching_staffs.fees.fees_collection')
                   ->with('current_year',$current_year)
                   ->with('total_students',$total_students)
                   ->with('total_students_fees',$total_students_fees)
                   ->with('data',$students)
                   ->with('terms',$terms)
                   ->with('students_fees_paid',$students_fees_paid); 
        }
    
        public function teacherViewFeePayments(Request $request){
            //return $request->all();
            $student_fee = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
            $student = Student::where('schools_id',Session::get('school_id'))->where('id',$student_fee->students_id)->first();
            $student_parents = StudentsParent::where('students_parents.schools_id',Session::get('school_id'))->where('students_parents.students_id',$student_fee->students_id)
                             ->join('wazazis','wazazis.id','=','students_parents.wazazis_id')
                             ->join('users','users.id','=','wazazis.users_id')
                             ->get();
            $fee_payments = StudentFeePayment::
                            select('student_fee_payments.id as id',
                            'student_fee_payments.amount as amount',
                            'student_fee_payments.date as date',
                            'terms.name as term_name')->where('terms.schools_id',Session::get('school_id'))
                            ->where('student_fee_payments.student_fees_id',$request->id)
                            ->join('terms','terms.id','=','student_fee_payments.terms_id')->get();
           
            return view('teaching_staffs.fees.fee_payments')->with('fee_payments',$fee_payments)
                   ->with('student',$student)
                   ->with('student_parents',$student_parents)->with('index',1);
           
        }

        public function teacherSendFeeReceipt(Request $request){
           //return $request->all();
           $school = School::where('id',Session::get('school_id'))->first();
           $fee_payment = StudentFeePayment::
                        select('student_fee_payments.id as id',
                        'student_fee_payments.student_fees_id as student_fees_id',
                        'student_fee_payments.terms_id as terms_id',
                        'student_fee_payments.methode as methode',
                        'student_fee_payments.methode_name as provider',
                        'student_fee_payments.number as number',
                        'student_fee_payments.amount as amount',
                        'student_fee_payments.date as date',
                        'terms.name as term_name')
                        ->where('student_fee_payments.schools_id',Session::get('school_id'))
                        ->join('terms','terms.id','=','student_fee_payments.terms_id')
                        ->where('student_fee_payments.id',$request->fee_payment_id)->first();
           $fee_balance = StudentFee::where('schools_id',Session::get('school_id'))->where('id',$fee_payment->student_fees_id)->first();
           $student = Student::where('schools_id',Session::get('school_id'))->where('id',$fee_balance->students_id)->first();
           $parent = Wazazi::where('wazazis.schools_id',Session::get('school_id'))->where('wazazis.id',$request->parent_id)
                   ->join('users','users.id','=','wazazis.users_id')->first();
                       // return $student;
            
            try {
                Mail::to('harithijuma@gmail.com')->send(new SendReceiptMaillable('Fee Receipt',$school,$fee_payment,$student,$parent));
                return redirect()->back()->with('success','Send Successfuly...!!!');
            } catch (\Throwable $th) {
                return redirect()->back()->with('error','Error Occured...!!!');
            }

        }
    
        public function teacherFeeReports(Request $request){
    
            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students = StudentFee::select('student_fees.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_fees.amount as amount')
                        ->join('students','students.id','=','student_fees.students_id')            
                        ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                        ->where('student_fees.darasas_id',$request->darasas_id)
                        ->get();
            $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
                                ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
                                ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
            $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
            return view('teaching_staffs.fees.report')
            ->with('current_year',$current_year)
            ->with('total_students',$total_students)
            ->with('total_students_fees',$total_students_fees)
            ->with('data',$students)
            ->with('terms',$terms)
            ->with('classes',$classes)
            ->with('years',$years)
            ->with('students_fees_paid',$students_fees_paid);
        }

        public function teacherGetClassFeeReport(Request $request){
            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentFee::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students_fees_paid = StudentFee::select('student_fee_payments.amount as amount')
            ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$current_year->id)
            ->join('student_fee_payments','student_fee_payments.student_fees_id','=','student_fees.id')->sum('student_fee_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
            $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
            if ($request->filter_name == 'Class') {
                $students = StudentFee::select('student_fees.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_fees.amount as amount')
                ->join('students','students.id','=','student_fees.students_id')            
                ->where('student_fees.schools_id',Session::get('school_id'))->where('student_fees.academic_years_id',$request->year)
                ->where('student_fees.darasas_id',$request->darasa_id)
                ->get();
                return view('teaching_staffs.fees.report')
                ->with('current_year',$current_year)
                ->with('total_students',$total_students)
                ->with('total_students_fees',$total_students_fees)
                ->with('data',$students)
                ->with('terms',$terms)
                ->with('classes',$classes)
                ->with('years',$years)
                ->with('students_fees_paid',$students_fees_paid);
            }
          
          
        }

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

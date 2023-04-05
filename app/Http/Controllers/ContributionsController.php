<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
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
use App\Models\Student;
use App\Models\Term;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ContributionsController extends Controller
{

    public function adminAddContributions(){
        $contributions = Contribution::where('schools_id',Session::get('school_id'))->get();
        return view('admin.contributions.index')->with('data',$contributions);
    }
    public function adminSaveContribution(Request $request){

        try {
            DB::beginTransaction();
            $input = $request->all();
            $input['schools_id'] = Session::get('school_id');
            Contribution::create($input);
            DB::commit();
            return redirect()->to('admin-add-contributions')->with('success','Created Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-add-contributions')->with('error','Error occured');
        }
       
    }

    public function adminEditContribution(Request $request){

        try {
            DB::beginTransaction();
            $subject = Contribution::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
            $subject['name'] = $request['name'];
            $subject['amount'] = $request['amount'];
            $subject->save();
            DB::commit();
            return redirect()->to('admin-add-contributions')->with('success','Edited Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-add-contributions')->with('error','Error occured');
        }
       
    }

    public function adminDeleteContribution(Request $request){

        try {

            Contribution::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
            return redirect()->to('admin-add-contributions')->with('success','Deleted Successfuly...!!');
        } catch (\Throwable $th) {
            return redirect()->to('admin-add-contributions')->with('error','Error occured');
        }
       
    }

    public function adminSetContributions(Request $request){
       
        $students = Student::where('schools_id',Session::get('school_id'))->get();
        $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
        $contributions = Contribution::where('schools_id',Session::get('school_id'))->get();
        $year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        return view('admin.settings.students_contribution')
               ->with('students',$students)
               ->with('classes',$classes)
               ->with('contributions',$contributions)
               ->with('year',$year);
       }

       public function adminSaveSetContribution(Request $request){
        
        try {
   
        DB::beginTransaction();
        $students = StudentClass::where('schools_id',Session::get('school_id'))->where('darasas_id',$request->darasas_id)
        ->where('academic_years_id',$request->academic_years_id)->get();
       $contributions = Contribution::where('schools_id',Session::get('school_id'))->where('id',$request->contributions_id)->first();
        foreach ($students as $student) {
          $student_contribution = StudentContribution::where('schools_id',Session::get('school_id'))->where('darasas_id',$request->darasas_id)->where('students_id',$student->students_id)
           ->where('academic_years_id',$request->academic_years_id)->first();
        if ($student_contribution == "") {
           $contribution = new StudentContribution();
           $contribution->schools_id = Session::get('school_id');
           $contribution->darasas_id = $request->darasas_id;
           $contribution->students_id = $student->students_id;
           $contribution->academic_years_id = $request->academic_years_id;
           $contribution->contributions_id = $request->contributions_id;
           $contribution->amount = $contributions->amount;
           $contribution->save();
           DB::commit();
        }
        }
            return redirect()->to('/admin-set-contributions')->with('success','Saved Successfully...!!!');
        } catch (\Throwable $th) {
            return redirect()->to('/admin-set-contributions')->with('error','Error Encountered...!!!');
        }
       
        
       }

       public function adminCollectContribution(Request $request){
        $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
        $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
        $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
        $students = [];
        $students_fees_paid = StudentContribution::select('contribution_payments.amount as amount')
                            ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                            ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
        $terms = Term::where('schools_id',Session::get('school_id'))->get();
        return view('admin.contributions.contribution_collection')
               ->with('current_year',$current_year)
               ->with('total_students',$total_students)
               ->with('total_students_fees',$total_students_fees)
               ->with('data',$students)
               ->with('terms',$terms)
               ->with('students_fees_paid',$students_fees_paid);
    
    
        }
        
        public function adminGetClassContribution(Request $request){

            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students = StudentContribution::select('student_contributions.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_contributions.amount as amount')
                        ->join('students','students.id','=','student_contributions.students_id')            
                        ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                        ->where('student_contributions.darasas_id',$request->darasas_id)
                        ->get();
            $students_fees_paid = StudentContribution::select('contribution_payments.amount as amount')
                                ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                                ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            return view('admin.contributions.contribution_collection')
                   ->with('current_year',$current_year)
                   ->with('total_students',$total_students)
                   ->with('total_students_fees',$total_students_fees)
                   ->with('data',$students)
                   ->with('terms',$terms)
                   ->with('students_fees_paid',$students_fees_paid); 
        }

        public function adminEditContributionPayment(Request $request){
            try {
                DB::beginTransaction();
                $fee = StudentContribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                if ($request->amount == "") {
                $fee->amount = 0;
                $fee->save();
                } else {
                    $fee->amount = $request->amount;
                    $fee->save();
                }
             
                DB::commit();
                return redirect()->to('/admin-collect-contributions')->with('success','Successfuly Fee Updated.....!!!');
               } catch (\Throwable $th) {
                  return redirect()->to('/admin-collect-contributions')->with('error','Error occured.....!!!');
               }
            
        }public function adminSaveContributionPayment(Request $request){
    
            try {
             DB::beginTransaction();
             $contribution = StudentContribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
             if ($contribution->amount <= 0) {
               return redirect()->to('/admin-collect-contributions')->with('success','Thanks You!! Your Balance is Empty');
             }
             $contribution->amount = $contribution->amount - $request->amount;
             $contribution->save();
       
             $paid_contribution = new ContributionPayment();
             $paid_contribution->schools_id = Session::get('school_id');
             $paid_contribution->student_contributions_id = $request->id;
             $paid_contribution->methode_name = $request->methode_name;
             $paid_contribution->terms_id = $request->terms_id;
             $paid_contribution->methode = $request->methode;
             $paid_contribution->number = $request->number;
             $paid_contribution->amount = $request->amount;
             $paid_contribution->date = $request->date;
             $paid_contribution->save();
             DB::commit();
             return redirect()->to('/admin-collect-contributions')->with('success','Successfuly Payment saved.....!!!');
            } catch (\Throwable $th) {
               return redirect()->to('/admin-collect-contributions')->with('error','Error occured.....!!!');
            }
           }

           public function adminViewContributionPayments(Request $request){
            $student_fee = StudentContribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
            $student = Student::where('schools_id',Session::get('school_id'))->where('id',$student_fee->students_id)->first();
            $contribution_payments = ContributionPayment::
                            select('contribution_payments.id as id',
                            'contribution_payments.amount as amount',
                            'contribution_payments.date as date',
                            'terms.name as term_name')->where('terms.schools_id',Session::get('school_id'))
                            ->where('contribution_payments.student_contributions_id',$request->id)
                            ->join('terms','terms.id','=','contribution_payments.terms_id')->get();
            return view('admin.contributions.contribution_payments')->with('fee_payments',$contribution_payments)
                   ->with('student',$student);
           
        }

        public function adminContributionReports(Request $request){

            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students = StudentContribution::select('student_contributions.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_contributions.amount as amount')
                        ->join('students','students.id','=','student_contributions.students_id')            
                        ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                        ->where('student_contributions.darasas_id',$request->darasas_id)
                        ->get();
            $students_fees_paid = StudentContribution::select('student_fee_payments.amount as amount')
                                ->where('contribution_payments.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                                ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
            $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
            return view('admin.contributions.report')
            ->with('current_year',$current_year)
            ->with('total_students',$total_students)
            ->with('total_students_fees',$total_students_fees)
            ->with('data',$students)
            ->with('terms',$terms)
            ->with('classes',$classes)
            ->with('years',$years)
            ->with('students_fees_paid',$students_fees_paid);
        }
        public function adminGetClassContributionReport(Request $request){
            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students_fees_paid = StudentContribution::select('student_fee_payments.amount as amount')
            ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
            ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
            $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
            if ($request->filter_name == 'Class') {
                $students = StudentContribution::select('student_contributions.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_contributions.amount as amount')
                ->join('students','students.id','=','student_contributions.students_id')            
                ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$request->year)
                ->where('student_contributions.darasas_id',$request->darasa_id)
                ->get();
                return view('admin.contributions.report')
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

        // Teachers Methodes

        public function teacherAddContributions(){
            $contributions = Contribution::where('schools_id',Session::get('school_id'))->get();
            return view('teaching_staffs.contributions.index')->with('data',$contributions);
        }
        public function teacherSaveContribution(Request $request){
    
            try {
                DB::beginTransaction();
                $input = $request->all();
                $input['schools_id'] = Session::get('school_id');
                Contribution::create($input);
                DB::commit();
                return redirect()->to('teacher-add-contributions')->with('success','Created Successfuly...!!');
            } catch (\Throwable $th) {
                return redirect()->to('teacher-add-contributions')->with('error','Error occured');
            }
           
        }
    
        public function teacherEditContribution(Request $request){
    
            try {
                DB::beginTransaction();
                $subject = Contribution::where('id',$request->id)->where('schools_id',Session::get('school_id'))->first();
                $subject['name'] = $request['name'];
                $subject['amount'] = $request['amount'];
                $subject->save();
                DB::commit();
                return redirect()->to('teacher-add-contributions')->with('success','Edited Successfuly...!!');
            } catch (\Throwable $th) {
                return redirect()->to('teacher-add-contributions')->with('error','Error occured');
            }
           
        }
    
        public function teacherDeleteContribution(Request $request){
    
            try {
    
                Contribution::where('id',$request->id)->where('schools_id',Session::get('school_id'))->delete();
                return redirect()->to('teacher-add-contributions')->with('success','Deleted Successfuly...!!');
            } catch (\Throwable $th) {
                return redirect()->to('teacher-add-contributions')->with('error','Error occured');
            }
           
        }


        // Contribution collection 
        public function teacherCollectContribution(Request $request){
            $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
            $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
            $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
            $students = [];
            $students_fees_paid = StudentContribution::select('contribution_payments.amount as amount')
                                ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                                ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
            $terms = Term::where('schools_id',Session::get('school_id'))->get();
            return view('teaching_staffs.contributions.contribution_collection')
                   ->with('current_year',$current_year)
                   ->with('total_students',$total_students)
                   ->with('total_students_fees',$total_students_fees)
                   ->with('data',$students)
                   ->with('terms',$terms)
                   ->with('students_fees_paid',$students_fees_paid);
        
        
            }
            
            public function teacherGetClassContribution(Request $request){
    
                $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
                $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
                $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
                $students = StudentContribution::select('student_contributions.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_contributions.amount as amount')
                            ->join('students','students.id','=','student_contributions.students_id')            
                            ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                            ->where('student_contributions.darasas_id',$request->darasas_id)
                            ->get();
                $students_fees_paid = StudentContribution::select('contribution_payments.amount as amount')
                                    ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                                    ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
                $terms = Term::where('schools_id',Session::get('school_id'))->get();
                return view('teaching_staffs.contributions.contribution_collection')
                       ->with('current_year',$current_year)
                       ->with('total_students',$total_students)
                       ->with('total_students_fees',$total_students_fees)
                       ->with('data',$students)
                       ->with('terms',$terms)
                       ->with('students_fees_paid',$students_fees_paid); 
            }
    
            public function teacherEditContributionPayment(Request $request){
                try {
                    DB::beginTransaction();
                    $fee = StudentContribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                    if ($request->amount == "") {
                    $fee->amount = 0;
                    $fee->save();
                    } else {
                        $fee->amount = $request->amount;
                        $fee->save();
                    }
                 
                    DB::commit();
                    return redirect()->to('/teacher-collect-contributions')->with('success','Successfuly Contribution Updated.....!!!');
                   } catch (\Throwable $th) {
                      return redirect()->to('/teacher-collect-contributions')->with('error','Error occured.....!!!');
                   }
                
            }public function teacherSaveContributionPayment(Request $request){
        
                try {
                 DB::beginTransaction();
                 $contribution = StudentContribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                 if ($contribution->amount <= 0) {
                   return redirect()->to('/teacher-collect-contributions')->with('success','Thanks You!! Your Balance is Empty');
                 }
                 $contribution->amount = $contribution->amount - $request->amount;
                 $contribution->save();
           
                 $paid_contribution = new ContributionPayment();
                 $paid_contribution->schools_id = Session::get('school_id');
                 $paid_contribution->student_contributions_id = $request->id;
                 $paid_contribution->methode_name = $request->methode_name;
                 $paid_contribution->terms_id = $request->terms_id;
                 $paid_contribution->methode = $request->methode;
                 $paid_contribution->number = $request->number;
                 $paid_contribution->amount = $request->amount;
                 $paid_contribution->date = $request->date;
                 $paid_contribution->save();
                 DB::commit();
                 return redirect()->to('/teacher-collect-contributions')->with('success','Successfuly Payment saved.....!!!');
                } catch (\Throwable $th) {
                   return redirect()->to('/teacher-collect-contributions')->with('error','Error occured.....!!!');
                }
               }
    
               public function teacherViewContributionPayments(Request $request){
                $student_fee = StudentContribution::where('schools_id',Session::get('school_id'))->where('id',$request->id)->first();
                $student = Student::where('schools_id',Session::get('school_id'))->where('id',$student_fee->students_id)->first();
                $contribution_payments = ContributionPayment::
                                select('contribution_payments.id as id',
                                'contribution_payments.amount as amount',
                                'contribution_payments.date as date',
                                'terms.name as term_name')->where('terms.schools_id',Session::get('school_id'))
                                ->where('contribution_payments.student_contributions_id',$request->id)
                                ->join('terms','terms.id','=','contribution_payments.terms_id')->get();
                return view('teaching_staffs.contributions.contribution_payments')->with('fee_payments',$contribution_payments)
                       ->with('student',$student);
               
            }

            public function teacherContributionReports(Request $request){

                $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
                $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
                $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
                $students = StudentContribution::select('student_contributions.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_contributions.amount as amount')
                            ->join('students','students.id','=','student_contributions.students_id')            
                            ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                            ->where('student_contributions.darasas_id',$request->darasas_id)
                            ->get();
                $students_fees_paid = StudentContribution::select('student_fee_payments.amount as amount')
                                    ->where('contribution_payments.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                                    ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
                $terms = Term::where('schools_id',Session::get('school_id'))->get();
                $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
                $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
                return view('teaching_staffs.contributions.report')
                ->with('current_year',$current_year)
                ->with('total_students',$total_students)
                ->with('total_students_fees',$total_students_fees)
                ->with('data',$students)
                ->with('terms',$terms)
                ->with('classes',$classes)
                ->with('years',$years)
                ->with('students_fees_paid',$students_fees_paid);
            }
            public function teacherGetClassContributionReport(Request $request){
                $current_year = AcademicYear::where('schools_id',Session::get('school_id'))->where('isCurrent',true)->first();
                $total_students = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->count();
                $total_students_fees = StudentContribution::where('schools_id',Session::get('school_id'))->where('academic_years_id',$current_year->id)->sum('amount');
                $students_fees_paid = StudentContribution::select('student_fee_payments.amount as amount')
                ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$current_year->id)
                ->join('contribution_payments','contribution_payments.student_contributions_id','=','student_contributions.id')->sum('contribution_payments.amount');
                $terms = Term::where('schools_id',Session::get('school_id'))->get();
                $classes = Darasa::where('schools_id',Session::get('school_id'))->get();
                $years = AcademicYear::where('schools_id',Session::get('school_id'))->get();
                if ($request->filter_name == 'Class') {
                    $students = StudentContribution::select('student_contributions.id as id','students.fname as fname','students.lname as lname','students.photo as photo','student_contributions.amount as amount')
                    ->join('students','students.id','=','student_contributions.students_id')            
                    ->where('student_contributions.schools_id',Session::get('school_id'))->where('student_contributions.academic_years_id',$request->year)
                    ->where('student_contributions.darasas_id',$request->darasa_id)
                    ->get();
                    return view('teaching_staffs.contributions.report')
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

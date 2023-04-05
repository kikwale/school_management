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
use PDF;

class PdfController extends Controller
{
    public function teacherDownloadPdf(Request $request){
        //return $request->all();
        try {
            $school = School::where('id',$request->scl_id)->first();
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
                        ->join('terms','terms.id','=','student_fee_payments.terms_id')
                        ->where('student_fee_payments.id',$request->feepymnt_id)->first();
           $fee_balance = StudentFee::where('id',$fee_payment->student_fees_id)->first();
           $student = Student::where('id',$fee_payment->student_fees_id)->first();
           $parent = Wazazi::where('wazazis.users_id',$request->prnt_id)
                   ->join('users','users.id','=','wazazis.users_id')->first();
            
           $data = $school;
           $data['fee_payment_id'] = $fee_payment->id;
           $data['methode'] = $fee_payment->methode;
           $data['provider'] = $fee_payment->provider;
           $data['number'] = $fee_payment->number;
           $data['amount'] = $fee_payment->amount;
           $data['date'] = $fee_payment->date;
           $data['parent_fname'] = $parent->fname;
           $data['parent_lname'] = $parent->lname;
           $data['parent_email'] = $parent->email;
           $data['parent_phone'] = $parent->phone;
           $data['student_fname'] = $student->fname;
           $data['student_lname'] = $student->lname;
           $data['student_health_problem'] = $student->health_problem;
           $data['title'] = 'Fee Receipt';
           //return $data;
           
            $pdf = PDF::loadView('fee_pdf_receipt',compact('data'));
            return $pdf->download('fee_receipt.pdf');
        } catch (\Throwable $th) {
            //throw $th;
        }
        
       
    }
}

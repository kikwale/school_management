<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\Darasa;
use App\Models\Expenses;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class ExpensesController extends Controller 
{
    public function mexpenses(){
        $expenses = Expenses::where('schools_id',Session::get('school_id'))->get();
        return view('manager.expenses.index')->with('data',$expenses);
    }

    public function msaveExpenses(Request $request){
        $expenses = new Expenses;
        $expenses->schools_id = Session::get('school_id');
        $expenses->date = $request->date;
        $expenses->amount = $request->amount;
        $expenses->description = $request->description;
        $expenses->save();
        return redirect()->to('/mExpenses')->with('success','New Expenses created Successfuly...!');
    }

    public function meditExpenses(Request $request){

        $expenses = Expenses::where('id',$request->expenses_id)->where('schools_id',Session::get('school_id'))->first();
        $expenses->date = $request->date;
        $expenses->amount = $request->amount;
        $expenses->description = $request->description;
        $expenses->save();
        return redirect()->to('/mExpenses')->with('success','Expenses Edited Successfuly...!');
    }

    public function mdeleteExpenses(Request $request){
        Expenses::where('id',$request->expenses_id)->where('schools_id',Session::get('school_id'))->delete();
        return redirect()->to('/mExpenses')->with('success','Expenses Deleted Successfuly...!');
    }
}

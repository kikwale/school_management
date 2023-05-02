<?php

namespace App\Http\Controllers;

use App\Models\StudentsRoutine;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoutineController extends Controller
{
    public function index()
    {
        $data = StudentsRoutine::where('schools_id', Session::get('school_id'))->get();

        return view('teaching_staffs.school_activities.students_routine', compact('data'));
    }

    public function createRoutine(Request $request)
    {
        # Incoming data validation
        try {
            $validatedRoutines = $request->validate([
                'name' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'desc' => 'required',
            ]);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception);
        }

        # Creating new Routines
        $newRoutines = StudentsRoutine::create([
            'schools_id' => Session::get('school_id'),
            'activity' => $request->name,
            'starting_time' => $request->start_time,
            'ending_time' => $request->end_time,
            'description' => $request->desc,
        ]);
        return redirect('/student-routines');
    }
}

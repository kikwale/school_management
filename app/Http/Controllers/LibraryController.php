<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Librarian;
use App\Models\LibraryUser;
use App\Models\BookBorrower;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LibraryController extends Controller
{
    // Teachers Methods
    public function teacherBooks()
    {
        $data = Book::where('schools_id', Session::get('school_id'))->get();
        return view('teaching_staffs.library.books')->with('data', $data);
    }

    public function teacherSaveBook(Request $request)
    {

        try {
            DB::beginTransaction();
            $book = new Book;
            $book->schools_id = Session::get('school_id');
            $book->name = $request->name;
            $book->author = $request->author;
            $book->volume = $request->volume;
            $book->edition = $request->edition;
            $book->book_number = $request->book_number;
            $book->location = $request->location;
            $book->save();
            DB::commit();
            return redirect()->to('teacher-books')->with('success', 'Successfully.......!!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-books')->with('error', 'Error Occured...!!!');
        }
    }

    public function teacherEditBook(Request $request)
    {
        try {
            DB::beginTransaction();
            $book = Book::where('schools_id', Session::get('school_id'))->where('id', $request->id)->first();
            $book->name = $request->name;
            $book->author = $request->author;
            $book->volume = $request->volume;
            $book->edition = $request->edition;
            $book->book_number = $request->book_number;
            $book->location = $request->location;
            $book->save();
            DB::commit();
            return redirect()->to('teacher-books')->with('success', 'Successfully.......!!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-books')->with('error', 'Error Occured...!!!');
        }
    }

    public function teacherDeleteBook(Request $request)
    {
        Book::where('schools_id', Session::get('school_id'))->where('id', $request->id)->delete();
        return redirect()->to('teacher-books')->with('success', 'Successfully.......!!!');
    }

    public function teacherLibraryUsers()
    {
        $books = Book::where('schools_id', Session::get('school_id'))->get();
        $data = LibraryUser::where('schools_id', Session::get('school_id'))->get();
        return view('teaching_staffs.library.users')->with('data', $data)->with('books', $books);
    }

    public function teacherSaveLibraryUser(Request $request)
    {

        try {
            DB::beginTransaction();
            $library_user =  new LibraryUser;
            $library_user->schools_id = Session::get('school_id');
            $library_user->fullname = $request->fullname;
            $library_user->date = $request->date;
            $library_user->user_type = $request->user_type;
            $library_user->phone = $request->phone;
            $library_user->entry_time = $request->entry_time;
            $library_user->save();
            DB::commit();
            return redirect()->to('teacher-library-users')->with('success', 'Successfully...!!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-library-users')->with('error', 'Error Occured...!!!');
        }
    }

    public function teacherEditLibraryUser(Request $request)
    {

        try {
            DB::beginTransaction();
            $library_user = LibraryUser::where('schools_id', Session::get('school_id'))->where('id', $request->id)->first();
            $library_user->fullname = $request->fullname;
            $library_user->date = $request->date;
            $library_user->user_type = $request->user_type;
            $library_user->phone = $request->phone;
            $library_user->entry_time = $request->entry_time;
            $library_user->outing_time = $request->outing_time;
            $library_user->save();
            DB::commit();
            return redirect()->to('teacher-library-users')->with('success', 'Successfully...!!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-library-users')->with('error', 'Error Occured...!!!');
        }
    }

    public function teacherDeleteLibraryUser(Request $request)
    {

        try {
            DB::beginTransaction();
            LibraryUser::where('schools_id', Session::get('school_id'))->where('id', $request->id)->delete();

            DB::commit();
            return redirect()->to('teacher-library-users')->with('success', 'Successfully...!!!');
        } catch (\Throwable $th) {
            return redirect()->to('teacher-library-users')->with('error', 'Error Occured...!!!');
        }
    }

    public function teacherBorrowers()
    {
        $books = Book::where('schools_id', Session::get('school_id'))->get();
        $library_users = LibraryUser::where('schools_id', Session::get('school_id'))->get();
        $borrowers = [];
        return view('teaching_staffs.library.borrowers')->with('data', $borrowers)
            ->with('books', $books)
            ->with('library_users', $library_users);
    }

    public function teacherBorrowerForm()
    {
        $books = Book::where('schools_id', Session::get('school_id'))->get();
        $library_users = LibraryUser::where('schools_id', Session::get('school_id'))->get();
        $borrowers = BookBorrower::where('schools_id', Session::get('school_id'))->get();
        return view('teaching_staffs.library.borrowing_form')->with('data', $borrowers)
            ->with('books', $books)
            ->with('library_users', $library_users);
    }

    public function teacherSaveBorrowerForm(Request $request)
    {

        try {
            DB::beginTransaction();
            $borrowers = new BookBorrower;
            foreach ($request['books_id']  as $key => $book_id) {
                $borrowers->schools_id = Session::get('school_id');
                $borrowers->books_id  = $book_id;
                $borrowers->library_users_id  = $request->library_users_id;
                $borrowers->borrowing_date  = $request->borrowing_date;
                $borrowers->returning_date  = $request->returning_date;
                $borrowers->save();
                DB::commit();
            }
            return back()->with('success', 'Successfuly...!!!');
        } catch (\Throwable $th) {
            // return $th;
            return back()->with('error', 'Error Occured...!!!');
        }
    }

    public function teachereFilterBorrowers(Request $request)
    {
        // return $request->all();
        $books = Book::where('schools_id', Session::get('school_id'))->get();
        $library_users = LibraryUser::where('schools_id', Session::get('school_id'))->get();
        $borrowers = BookBorrower::select(
            'book_borrowers.library_users_id as library_users_id',
            'library_users.fullname',
            'books.name as book_name',
            'book_borrowers.borrowing_date',
            'book_borrowers.id as id',
            'book_borrowers.returning_date'
        )
            ->where('book_borrowers.schools_id', Session::get('school_id'))
            ->where('book_borrowers.isReturned', false)
            ->where('library_users.user_type', $request->user_type)
            ->join('books', 'books.id', '=', 'book_borrowers.books_id')
            ->join('library_users', 'library_users.id', '=', 'book_borrowers.library_users_id')
            ->groupBy('id', 'library_users_id', 'fullname', 'book_name', 'returning_date', 'borrowing_date')
            ->get();

        return view('teaching_staffs.library.borrowers')->with('data', $borrowers)
            ->with('books', $books)
            ->with('library_users', $library_users);
    }

    public function teacherDeleteBorrowers(Request $request)
    {
        try {
            BookBorrower::where('schools_id', Session::get('school_id'))->where('id', $request->id)->delete();
            return redirect()->to('/teacher-borrowers')->with('success', 'Deleted Successfuly......!!!');
        } catch (\Throwable $th) {
            return redirect()->to('/teacher-borrowers')->with('error', 'Error Occured......!!!');
        }
    }

    public function mLibrarian()
    {
        $librarians = Librarian::where('librarians.schools_id', Session::get('school_id'))
            ->join('users', 'users.id', '=', 'librarians.users_id')->get();
        return view('manager.librarian.index')->with('data', $librarians);
    }

    public function msaveLibrarian(Request $request)
    {
        $user = new User;
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->role = "Librarian";
        $user->password = Hash::make($request->phone);
        $user->save();
        $user_id = $user->id;

        $librarian = [];
        $librarian = $request->all();
        $librarian['users_id'] = $user->id;
        $librarian['schools_id'] = Session::get('school_id');
        Librarian::create($librarian);
        return redirect()->to('/mLibrarians')->with('success', 'New Librarian created Successfuly...!');
    }

    public function meditLibrarian(Request $request)
    {

        $user = User::where('id', $request->user_id)->first();
        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();
        $librarian = Librarian::where('users_id', $request->user_id)->where('schools_id', Session::get('school_id'))->first();
        $librarian->edu_level = $request->edu_level;
        $librarian->salary = $request->salary;
        $librarian->save();
        return redirect()->to('/mLibrarians')->with('success', 'Librarian Edited Successfuly...!');
    }

    public function mdeleteLibrarian(Request $request)
    {
        User::where('id', $request->teacher_id)->delete();
        Librarian::where('users_id', $request->teacher_id)->where('schools_id', Session::get('school_id'))->delete();
        return redirect()->to('/mLibrarians')->with('success', 'Librarian is Deleted Successfuly...!');
    }
}

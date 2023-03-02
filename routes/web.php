<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', function () {
  return view('auth.register');
});

Route::get('/user-guid', function() {
  return view('user_guid');
 });

Route::get('/contact', function () {
  return view('contact');
});


// Admin


// Route::group(['middleware'=>'auth'], function () {
//   Route::get('/super-admin', 'RedirectController@superAdmin')->name('super_admin.redirect');

//   //Staffs
//   Route::get('/admin-teaching-staffs', 'TeachersController@adminTeachingStaffs')->name('admin.teaching-staffs');

//   Route::post('/saveTrader', 'HomeController@saveTrader');
//   Route::get('/adminUsers', 'HomeController@adminUsers');
//   Route::get('/admin_register_shop','HomeController@admin_register_shop');
//   Route::post('/admin_save_shop','HomeController@admin_save_shop');
//   Route::get('/admin_shops','HomeController@admin_shops');
// });

// Admin


Route::group(['middleware'=>'auth'], function () {
  Route::get('/admin', 'RedirectController@admin')->name('admin.redirect');

  //Staffs
  Route::get('/admin-teaching-staffs', 'TeachersController@adminTeachingStaffs')->name('admin.teaching-staffs');
  Route::post('/admin-save-teacher', 'TeachersController@adminSaveTeacher')->name('admin.save-teacher');
  Route::post('/admin-edit-teacher', 'TeachersController@adminEditTeacher')->name('admin.edit-teacher');
  Route::post('/admin-delete-teacher', 'TeachersController@adminDeleteTeacher')->name('admin.delete-teacher');
  //Other Staffs
  Route::get('/admin-non-teaching-staffs', 'NonTeachersController@adminNonTeachingStaffs')->name('admin.non-teaching-staffs');
  Route::post('/admin-save-non-teacher', 'NonTeachersController@adminSaveNonTeacher')->name('admin.save-non-teacher');
  Route::post('/admin-edit-non-teacher', 'NonTeachersController@adminEditNonTeacher')->name('admin.edit-non-teacher');
  Route::post('/admin-delete-non-teacher', 'NonTeachersController@adminDeleteNonTeacher')->name('admin.delete-non-teacher');
  //create Classes
  Route::get('/admin-create-classes', 'ClassController@adminCreateClasses')->name('admin.create-classes');
  Route::post('/admin-save-class', 'ClassController@adminSaveClass')->name('admin.save-class');
  Route::post('/admin-edit-class', 'ClassController@adminEditClass')->name('admin.edit-class');
  Route::post('/admin-delete-class', 'ClassController@adminDeleteClass')->name('admin.delete-class');
  //create terms
  Route::get('/admin-create-terms', 'TermsController@adminCreateTerms')->name('admin.create-terms');
  Route::post('/admin-save-term', 'TermsController@adminSaveTerm')->name('admin.save-term');
  Route::post('/admin-edit-term', 'TermsController@adminEditTerm')->name('admin.edit-term');
  Route::post('/admin-delete-term', 'TermsController@adminDeleteTerm')->name('admin.delete-term');
  
  //create Streams/Combinations
  Route::get('/admin-create-streams-combs', 'StreamCombController@adminCreateStreamsCombs')->name('admin.create-streams-combs');
  Route::post('/admin-save-streams-comb', 'StreamCombController@adminSaveStreamsComb')->name('admin.save-streams-comb');
  Route::post('/admin-edit-streams-comb', 'StreamCombController@adminEditStreamsComb')->name('admin.edit-streams-comb');
  Route::post('/admin-delete-streams-comb', 'StreamCombController@adminDeleteStreamsComb')->name('admin.delete-streams-comb');
  
});







//manager Routes

Route::group(['middleware'=>'auth'], function () {
  
Route::get('/manager', 'RedirectController@manager')->name('manager.redirect');
Route::post('/save-school','SchoolController@saveSchool')->name('manager.save-school');
Route::get('/school','SchoolController@index')->name('manager.school-index');
Route::get('/mteachers','TeachersController@mteachers')->name('manager.teachers');
Route::get('/home-dashboard','SchoolController@homeDashboard')->name('manager.home-dashboard');
Route::post('/msaveTeacher','TeachersController@msaveTeacher')->name('manager.saveTeacher');
Route::post('/meditTeacher','TeachersController@meditTeacher')->name('manager.editTeacher');
Route::post('/mdelete-teacher','TeachersController@mdeleteTeacher')->name('manager.delete-teacher');
Route::get('/mnon-teachers','NonTeachersController@mNonTeachers')->name('manager.non-teachers');
Route::post('/msaveNonTeacher','NonTeachersController@msaveNonTeacher')->name('manager.msaveNonTeacher');
Route::post('/medit-non-teacher','NonTeachersController@meditNonTeacher')->name('manager.edit-non-teacher');
Route::post('/mdelete-non-teacher','NonTeachersController@mdeleteNonTeacher')->name('manager.delete-non-teacher');

//parents
Route::get('/mparents','ParentsController@mparents')->name('manager.parents');
Route::post('/msaveParent','ParentsController@msaveParent')->name('manager.saveParent');
Route::post('/medit-parent','ParentsController@meditParent')->name('manager.edit-parent');
Route::post('/mdelete-parent','ParentsController@mdeleteParent')->name('manager.delete-parent');

//Students 
Route::get('/mstudents','StudentsController@mstudents')->name('manager.students');
Route::post('/msaveStudent','StudentsController@msaveStudent')->name('manager.saveStudent');
Route::post('/medit-student','StudentsController@meditStudent')->name('manager.edit-student');
Route::post('/mdelete-student','StudentsController@mdeleteStudent')->name('manager.delete-student');


//Librarian 
Route::get('/mLibrarians','LibraryController@mLibrarian')->name('manager.librarian');
Route::post('/msaveLibrarian','LibraryController@msaveLibrarian')->name('manager.saveLibrarian');
Route::post('/meditLibrarian','LibraryController@meditLibrarian')->name('manager.edit-librarian');
Route::post('/mDeleteLibrarian','LibraryController@mdeleteLibrarian')->name('manager.delete-librarian');

//Classes 
Route::get('/mClasses','ClassController@mClasses')->name('manager.classes');
Route::post('/msaveClass','ClassController@msaveClass')->name('manager.saveClass');
Route::post('/meditClass','ClassController@meditClass')->name('manager.edit-Class');
Route::post('/mDeleteClass','ClassController@mdeleteClass')->name('manager.delete-Class');

//Subjects
Route::get('/mSubjects','SubjectsController@mSubjects')->name('manager.subjects');
Route::post('/msaveSubject','SubjectsController@msaveSubject')->name('manager.saveSubject');
Route::post('/meditSubject','SubjectsController@meditSubject')->name('manager.editSubject');
Route::post('/mDeleteSubject','SubjectsController@mDeleteSubject')->name('manager.deleteSubject');

// Expenses
Route::get('/mExpenses','ExpensesController@mexpenses')->name('manager.expenses');
Route::post('/msaveExpenses','ExpensesController@msaveExpenses')->name('manager.saveExpenses');
Route::post('/meditExpenses','ExpensesController@meditExpenses')->name('manager.edit-expenses');
Route::post('/mdeleteExpenses','ExpensesController@mdeleteExpenses')->name('manager.delete-expenses');

// setting-student-class
Route::get('/msetting-student-class','StudentsController@msettingStudentClass')->name('manager.setting-student-class');
Route::post('/msaveSettingStudentClass','StudentsController@msaveSettingStudentClass')->name('manager.savesettingStudentClass');
Route::post('/meditSettingStudentClass','StudentsController@meditSettingStudentClass')->name('manager.editsettingStudentClass');
Route::post('/mdeleteSettingStudentClass','StudentsController@mdeleteSettingStudentClass')->name('manager.deletesettingStudentClass');
Route::post('/mupgradeSettingStudentClass','StudentsController@mupgradeSettingStudentClass')->name('manager.upgradeSettingStudentClass');

// setting-teacher-class
Route::get('/msetting-teacher-class','TeachersController@msettingTeacherClass')->name('manager.setting-teacher-class');
Route::post('/msaveSetting-teacher-class','TeachersController@msaveSettingTeacherClass')->name('manager.saveSetting-teacher-class');
Route::post('/meditSetting-teacher-class','TeachersController@meditSettingTeacherClass')->name('manager.editSetting-teacher-class');
Route::post('/mdeleteSetting-teacher-class','TeachersController@mdeleteSettingTeacherClass')->name('manager.deleteSetting-teacher-class');
Route::get('/mfilter-subjects','TeachersController@mfilterSubjects')->name('manager.filter-subjects');


//setting-class-subjects
Route::get('/msetting-subjects-class','SubjectsController@msettingSubjectsClass')->name('manager.setting-subjects-class');
Route::post('/msave-setting-subjects-class','SubjectsController@msaveSettingSubjectsClass')->name('manager.save-setting-subjects-class');
Route::post('/medit-setting-subjects-class','SubjectsController@meditSettingSubjectsClass')->name('manager.edit-setting-subjects-class');
Route::post('/mdelete-setting-subjects-class','SubjectsController@mDeleteSettingSubjectsClass')->name('manager.delete-setting-subjects-class');

//setting-contributions
Route::get('/msetting-contributions','ContributionsController@msettingContributions')->name('manager.setting-contributions');
Route::post('/msave-setting-contributions','ContributionsController@msaveSettingContributions')->name('manager.save-setting-contributions');
Route::post('/medit-setting-contributions','ContributionsController@meditSettingContributions')->name('manager.edit-setting-contributions');
Route::post('/mdelete-setting-contributions','ContributionsController@mDeleteSettingContributions')->name('manager.delete-setting-contributions');
Route::get('/mfilter-students','ContributionsController@mfilterStudents')->name('manager.filter-students');

//setting-fees
Route::get('/msetting-fees','FeesController@msettingFees')->name('manager.setting-fees');
Route::post('/msave-setting-fees','FeesController@msaveSettingFees')->name('manager.save-setting-fees');
Route::post('/medit-setting-fees','FeesController@meditSettingFees')->name('manager.edit-setting-fees');
Route::post('/mdelete-setting-fees','FeesController@mDeleteSettingFees')->name('manager.delete-setting-fees');
Route::get('/mfilter-fee-students','FeesController@mfilterStudents')->name('manager.filter-fee-students');

//School Fees
Route::get('/mschool-record-fees','FeesController@index')->name('manager.school-fees');
Route::post('/msave-school-fees','FeesController@msaveSchoolFees')->name('manager.save-school-fees');
Route::post('/medit-school-fees','FeesController@meditSchoolFees')->name('manager.edit-school-fees');
Route::post('/mdelete-school-fees','FeesController@mDeleteSchoolFees')->name('manager.delete-school-fees');

//School Contributions
Route::get('/mschool-record-contributions','ContributionsController@index')->name('manager.school-contributions');
Route::post('/msave-school-contributions','ContributionsController@msaveSchoolContributions')->name('manager.save-school-contributions');
Route::post('/medit-school-contributions','ContributionsController@meditSchoolContributions')->name('manager.edit-school-contributions');
Route::post('/mdelete-school-contributions','ContributionsController@mDeleteSchoolContributions')->name('manager.delete-school-contributions');

// Fees
Route::get('/mfees','FeesController@mfees')->name('manager.fees');
Route::post('/msave-fees','FeesController@msaveFees')->name('manager.save-fees');
Route::post('/medit-fees','FeesController@meditFees')->name('manager.edit-fees');
Route::post('/mdelete-fees','FeesController@mDeleteFees')->name('manager.delete-fees');

// contributions
Route::get('/mcontributions','ContributionsController@mcontributions')->name('manager.contributions');
Route::post('/msave-contributions','ContributionsController@msaveContributions')->name('manager.save-contributions');
Route::post('/medit-contributions','ContributionsController@meditContributions')->name('manager.edit-contributions');
Route::post('/mdelete-contributions','ContributionsController@mDeleteContributions')->name('manager.delete-contributions');
// results
Route::get('/mget-class-subjects','ResultsController@mgetClassSubjects')->name('manager.get-class-subjects');
Route::get('/mget-list','ResultsController@mResultsList')->name('manager.get-list');
Route::post('/mschool-record-results','ResultsController@index')->name('manager.school-record-results');
Route::post('/msave-student-results','ResultsController@msaveStudentResults')->name('manager.save-student-results');
Route::get('/medit-results','ResultsController@meditResults')->name('manager.edit-result');
Route::post('/medit-student-results','ResultsController@meditStudentResults')->name('manager.edit-student-results');
// Route::post('/mdelete-contributions','ResultsController@mDeleteContributions')->name('manager.delete-contributions');

Route::get('/madmin','HomeController@schoolAdmin')->name('manager.admin');
Route::post('/madmin-save','HomeController@schoolAdminSave')->name('manager.admin-save');

});








Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{lang}', function($lang){
  App::setLocale($lang);
  Session::put('locale', $lang);
  return back();

})->name('app.lang');
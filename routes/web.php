<?php

use App\Http\Middleware\TeachingStaffsMiddleware;
use GuzzleHttp\Middleware;
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

Route::get('/user-guid', function () {
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


Route::group(['middleware' => 'auth'], function () {
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

  //create Subjects
  Route::get('/admin-create-subjects', 'SubjectsController@adminCreateSubjects')->name('admin.create-subjects');
  Route::post('/admin-save-subject', 'SubjectsController@adminSaveSubject')->name('admin.save-subject');
  Route::post('/admin-edit-subject', 'SubjectsController@adminEditSubject')->name('admin.edit-subject');
  Route::post('/admin-delete-subject', 'SubjectsController@adminDeleteSubject')->name('admin.delete-subject');
  //Add Contributions
  Route::get('/admin-add-contributions', 'ContributionsController@adminAddContributions')->name('admin.add-contributions');
  Route::post('/admin-save-contribution', 'ContributionsController@adminSaveContribution')->name('admin.save-contribution');
  Route::post('/admin-edit-contribution', 'ContributionsController@adminEditContribution')->name('admin.edit-contribution');
  Route::post('/admin-delete-contribution', 'ContributionsController@adminDeleteContribution')->name('admin.delete-contribution');
  //Add Fees
  Route::get('/admin-add-fees', 'FeesController@adminAddFees')->name('admin.add-fees');
  Route::post('/admin-save-fee', 'FeesController@adminSaveFee')->name('admin.save-fee');
  Route::post('/admin-edit-fee', 'FeesController@adminEditFee')->name('admin.edit-fee');
  Route::post('/admin-delete-fee', 'FeesController@adminDeleteFee')->name('admin.delete-fee');
  //Add Parents
  Route::get('/admin-parents', 'ParentsController@adminParents')->name('admin.parents');
  Route::post('/admin-save-parent', 'ParentsController@adminSaveParent')->name('admin.save-parent');
  Route::post('/admin-edit-parent', 'ParentsController@adminEditParent')->name('admin.edit-parent');
  Route::post('/admin-delete-parent', 'ParentsController@adminDeleteParent')->name('admin.delete-parent');
  //Add Students
  Route::get('/admin-students', 'StudentsController@adminStudents')->name('admin.students');
  Route::post('/admin-save-student', 'StudentsController@adminSaveStudent')->name('admin.save-student');
  Route::post('/admin-edit-student', 'StudentsController@adminEditStudent')->name('admin.edit-student');
  Route::post('/admin-delete-student', 'StudentsController@adminDeleteStudent')->name('admin.delete-student');

  //admin-academic-year
  Route::get('/admin-academic-years', 'HomeController@adminYears')->name('admin.years');
  Route::post('/admin-save-year', 'HomeController@adminSaveYear')->name('admin.save-year');
  Route::post('/admin-edit-year', 'HomeController@adminEditYear')->name('admin.edit-year');
  Route::post('/admin-delete-year', 'HomeController@adminDeleteYear')->name('admin.delete-year');

  //admin-class-students
  Route::get('/admin-class-students', 'OperationController@adminClassStudents')->name('admin.class-students');
  Route::post('/admin-save-class-students', 'OperationController@adminSaveClassStudents')->name('admin.save-class-students');

  //admin-class-subjects
  Route::get('/admin-class-subjects', 'OperationController@adminClassSubjects')->name('admin.class-subjects');
  Route::post('/admin-save-class-subject', 'OperationController@adminSaveClassSubjects')->name('admin.save-class-subjects');
  Route::post('/admin-edit-class-subject', 'OperationController@adminEditClassSubjects')->name('admin.edit-class-subjects');
  Route::post('/admin-delete-class-subject', 'OperationController@adminDeleteClassSubjects')->name('admin.delete-class-subjects');

  //admin-class-Teacher
  Route::get('/admin-class-teachers', 'OperationController@adminClassTeachers')->name('admin.class-teachers');
  Route::post('/admin-save-class-teacher', 'OperationController@adminSaveClassTeacher')->name('admin.save-class-teacher');
  Route::post('/admin-edit-class-teacher', 'OperationController@adminEditClassTeacher')->name('admin.edit-class-teacher');
  Route::post('/admin-delete-class-teacher', 'OperationController@adminDeleteClassTeacher')->name('admin.delete-class-teacher');

  //admin-set-fees
  Route::get('/admin-set-fees', 'FeesController@adminSetFees')->name('admin.set-fees');
  Route::post('/admin-save-set-fee', 'FeesController@adminSaveSetFee')->name('admin.save-set-fee');
  //admin-set-contributions
  Route::get('/admin-set-contributions', 'ContributionsController@adminSetContributions')->name('admin.set-contributions');
  Route::post('/admin-save-set-contribution', 'ContributionsController@adminSaveSetContribution')->name('admin.save-set-contribution');
  //admin-set-contributions
  Route::get('/admin-promote', 'SettingController@adminPromote')->name('admin.promote');
  Route::post('/admin-save-promote', 'SettingController@adminSavePromote')->name('admin.save-promote');
  Route::get('/admin-get-classes', 'SettingController@getClasses')->name('admin.get-classes');
  Route::get('/admin-get-classes-to', 'SettingController@getClassesTo')->name('admin.get-classes-to');

  //admin Students Parent
  Route::get('/admin-students-parent', 'ParentsController@studentsParent')->name('admin.students-parent');
  Route::post('/admin-save-students-parent', 'ParentsController@adminSaveStudentsParent')->name('admin.save-students-parent');

  //admin-collect-fees
  Route::get('/admin-collect-fees', 'FeesController@adminCollectFees')->name('admin.collect-fees');
  Route::post('/admin-save-fee-payment', 'FeesController@adminSaveFeePayment')->name('admin.save-fee-payment');
  Route::post('/admin-edit-fee-payment', 'FeesController@adminEditFeePayment')->name('admin.edit-fee-payment');
  Route::get('/adminGetClasses', 'FeesController@adminGetClasses')->name('admin.getClasses');
  Route::post('/adminGetClassFee', 'FeesController@adminGetClassFee')->name('admin.getClassFee');
  Route::get('/admin-view-fee-payments', 'FeesController@adminViewFeePayments')->name('admin.view-fee-payments');

  //admin-fee-reports
  Route::get('/admin-fee-reports', 'FeesController@adminFeeReports')->name('admin.fee-reports');
  Route::get('/adminGetClassesReport', 'FeesController@adminGetClassesReport')->name('admin.getClassesReport');
  Route::post('/adminGetClassFeeReport', 'FeesController@adminGetClassFeeReport')->name('admin.getClassFeeReport');
  Route::get('/adminGetStreamReport', 'FeesController@adminGetStreamReport')->name('admin.getStreamReport');
  Route::get('/adminGetStream', 'FeesController@adminGetStream')->name('admin.getStream');

  //admin-collect-contributions
  Route::get('/admin-collect-contributions', 'ContributionsController@adminCollectContribution')->name('admin.collect-contributions');
  Route::post('/admin-save-contribution-payment', 'ContributionsController@adminSaveContributionPayment')->name('admin.save-contribution-payment');
  Route::post('/admin-edit-contribution-payment', 'ContributionsController@adminEditContributionPayment')->name('admin.edit-contribution-payment');
  Route::get('/adminGetClasses-contribution', 'ContributionsController@adminGetClasses')->name('admin.getClasses-contribution');
  Route::post('/adminGetClassContribution', 'ContributionsController@adminGetClassContribution')->name('admin.getClassContribution');
  Route::get('/admin-view-contribution-payments', 'ContributionsController@adminViewContributionPayments')->name('admin.view-contribution-payments');

  //admin-contribution-reports 
  Route::get('/admin-contribution-reports', 'ContributionsController@adminContributionReports')->name('admin.contribution-reports');
  Route::get('/adminGetClassesReport-contribution', 'ContributionsController@adminGetClassesReportContribution')->name('admin.getClassesReportContribution');
  Route::post('/adminGetClassContributionReport', 'ContributionsController@adminGetClassContributionReport')->name('admin.getClassContributionReport');
  Route::get('/adminGetStreamReport-contribution', 'ContributionsController@adminGetStreamReportContribution')->name('admin.getStreamReportContribution');
  //  Route::get('/adminGetStream','ContributionsController@adminGetStream')->name('admin.getStream');

  Route::middleware([TeachingStaffsMiddleware::class])->group(function () {
    // results
    Route::get('/record-results', 'ResultsController@recordResults')->name('teacher.record-results');
    Route::get('/getTeacherStream', 'ResultsController@getTeacherStream')->name('teacher.getTeacherStream');
    Route::get('/getTeacherSubject', 'ResultsController@getTeacherSubject')->name('teacher.getTeacherSubject');
    Route::post('/teacher-get-class-students', 'ResultsController@getClassStudents')->name('teacher.getClassStudents');
    // Route::get('/mget-list','ResultsController@mResultsList')->name('manager.get-list');
    // Route::post('/mschool-record-results','ResultsController@index')->name('manager.school-record-results');
    Route::post('/teacher-save-student-results', 'ResultsController@teacherSaveStudentResults')->name('teacher.save-student-results');
    Route::get('/teacher-edit-results', 'ResultsController@teacherEditResults')->name('teacher.edit-results');
    Route::post('/teacher-edit-results', 'ResultsController@teacherEditStudentsResults')->name('teacher.update-results');

    Route::get('/teacher-class-member', 'ClassController@teacherClassMember')->name(' teacher.class-member');
    Route::post('/teacher-class-members', 'ClassController@teacherClassMembers')->name('teacher.class-members');

    Route::get('/teacher-rollcall', 'AttendenceController@teacherRollcall')->name('teacher.rollcall');
    Route::post('/teacher-rollcall-students', 'AttendenceController@teacherRollcallStudents')->name('teacher.rollcall-students');
    Route::post('/teacher-save-student-rollcall', 'AttendenceController@teacherSaveStudentRollcall')->name('teacher.save-student-rollcall');

    //Add Contributions
    Route::get('/teacher-add-contributions', 'ContributionsController@teacherAddContributions')->name('teacher.add-contributions');
    Route::post('/teacher-save-contribution', 'ContributionsController@teacherSaveContribution')->name('teacher.save-contribution');
    Route::post('/teacher-edit-contribution', 'ContributionsController@teacherEditContribution')->name('teacher.edit-contribution');
    Route::post('/teacher-delete-contribution', 'ContributionsController@teacherDeleteContribution')->name('teacher.delete-contribution');

    //teacher-collect-contributions
    Route::get('/teacher-collect-contributions', 'ContributionsController@teacherCollectContribution')->name('teacher.collect-contributions');
    Route::post('/teacher-save-contribution-payment', 'ContributionsController@teacherSaveContributionPayment')->name('teacher.save-contribution-payment');
    Route::post('/teacher-edit-contribution-payment', 'ContributionsController@teacherEditContributionPayment')->name('teacher.edit-contribution-payment');
    Route::get('/adminGetClasses-contribution', 'ContributionsController@adminGetClasses')->name('admin.getClasses-contribution');
    Route::post('/teacherGetClassContribution', 'ContributionsController@teacherGetClassContribution')->name('teacher.getClassContribution');
    Route::get('/teacher-view-contribution-payments', 'ContributionsController@teacherViewContributionPayments')->name('teacher.view-contribution-payments');

    //teacher-contribution-reports 
    Route::get('/teacher-contribution-reports', 'ContributionsController@teacherContributionReports')->name('teacher.contribution-reports');
    Route::get('/adminGetClassesReport-contribution', 'ContributionsController@adminGetClassesReportContribution')->name('admin.getClassesReportContribution');
    Route::post('/teacherGetClassContributionReport', 'ContributionsController@teacherGetClassContributionReport')->name('teacher.getClassContributionReport');
    Route::get('/adminGetStreamReport-contribution', 'ContributionsController@adminGetStreamReportContribution')->name('admin.getStreamReportContribution');
    //  Route::get('/adminGetStream','ContributionsController@adminGetStream')->name('admin.getStream');

    //Add Fees
    Route::get('/teacher-add-fees', 'FeesController@teacherAddFees')->name('teacher.add-fees');
    Route::post('/teacher-save-fee', 'FeesController@teacherSaveFee')->name('teacher.save-fee');
    Route::post('/teacher-edit-fee', 'FeesController@teacherEditFee')->name('teacher.edit-fee');
    Route::post('/teacher-delete-fee', 'FeesController@teacherDeleteFee')->name('teacher.delete-fee');

    //collect-fees
    Route::get('/teacher-collect-fees', 'FeesController@teacherCollectFees')->name('teacher.collect-fees');
    Route::post('/teacher-save-fee-payment', 'FeesController@teacherSaveFeePayment')->name('teacher.save-fee-payment');
    Route::post('/teacher-edit-fee-payment', 'FeesController@teacherEditFeePayment')->name('teacher.edit-fee-payment');
    Route::post('/teacherGetClassFee', 'FeesController@teacherGetClassFee')->name('teacher.getClassFee');
    Route::get('/teacher-view-fee-payments', 'FeesController@teacherViewFeePayments')->name('teacher.view-fee-payments');

    // teacher-send-receipt
    Route::post('/teacher-send-fee-receipt', 'FeesController@teacherSendFeeReceipt')->name('teacher.send-fee-receipt');

    //fee-reports
    Route::get('/teacher-fee-reports', 'FeesController@teacherFeeReports')->name('teacher.fee-reports');
    Route::get('/adminGetClassesReport', 'FeesController@adminGetClassesReport')->name('teacher.getClassesReport');
    Route::post('/teacherGetClassFeeReport', 'FeesController@teacherGetClassFeeReport')->name('teacher.getClassFeeReport');
    Route::get('/adminGetStreamReport', 'FeesController@adminGetStreamReport')->name('teacher.getStreamReport');
    Route::get('/adminGetStream', 'FeesController@adminGetStream')->name('teacher.getStream');

    //Students routine
    Route::get('/teacher-students-routine', 'StudentsRoutineController@teacherStudentsRoutine')->name('teacher.students-routine');

    //teacher-books
    Route::get('/teacher-books', 'LibraryController@teacherBooks')->name('teacher.books');
    Route::post('/teacher-save-book', 'LibraryController@teacherSaveBook')->name('teacher.save-book');
    Route::post('/teacher-edit-book', 'LibraryController@teacherEditBook')->name('teacher.edit-book');

    //teacher-library-users
    Route::get('/teacher-library-users', 'LibraryController@teacherLibraryUsers')->name('teacher.library-users');
    Route::POST('/teacher-save-library-user', 'LibraryController@teacherSaveLibraryUser')->name('teacher.save-library-user');
    Route::post('/teacher-edit-library-user', 'LibraryController@teacherEditLibraryUser')->name('teacher.edit-library-user');
    Route::post('/teacher-delete-library-user', 'LibraryController@teacherDeleteLibraryUser')->name('teacher.delete-library-user');

    // teacher-borrowers
    Route::get('/teacher-borrowers', 'LibraryController@teacherBorrowers')->name('teacher.borrowers');
    Route::POST('/teacher-save-borrowers', 'LibraryController@teacherSaveBorrowers')->name('teacher.save-borrowers');
    Route::post('/teacher-edit-borrowers', 'LibraryController@teacherEditBorrowers')->name('teacher.edit-borrowers');
    Route::post('/teacher-delete-borrowers', 'LibraryController@teacherDeleteBorrowers')->name('teacher.delete-borrowers');

    //borrower-form
    Route::get('/teacher-borrower-form', 'LibraryController@teacherBorrowerForm')->name('teacher.borrower-form');
    Route::POST('/teacher-save-borrower-form', 'LibraryController@teacherSaveBorrowerForm')->name('teacher.save-borrower-form');
    Route::post('/teachere-filter-borrowers', 'LibraryController@teachereFilterBorrowers')->name('teachere.filter-borrowers');

    // teacher-vehicles
    Route::get('/teacher-vehicles', 'TransportController@teacherVehicles')->name('teacher.vehicles');
    Route::POST('/teacher-save-vehicles', 'TransportController@teacherSaveVehicles')->name('teacher.save-vehicles');
    Route::post('/teacher-edit-vehicles', 'TransportController@teacherEditVehicles')->name('teacher.edit-vehicles');
    Route::post('/teacher-delete-vehicles', 'TransportController@teacherDeleteVehicles')->name('teacher.delete-vehicles');

    // teacher-routes
    Route::get('/teacher-routes', 'TransportController@teacherRoutes')->name('teacher.routes');
    Route::POST('/teacher-save-routes', 'TransportController@teacherSaveRoutes')->name('teacher.save-routes');
    Route::post('/teacher-edit-routes', 'TransportController@teacherEditRoutes')->name('teacher.edit-routes');
    Route::post('/teacher-delete-routes', 'TransportController@teacherDeleteRoutes')->name('teacher.delete-routes');

    // teacher-Station
    Route::get('/teacher-stations', 'TransportController@teacherStations')->name('teacher.stations');
    Route::POST('/teacher-save-stations', 'TransportController@teacherSaveStations')->name('teacher.save-stations');
    Route::post('/teacher-edit-stations', 'TransportController@teacherEditStations')->name('teacher.edit-stations');
    Route::post('/teacher-delete-stations', 'TransportController@teacherDeleteStations')->name('teacher.delete-stations');
  });
});

Route::get('/teacher-download-pdf', 'PdfController@teacherDownloadPdf')->name('teacher.download-pdf');






//manager Routes

Route::group(['middleware' => 'auth'], function () {

  Route::get('/manager', 'RedirectController@manager')->name('manager.redirect');
  Route::post('/save-school', 'SchoolController@saveSchool')->name('manager.save-school');
  Route::get('/school', 'SchoolController@index')->name('manager.school-index');
  Route::get('/mteachers', 'TeachersController@mteachers')->name('manager.teachers');
  Route::get('/home-dashboard', 'SchoolController@homeDashboard')->name('manager.home-dashboard');
  Route::post('/msaveTeacher', 'TeachersController@msaveTeacher')->name('manager.saveTeacher');
  Route::post('/meditTeacher', 'TeachersController@meditTeacher')->name('manager.editTeacher');
  Route::post('/mdelete-teacher', 'TeachersController@mdeleteTeacher')->name('manager.delete-teacher');
  Route::get('/mnon-teachers', 'NonTeachersController@mNonTeachers')->name('manager.non-teachers');
  Route::post('/msaveNonTeacher', 'NonTeachersController@msaveNonTeacher')->name('manager.msaveNonTeacher');
  Route::post('/medit-non-teacher', 'NonTeachersController@meditNonTeacher')->name('manager.edit-non-teacher');
  Route::post('/mdelete-non-teacher', 'NonTeachersController@mdeleteNonTeacher')->name('manager.delete-non-teacher');

  //parents
  Route::get('/mparents', 'ParentsController@mparents')->name('manager.parents');
  Route::post('/msaveParent', 'ParentsController@msaveParent')->name('manager.saveParent');
  Route::post('/medit-parent', 'ParentsController@meditParent')->name('manager.edit-parent');
  Route::post('/mdelete-parent', 'ParentsController@mdeleteParent')->name('manager.delete-parent');

  //Students 
  Route::get('/mstudents', 'StudentsController@mstudents')->name('manager.students');
  Route::post('/msaveStudent', 'StudentsController@msaveStudent')->name('manager.saveStudent');
  Route::post('/medit-student', 'StudentsController@meditStudent')->name('manager.edit-student');
  Route::post('/mdelete-student', 'StudentsController@mdeleteStudent')->name('manager.delete-student');


  //Librarian 
  Route::get('/mLibrarians', 'LibraryController@mLibrarian')->name('manager.librarian');
  Route::post('/msaveLibrarian', 'LibraryController@msaveLibrarian')->name('manager.saveLibrarian');
  Route::post('/meditLibrarian', 'LibraryController@meditLibrarian')->name('manager.edit-librarian');
  Route::post('/mDeleteLibrarian', 'LibraryController@mdeleteLibrarian')->name('manager.delete-librarian');

  //Classes 
  Route::get('/mClasses', 'ClassController@mClasses')->name('manager.classes');
  Route::post('/msaveClass', 'ClassController@msaveClass')->name('manager.saveClass');
  Route::post('/meditClass', 'ClassController@meditClass')->name('manager.edit-Class');
  Route::post('/mDeleteClass', 'ClassController@mdeleteClass')->name('manager.delete-Class');

  //Subjects
  Route::get('/mSubjects', 'SubjectsController@mSubjects')->name('manager.subjects');
  Route::post('/msaveSubject', 'SubjectsController@msaveSubject')->name('manager.saveSubject');
  Route::post('/meditSubject', 'SubjectsController@meditSubject')->name('manager.editSubject');
  Route::post('/mDeleteSubject', 'SubjectsController@mDeleteSubject')->name('manager.deleteSubject');

  // Expenses
  Route::get('/mExpenses', 'ExpensesController@mexpenses')->name('manager.expenses');
  Route::post('/msaveExpenses', 'ExpensesController@msaveExpenses')->name('manager.saveExpenses');
  Route::post('/meditExpenses', 'ExpensesController@meditExpenses')->name('manager.edit-expenses');
  Route::post('/mdeleteExpenses', 'ExpensesController@mdeleteExpenses')->name('manager.delete-expenses');

  // setting-student-class
  Route::get('/msetting-student-class', 'StudentsController@msettingStudentClass')->name('manager.setting-student-class');
  Route::post('/msaveSettingStudentClass', 'StudentsController@msaveSettingStudentClass')->name('manager.savesettingStudentClass');
  Route::post('/meditSettingStudentClass', 'StudentsController@meditSettingStudentClass')->name('manager.editsettingStudentClass');
  Route::post('/mdeleteSettingStudentClass', 'StudentsController@mdeleteSettingStudentClass')->name('manager.deletesettingStudentClass');
  Route::post('/mupgradeSettingStudentClass', 'StudentsController@mupgradeSettingStudentClass')->name('manager.upgradeSettingStudentClass');

  // setting-teacher-class
  Route::get('/msetting-teacher-class', 'TeachersController@msettingTeacherClass')->name('manager.setting-teacher-class');
  Route::post('/msaveSetting-teacher-class', 'TeachersController@msaveSettingTeacherClass')->name('manager.saveSetting-teacher-class');
  Route::post('/meditSetting-teacher-class', 'TeachersController@meditSettingTeacherClass')->name('manager.editSetting-teacher-class');
  Route::post('/mdeleteSetting-teacher-class', 'TeachersController@mdeleteSettingTeacherClass')->name('manager.deleteSetting-teacher-class');
  Route::get('/mfilter-subjects', 'TeachersController@mfilterSubjects')->name('manager.filter-subjects');


  //setting-class-subjects
  Route::get('/msetting-subjects-class', 'SubjectsController@msettingSubjectsClass')->name('manager.setting-subjects-class');
  Route::post('/msave-setting-subjects-class', 'SubjectsController@msaveSettingSubjectsClass')->name('manager.save-setting-subjects-class');
  Route::post('/medit-setting-subjects-class', 'SubjectsController@meditSettingSubjectsClass')->name('manager.edit-setting-subjects-class');
  Route::post('/mdelete-setting-subjects-class', 'SubjectsController@mDeleteSettingSubjectsClass')->name('manager.delete-setting-subjects-class');

  //setting-contributions
  Route::get('/msetting-contributions', 'ContributionsController@msettingContributions')->name('manager.setting-contributions');
  Route::post('/msave-setting-contributions', 'ContributionsController@msaveSettingContributions')->name('manager.save-setting-contributions');
  Route::post('/medit-setting-contributions', 'ContributionsController@meditSettingContributions')->name('manager.edit-setting-contributions');
  Route::post('/mdelete-setting-contributions', 'ContributionsController@mDeleteSettingContributions')->name('manager.delete-setting-contributions');
  Route::get('/mfilter-students', 'ContributionsController@mfilterStudents')->name('manager.filter-students');

  //setting-fees
  Route::get('/msetting-fees', 'FeesController@msettingFees')->name('manager.setting-fees');
  Route::post('/msave-setting-fees', 'FeesController@msaveSettingFees')->name('manager.save-setting-fees');
  Route::post('/medit-setting-fees', 'FeesController@meditSettingFees')->name('manager.edit-setting-fees');
  Route::post('/mdelete-setting-fees', 'FeesController@mDeleteSettingFees')->name('manager.delete-setting-fees');
  Route::get('/mfilter-fee-students', 'FeesController@mfilterStudents')->name('manager.filter-fee-students');

  //School Fees
  Route::get('/mschool-record-fees', 'FeesController@index')->name('manager.school-fees');
  Route::post('/msave-school-fees', 'FeesController@msaveSchoolFees')->name('manager.save-school-fees');
  Route::post('/medit-school-fees', 'FeesController@meditSchoolFees')->name('manager.edit-school-fees');
  Route::post('/mdelete-school-fees', 'FeesController@mDeleteSchoolFees')->name('manager.delete-school-fees');

  //School Contributions
  Route::get('/mschool-record-contributions', 'ContributionsController@index')->name('manager.school-contributions');
  Route::post('/msave-school-contributions', 'ContributionsController@msaveSchoolContributions')->name('manager.save-school-contributions');
  Route::post('/medit-school-contributions', 'ContributionsController@meditSchoolContributions')->name('manager.edit-school-contributions');
  Route::post('/mdelete-school-contributions', 'ContributionsController@mDeleteSchoolContributions')->name('manager.delete-school-contributions');

  // Fees
  Route::get('/mfees', 'FeesController@mfees')->name('manager.fees');
  Route::post('/msave-fees', 'FeesController@msaveFees')->name('manager.save-fees');
  Route::post('/medit-fees', 'FeesController@meditFees')->name('manager.edit-fees');
  Route::post('/mdelete-fees', 'FeesController@mDeleteFees')->name('manager.delete-fees');

  // contributions
  Route::get('/mcontributions', 'ContributionsController@mcontributions')->name('manager.contributions');
  Route::post('/msave-contributions', 'ContributionsController@msaveContributions')->name('manager.save-contributions');
  Route::post('/medit-contributions', 'ContributionsController@meditContributions')->name('manager.edit-contributions');
  Route::post('/mdelete-contributions', 'ContributionsController@mDeleteContributions')->name('manager.delete-contributions');
  // results
  Route::get('/mget-class-subjects', 'ResultsController@mgetClassSubjects')->name('manager.get-class-subjects');
  Route::get('/mget-list', 'ResultsController@mResultsList')->name('manager.get-list');
  Route::post('/mschool-record-results', 'ResultsController@index')->name('manager.school-record-results');
  Route::post('/msave-student-results', 'ResultsController@msaveStudentResults')->name('manager.save-student-results');
  Route::get('/medit-results', 'ResultsController@meditResults')->name('manager.edit-result');
  Route::post('/medit-student-results', 'ResultsController@meditStudentResults')->name('manager.edit-student-results');
  // Route::post('/mdelete-contributions','ResultsController@mDeleteContributions')->name('manager.delete-contributions');

  Route::get('/madmin', 'HomeController@schoolAdmin')->name('manager.admin');
  Route::post('/madmin-save', 'HomeController@schoolAdminSave')->name('manager.admin-save');
});








Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/{lang}', function ($lang) {
  App::setLocale($lang);
  Session::put('locale', $lang);
  return back();
})->name('app.lang');

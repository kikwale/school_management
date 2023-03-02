@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
    
    <div class="page-header">
    <div class="row align-items-center">
    <div class="col">
    <h3 class="page-title"> Results </h3>
    <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="home-dashboard">Dashboard</a></li>
    <li class="breadcrumb-item "><a href="mget-list">Results</a></li>
    <li class="breadcrumb-item active">Edit</li>
    </ul>
    </div>
    </div>
    </div>
    
  
    <div class="card invoices-tabs-card">
    <div class="card-body card-body pt-0 pb-0">
    <div class="invoices-main-tabs border-0 pb-0">
    <div class="row align-items-center">
    <div class="col-lg-12 col-md-12">
    <div class="invoices-settings-btn invoices-settings-btn-one">
    {{-- <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#add_items">
    <i data-feather="plus-circle"></i> Add New Expenses
    </a> --}}
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-md-2"></div>
        <div class="col-sm-12 col-md-8">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Good! </strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>ERROR &nbsp;</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
            @endif
        </div>
        <div class="col-sm-2 col-md-2"></div>
       
    
    </div>
    <div class="row">
    <div class="col-sm-12">
    <div class="card card-table">
    <div class="card-body">
    <div class="table-responsive">
    <form action="medit-student-results" method="post">
        @csrf
    <table id="" class="table table-hover">
    <thead class="thead-light">
    <tr>
    <th>S/N</th>
    <th>Student Name</th>
    @foreach ($subjects as $subject)
    <th>{{$subject->subject_name}}</th>
    <input type="number" hidden name="subjects_id" value="{{ $subject->id }}"  step="any" class="form-control">
    @endforeach
   
  
  
    </tr>
    </thead>
    <tbody>
       <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8"><br>
          <h3>Form for filling subject marks for results</h3>
        </div>
        <div class="col-md-2"></div>
       </div>
 
      <input type="number" hidden name="darasas_id" value="{{ $darasas_id }}"  step="any" class="form-control">

      @foreach ($studentsResultSubmissions as $studentsResultSubmission)
      <tr>
        <td>{{ $index++ }}</td>
        <td>{{ $studentsResultSubmission->fname }} &nbsp; {{ $studentsResultSubmission->lname }}</td>
        <input type="number" hidden name="students_id[]" value="{{ $studentsResultSubmission->students_id }}"  step="any" class="form-control">
       
         <td>

          <input type="number" name="marks{{ $studentsResultSubmission->students_id }}" value="{{ $studentsResultSubmission->mark }}"  step="any" class="form-control">
        </td>
        
     

      </tr>
      @endforeach
      

     
     
    </tbody>
    </table><br>
    <div class="row">
      <div class="col-md-9"></div>
      <div class="col-md-2">
        <button style="float: right;" type="submit" class="btn btn-primary">Save</button>
      </div>
      <div class="col-md-1"></div>
    </div><br>
   
  </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

<div class="modal custom-modal fade bank-details" id="add_items" role="dialog">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">
<div class="modal-header">
<div class="form-header text-start mb-0">
<h4 class="mb-0">Add New Expenses</h4>
</div>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <form action="msaveExpenses" method="post">
    @csrf

        <div class="bank-inner-details">
        <div class="row">
      
          <div class="col-lg-6 col-sm-12 col-md-6">
            <div class="form-group">
            <label>Date</label>
            <input  type="date" class="form-control" name="date" id="date">
            </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-6">
            <div class="form-group">
            <label>Amount</label>
            <input  type="number" step="any" class="form-control"  name="amount" id="amount">
            </div>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-6">
            <div class="form-group">
            <label>Description</label>
            <textarea rows="4"  type="text" class="form-control" name="description" id="description">Description Here (Option)</textarea>
            </div>
            </div>
       
        </div>
        </div>
 
</div>
<div class="modal-footer">
<div class="bank-details-btn">
<a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
<button type="submit" class="btn bank-save-btn">Save</button>
</div>
</div>
 </form>
</div>
</div>
</div>
  
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script>
  function deleteTeacher(teacher_id){

    $.ajax({
            type:'get',
            url:'/mdelete-teacher',
            data:{user_id:teacher_id},
            success:function(){
              
            Swal.fire({ 
            position: "top-end", 
            type: "success", 
            title: "Your work has been saved", 
            showConfirmButton: !1, 
            timer: 1500,
            confirmButtonClass: "btn btn-primary",
            buttonsStyling: !1 });
          
            // $('#delete_paid'+teacher_id).modal("hide");
            
            }
          
        });
        }

    
   
</script>
@endsection

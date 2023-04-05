@extends('layouts.app')

@section('content')
  <!--PAGE CONTENT -->
  <div id="content">

    <div class="inner">
        <div class="row">
     
            <div class="col-lg-12">


                <h2>School Admin </h2>



            </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb bg-white">
              <li><a href="home">Dashboard</a></li>
              <li><a href="teacher-rollcall">Rollcall</a></li>
              <li>Record Rollcall</li>
            </ul>
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
    <form action="teacher-save-student-rollcall" method="post">
        @csrf

    <table id="dataTables-exampl" class="table table-hover">
    <thead class="thead-light">
    <tr>
    <th>S/N</th>
    <th>Student Name</th>
    <th>Status</th>
    
    </tr>
    </thead>
    <tbody>    
       <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-8"><br>
          <h3>Form for filling Students Rollcall </h3>
        </div>
        <div class="col-md-1"></div>
       </div><hr>
       <br>
 
       <div class="row">
        <div class="col-md-4">
          <label for="title">Date</label>
          <input type="date" name="date" id="date" required placeholder="Date" class="form-control">
        </div>
       </div><br><br>

      @foreach ($students as $student)
      <tr>
        <input type="hidden" name="darasas_id" value="{{ $teacher_class_id }}"  step="any" class="form-control">
        <input type="hidden" name="stream_or_combs_id" value="{{ $teacher_stream_id }}"  step="any" class="form-control">
        <input type="hidden" name="subjects_id" value="{{ $subject->id }}"  step="any" class="form-control">
  
        <td>{{ $index++ }}</td>
        <td>{{ $student->fname }} &nbsp; {{ $student->lname }}</td>
        <input type="hidden"   name="academic_years_id" value="{{ $academic_year_id }}"  step="any" class="form-control">
        <input type="hidden"  name="students_id[]" value="{{ $student->students_id }}"  step="any" class="form-control">
       
         <td>
          
          <input required type="radio" name="status{{ $student->students_id }}"  step="any" value="Present" class="form-contr"><label for="status">&nbsp; Present</label>
          <input required type="radio" name="status{{ $student->students_id }}"  step="any" value="Abscent" class="form-contr"><label for="status">&nbsp; Abscent</label>
        </td>
         
     

      </tr>
      @endforeach
      

     
     
    </tbody>
    </table><br>
    
    <div class="row">
      <div class="col-md-9"></div>
      <div class="col-md-2">
        <button style="float: right;" type="submit" class="btn btn-primary">submit</button>
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

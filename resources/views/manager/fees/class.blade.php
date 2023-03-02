@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
    
    <div class="page-header">
    <div class="row align-items-center">
    <div class="col">
    <h3 class="page-title">Setting Students Fees </h3>
    <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="home-dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active"> Students Fees  </li>
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
  
    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#add_items">
    <i data-feather="plus-circle"></i> New Students Fee
    </a>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="row" style="display: none;" id="setting_form">

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
    <table id="example" class="table table-stripped table-hover">
    <thead class="thead-light">
    <tr>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>Class Name</th>
    <th>Level</th>
    <th>Descriptions</th>
    <th>Year</th>
    <th>Balance</th>
    <th class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
         
    @foreach ($data as $student_fee)
    <tr>
    <td>
         <input type="checkbox">
        <a href="#" class="items-links">{{ $student_fee->fname }}</a>
        </td>
        <td class="text-primary">{{ $student_fee->mname }}</td>
        <td>{{ $student_fee->lname }}</td>
        <td class="items-text">{{ $student_fee->class_name }}</td>
        <td>{{ $student_fee->level }}</td>
        <td>{{ $student_fee->description }}</td>
        <td>{{ $student_fee->year }}</td>
        <td>{{ $student_fee->fee_amount }}</td>
        <td class="text-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#edit_teacher{{ $student_fee->id }}" class="btn btn-sm btn-white text-success me-2"><i class="far fa-edit me-1"></i> Edit</a>
        <a class="btn btn-sm btn-white text-danger" href="#" data-bs-toggle="modal" data-bs-target="#delete_paid{{ $student_fee->id }}"><i class="far fa-trash-alt me-1"></i>Delete</a>
        </td>

        {{-- Modal for editing --}}
        <div class="modal custom-modal fade bank-details" id="edit_teacher{{ $student_fee->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <div class="form-header text-start mb-0">
            <h4 class="mb-0">Edit </h4>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <form action="medit-setting-fees" method="post">
                @csrf
            
                    <input  type="text" class="form-control" hidden value="{{ $student_fee->id }}" name="id" id="id">
                    <div class="bank-inner-details">
                    <div class="row">
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Classes</label>
                        <select name="darasas_id" id="darasas_id"  class="form-select form-control">
                          <option value="{{ $student_fee->darasas_id }}">{{ $student_fee->class_name }} - {{ $student_fee->level }}</option>
                        @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->class_name }} - {{ $class->level }}</option>
                        @endforeach
                    
                        </select>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Students</label>

                        <select  name="students_id" id="students_id"  class="tagging form-select form-control" >
                        <option value="{{ $student_fee->students_id }}">{{ $student_fee->fname }} &nbsp; {{ $student_fee->lname }}</option>
                        @foreach ($students as $student1)
                        <option value="{{ $student1->id }}">{{ $student1->fname }} &nbsp; {{ $student1->lname }}</option>
                        @endforeach
                    
                        </select>
                        </div>
                      </div>
                      
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Fee Amount</label>
                        <input name="fee_amount" id="fee_amount" value="{{ $student_fee->fee_amount  }}" type="number" step="any" class="form-control" required>
                        </div>
                        </div>
                
                        <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" name="description" id="description" type="text" class="form-control" >{{ $student_fee->description  }}</textarea>
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

        {{-- Modal for deleting --}}
        <div class="modal custom-modal fade" id="delete_paid{{ $student_fee->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-body">
            <div class="form-header">
            <h3>Delete</h3>
             <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-btn delete-action">
            <div class="row">
            <div class="col-6">
                <form  method="POST" action="mdelete-setting-fees">
                  @csrf
                   <input type="number" hidden value="{{ $student_fee->id }}" name="id" id="id">
                    <button type="submit" class="btn btn-primary paid-continue-btn">Delete</button>
                </form>
           </div>
            <div class="col-6">
            <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
    </tr>
    @endforeach
 
    </tbody>
    </table>
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
<h4 class="mb-0">Add New Students Fee</h4>
</div>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <form action="msave-setting-fees" method="post">
    @csrf

        <div class="bank-inner-details">
        <div class="row">
      
        <div class="col-lg-6 col-md-6">
          <div class="form-group">
          <label>Classes</label>
          <select required name="darasas_id" id="darasas_id" onchange="filterStudents(this.value)" class="form-select form-control">
          <option></option>
          @foreach ($classes as $class)
          <option value="{{ $class->id }}">{{ $class->class_name }} - {{ $class->level }}</option>
          @endforeach
      
          </select>
          </div>
        </div>
        
        <div class="col-lg-6 col-md-6" id="subject">
          
        </div>
{{--       
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Fee Amount</label>
        <input name="fee_amount" id="fee_amount" type="number" step="any" class="form-control" required>
        </div>
        </div> --}}
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Finencial Year</label>
        <input name="year" id="year" type="number" step="any" class="form-control" required>
        </div>
        </div>

        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Description</label>
        <textarea rows="4" name="description" id="description" type="text" class="form-control"></textarea>
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

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/select2/js/custom-select.js"></script>
<script>


  function filterStudents(darasas_id){
    $.ajax({
            type:'get',
            url:'/mfilter-fee-students',
            data:{darasas_id:darasas_id},
            success:function(data){
           
             
           $('#subject').html(data);
            
            }
          
        });
  }

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

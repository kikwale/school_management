@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
    
    <div class="page-header">
    <div class="row align-items-center">
    <div class="col">
    <h3 class="page-title"> Students </h3>
    <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="home-dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Students</li>
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
    <i data-feather="plus-circle"></i> Add New Student
    </a>
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
    <table id="example" class="table table-stripped table-hover ">
    <thead class="thead-light">
    <tr>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>Gender</th>
    <th>Email</th>
    <th>Parent Phone</th>
    <th>Parent Address</th>
    <th>Parent Occupation</th>
    <th class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
         
    @foreach ($data as $student)
    <tr>
    <td>
        <a href="#" class="items-links">{{ $student->fname }}</a>
        </td>
        <td class="text-primary">{{ $student->mname }}</td>
        <td>{{ $student->lname }}</td>
        <td class="items-text">{{ $student->gender }}</td>
        <td>{{ $student->email }}</td>
        <td>{{ $student->phone }}</td>
        <td>{{ $student->address }}</td>
        <td>{{ $student->work }}</td>
        <td class="text-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#edit_teacher{{ $student->id }}" class="btn btn-sm btn-white text-success me-2"><i class="far fa-edit me-1"></i> Edit</a>
        <a class="btn btn-sm btn-white text-danger" href="#" data-bs-toggle="modal" data-bs-target="#delete_paid{{ $student->id }}"><i class="far fa-trash-alt me-1"></i>Delete</a>
        </td>

        {{-- Modal for editing --}}
        <div class="modal custom-modal fade bank-details" id="edit_teacher{{ $student->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <div class="form-header text-start mb-0">
            <h4 class="mb-0">Edit Student &nbsp; {{ $student->lname }}</h4>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <form action="medit-student" method="post">
                @csrf
            
                    <input  type="text" class="form-control" hidden value="{{ $student->id }}" name="user_id" id="user_id">
                    <div class="bank-inner-details">
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="form-group">
                    <label>First Name</label>
                    <input  type="text" class="form-control" value="{{ $student->fname }}" name="fname" id="fname">
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" name="mname" id="mname" value="{{ $student->mname }}">
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="form-group">
                    <label>Last Name</label>
                    <input value="{{ $student->lname }}" type="text" class="form-control" name="lname" id="lname">
                    </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                    <label>Gender</label>
                    <select  name="gender" id="gender" class="form-select form-control">
                    <option value="{{ $student->gender }}">{{ $student->gender }}</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    </select>
                    </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                      <label>Parent/Gurdian</label>
                      <select required name="parents_id" id="parents_id" class="form-select form-control">
                        <?php $user = App\Models\User::where('id',$student->users_id )->first(); ?>
                      <option value="{{ $student->parents_id }}">{{ $user->fname }} &nbsp; {{ $user->lname }}</option>
                      @foreach ($parents as $parent)
                      <option value="{{ $parent->id }}">{{ $parent->fname }} &nbsp; {{ $parent->lname }}</option>
                      @endforeach
                  
                      </select>
                      </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                    <label>Email</label>
                    <input value="{{ $student->email }}" name="email" id="email" type="email" class="form-control" >
                    </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                      <label>Registration Number</label>
                      <input name="RegNo" id="RegNo" type="text" value="{{ $student->RegNo }}"  step="any" class="form-control" >
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
        <div class="modal custom-modal fade" id="delete_paid{{ $student->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-body">
            <div class="form-header">
            <h3>Delete this Student</h3>
             <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-btn delete-action">
            <div class="row">
            <div class="col-6">
                <form  method="POST" action="mdelete-student">
                  @csrf
                   <input type="number" hidden value="{{ $student->id }}" name="users_id" id="users_id">
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
<h4 class="mb-0">Add New student</h4>
</div>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <form action="msaveStudent" method="post">
    @csrf

        <div class="bank-inner-details">
        <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group">
        <label>First Name</label>
        <input required type="text" class="form-control" name="fname" id="fname">
        </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group">
        <label>Middle Name</label>
        <input type="text" class="form-control" name="mname" id="mname">
        </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-md-6">
        <div class="form-group">
        <label>Last Name</label>
        <input required type="text" class="form-control" name="lname" id="lname">
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Gender</label>
        <select required name="gender" id="gender" class="form-select form-control">
        <option></option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        </select>
        </div>
        </div>
        
        <div class="col-lg-6 col-md-6">
          <div class="form-group">
          <label>Parent/Gurdian</label>
          <select required name="parents_id" id="parents_id" class="form-select form-control">
          <option></option>
          @foreach ($parents as $parent)
          <option value="{{ $parent->id }}">{{ $parent->fname }} &nbsp; {{ $parent->lname }}</option>
          @endforeach
      
          </select>
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label> Email</label>
        <input name="email" id="email" type="email" step="any" class="form-control" >
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Registration Number</label>
        <input name="RegNo" id="RegNo" type="text" step="any" class="form-control" >
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

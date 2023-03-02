@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
    
    <div class="page-header">
    <div class="row align-items-center">
    <div class="col">
    <h3 class="page-title"> Parents </h3>
    <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="home-dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active">Parents</li>
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
    <i data-feather="plus-circle"></i> Add New Parent
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
    <th>Phone</th>
    <th>Address/Location</th>
    <th>Occupation</th>
    <th class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
         
    @foreach ($data as $parent)
    <tr>
    <td>
        <a href="#" class="items-links">{{ $parent->fname }}</a>
        </td>
        <td class="text-primary">{{ $parent->mname }}</td>
        <td>{{ $parent->lname }}</td>
        <td class="items-text">{{ $parent->gender }}</td>
        <td>{{ $parent->email }}</td>
        <td>{{ $parent->phone }}</td>
        <td>{{ $parent->address }}</td>
        <td>{{ $parent->work }}</td>
        <td class="text-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#edit_teacher{{ $parent->id }}" class="btn btn-sm btn-white text-success me-2"><i class="far fa-edit me-1"></i> Edit</a>
        <a class="btn btn-sm btn-white text-danger" href="#" data-bs-toggle="modal" data-bs-target="#delete_paid{{ $parent->id }}"><i class="far fa-trash-alt me-1"></i>Delete</a>
        </td>

        {{-- Modal for editing --}}
        <div class="modal custom-modal fade bank-details" id="edit_teacher{{ $parent->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <div class="form-header text-start mb-0">
            <h4 class="mb-0">Edit Parent &nbsp; {{ $parent->lname }}</h4>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <form action="medit-parent" method="post">
                @csrf
            
                    <input  type="text" class="form-control" hidden value="{{ $parent->id }}" name="user_id" id="user_id">
                    <div class="bank-inner-details">
                    <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="form-group">
                    <label>First Name</label>
                    <input  type="text" class="form-control" value="{{ $parent->fname }}" name="fname" id="fname">
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="form-group">
                    <label>Middle Name</label>
                    <input type="text" class="form-control" name="mname" id="mname" value="{{ $parent->mname }}">
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                    <div class="form-group">
                    <label>Last Name</label>
                    <input value="{{ $parent->lname }}" type="text" class="form-control" name="lname" id="lname">
                    </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                    <label>Gender</label>
                    <select  name="gender" id="gender" class="form-select form-control">
                    <option value="{{ $parent->gender }}">{{ $parent->gender }}</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    </select>
                    </div>
                    </div>
                    
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                      <label>Address/Location</label>
                      <input value="{{ $parent->address }}" name="address" id="address" type="text" class="form-control" >
                      </div>
                      </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                      <label>Occupation</label>
                      <input value="{{ $parent->work }}" name="work" id="work" type="text" class="form-control" >
                      </div>
                      </div>
                    <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                    <label>Phone</label>
                    <input value="{{ $parent->phone }}" name="phone" id="phone" type="number" class="form-control" >
                    </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                    <label>Email</label>
                    <input value="{{ $parent->email }}" name="email" id="email" type="email" class="form-control" >
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
        <div class="modal custom-modal fade" id="delete_paid{{ $parent->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-body">
            <div class="form-header">
            <h3>Delete this Parent</h3>
             <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-btn delete-action">
            <div class="row">
            <div class="col-6">
                <form  method="POST" action="mdelete-parent">
                  @csrf
                   <input type="number" hidden value="{{ $parent->id }}" name="parent_id" id="teacher_id">
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
<h4 class="mb-0">Add New Parent</h4>
</div>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
  <form action="msaveParent" method="post">
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
        <label>Address/Location</label>
        <input required name="address" id="address" type="text" step="any" class="form-control" >
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Occupation/Parent Work</label>
        <input name="work" id="work" type="text" step="any" class="form-control" >
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Phone</label>
        <input required name="phone" id="phone" type="number" class="form-control" >
        </div>
        </div>
        <div class="col-lg-6 col-md-6">
        <div class="form-group">
        <label>Email</label>
        <input required name="email" id="email" type="email" class="form-control" >
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

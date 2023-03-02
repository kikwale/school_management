@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
    
    <div class="page-header">
    <div class="row align-items-center">
    <div class="col">
    <h3 class="page-title">Record Students Fees </h3>
    <ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="home-dashboard">Dashboard</a></li>
    <li class="breadcrumb-item active"> Record Fees  </li>
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
{{--   
    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#add_items">
    <i data-feather="plus-circle"></i> New Students Fee
    </a> --}}
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
    <table id="example" class="table table-stripped table-hover ">
    <thead class="thead-light">
    <tr>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>Class Name</th>
    <th>year</th>
    <th>Balance</th>
    <th class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
         
    @foreach ($data as $student_fee)
    <tr>
    <td>
        <a href="#" class="items-links">{{ $student_fee->fname }}</a>
        </td>
        <td class="text-primary">{{ $student_fee->mname }}</td>
        <td>{{ $student_fee->lname }}</td>
        <td class="items-text">{{ $student_fee->class_name }}</td>
        <td>{{ $student_fee->year }}</td>
        <td>{{ $student_fee->fee_amount }}</td>
        <td class="text-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#edit_teacher{{ $student_fee->id }}" class="btn btn-sm btn-white text-success me-2"><i class="fas fa-pen me-1"></i> Record Payments</a>
        &nbsp;&nbsp;<a href="#" class="btn btn-sm btn-white text-info me-2"><i class="fas fa-eye me-1"></i> </a>
        </td>

        {{-- Modal for editing --}}
        <div class="modal custom-modal fade bank-details" id="edit_teacher{{ $student_fee->id }}" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
            <div class="modal-header">
            <div class="form-header text-start mb-0">
            <h4 class="mb-0">Record Contribution Payments </h4>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
              <form action="msave-school-fees" method="post">
                @csrf
            
                    <input  type="text" class="form-control" hidden value="{{ $student_fee->id }}" name="student_fees_id" id="student_fees_id">
                    <div class="bank-inner-details">
                    <div class="row">

                      <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Payment Date</label>
                        <input name="date" id="date" type="date"  class="form-control" required>
                        </div>
                        </div>
                      <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Amount Paid</label>
                        <input name="amount" id="amount" type="number" step="any"  class="form-control" required>
                        </div>
                        </div>

                      <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                        <label>Payment Method</label>
                        <select required  name="methode" id="{{ $student_fee->id }}" onchange="checkMethod(this.id)" class="form-select form-control">
                         <option value=""></option>
                          <option value="Cash">Cash</option>
                         <option value="Cheque">Cheque</option>
                         <option value="Bank">Bank</option>
                         <option value="Phone">Phone</option>
                    
                        </select>
                        </div>
                      </div>

                 
                      <div class="col-lg-6 col-md-6" id="Phone{{ $student_fee->id }}" style="display: none;" >
                        <div class="form-group">
                        <label>Service Provider</label>
                        <select name="methode_name" id="method_name{{ $student_fee->id }}"  class="form-select form-control">
                     
                    
                        </select>
                        </div>
                      </div>

                      <div class="col-lg-6 col-md-6" id="No{{$student_fee->id  }}"  style="display: none;">
                        <div class="form-group">
                        <label>Number</label>
                        <input  name="number" id="number"   type="number" step="any"  class="form-control" >
                        </div>
                        </div>
                    
                      <div class="col-lg-6 col-md-6">
                      <div class="form-group">
                      <label>Description</label>
                      <textarea rows="4" name="description" id="description" type="text" class="form-control" >{{ $student_fee->description  }}</textarea>
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
                <form  method="POST" action="mdelete-school-fees">
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


<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/select2/js/custom-select.js"></script>
<script>


  function checkMethod(id){
    
    var valu  = document.getElementById(id).value;
  if(valu == "Cheque"){
    $('#No'+id+'').css('display','block');
    $('#Phone'+id+'').css('display', 'none');
    $('#No'+id+'').css('display','none');
  }
  else if(valu == "Phone"){
    $('#Phone'+id+'').css('display', 'block');
    $('#No'+id+'').css('display','block');
    $('#method_name'+id+'').append(''+
                +'<option id="emty" value=""></option>'
                  +'<option id="tigo'+id+'" value="TIGO PESA">TIGO PESA</option>'
                    +'<option id="voda'+id+'" value="M-PESA">M-PESA</option>'
                    +'<option id="tpesa'+id+'" value="T-PESA">T-PESA</option>'
                    +'<option id="airtel'+id+'" value="AIRTEL MONEY">ZBC</option>'
                    +'<option id="ezy'+id+'" value="EZY PESA">EZY PESA</option>'
                    + '<option id="selcome'+id+'" value="Selcom">Selcom</option>'
            );
            
            $('#crdb'+id+'').remove();
            $('#nmb'+id+'').remove();
            $('#kbc'+id+'').remove();
            $('#amana'+id+'').remove();
        
  }
  else if(valu == "Bank"){
            $('#Phone'+id+'').css('display', 'block');
            $('#No'+id+'').css('display','block');
    $('#method_name'+id+'').append(''+
                  +'<option id="emty" value=""></option>'
                    +'<option id="crdb'+id+'" value="CRDB">CRDB</option>'
                    +'<option id="nmb'+id+'" value="NMB">NMB</option>'
                    +'<option id="kbc'+id+'" value="KBC">KBC</option>'
                    +'<option id="amana'+id+'" value="AMANA BANK">AMANA BANK</option>'
            );
          
            $('#tigo'+id+'').remove();
            $('#voda'+id+'').remove();
            $('#tpesa'+id+'').remove();
            $('#airtel'+id+'').remove();
            $('#ezy'+id+'').remove();
            $('#selcome'+id+'').remove();
      
  } else{
    $('#Bank'+id+'').css('display','none');
    $('#Phone'+id+'').css('display','none');
    $('#No'+id+'').css('display','none');
  }
  }

  
   
</script>
@endsection

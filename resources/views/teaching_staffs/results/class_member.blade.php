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
              <li>Class Students</li>
            </ul>
          </div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                @if (session('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   {{ session('success') }}
                </div>
                @endif
            </div>
            <div class="col-md-2"></div>
         
        </div>

    

        <div class="row">
            <div class="col-lg-12">
                <form action="teacher-class-members" method="post" id="popup-validation">
                    @csrf
                <div class="row">
                   <div class="col-md-4">
                    <select required class="validate[required] form-control chzn-select" name="darasas_id" id="darasas_id" >
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                   </div> 
                   <div class="col-md-4">
                    <select required class="validate[required] form-control chzn-select" name="streams_id" id="streams_id" >
                        <option value="">Select Stream</option>
                        @foreach ($streams as $stream)
                            <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                        @endforeach
                    </select>
                   </div> 
                   <div class="col-md-4">
                  <button type="submit" class="btn btn-primary btn-grad btn-rect"><i class="icon-search"></i>&nbsp;Search</button>
                   </div> 
                </div>
                
            </form>
            </div>
        </div> <br><br>
          <!-- AUTOMATIC JUMP-->

          <div style="text-align: center;">
                
            <a class="quick-btn" href="#">
                <i class="icon-calendar icon-2x"></i>
                <span> Current year</span>
                <span class="label label-danger">{{ $current_year->year }}</span>
            </a>

            <a class="quick-btn" href="#">
                <i class="icon-user icon-2x"></i>
                <span>Male Students </span>
                <span class="label label-success">{{ $male_students }}</span>
            </a>
           
            <a class="quick-btn" href="#">
                <i class="icon-user icon-2x"></i>
                <span>Female  </span>
                <span class="label label-warning">{{ $female_students}}</span>
            </a>
            <a class="quick-btn" href="#">
                <i class="icon-gift icon-2x"></i>
                <span>Total </span>
                <span class="label btn-metis-2">{{ $total_students}}</span>
            </a>
            {{-- <a class="quick-btn" href="#">
                <i class="icon-lemon icon-2x"></i>
                <span>tasks</span>
                <span class="label btn-metis-4">107</span>
            </a>
            <a class="quick-btn" href="#">
                <i class="icon-bolt icon-2x"></i>
                <span>Tickets</span>
                <span class="label label-default">20</span>
            </a> --}}

            
            
        </div><br>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
               
                    <h2>{{ $darasa }} &nbsp;{{ $mkondo }}</h2>
             
            </div>
            <div class="col-md-2"></div>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Data
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                          <table class="table table-stripped table-hover" id="dataTables-example">
                            <thead class="thead-light">
                            <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            </tr>
                            </thead>
                            <tbody>
                                 
                            @foreach ($students as $student)
                            <tr>
                            <td>
                                <a href="#" class="items-links">{{ $index++ }}</a>
                              </td>
                              <td>
                                {{ $student->fname }}
                              </td>
                              <td>
                                {{ $student->mname }}
                              </td>
                              <td>
                                {{ $student->lname }}
                              </td>
                           
                        
                                {{-- Modal for editing --}}
                                <div class="modal custom-modal fade bank-details" id="edit_teacher{{ $class->id }}" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <div class="form-header text-start mb-0">
                                    <h4 class="mb-0">Edit Expenses on &nbsp; {{ $class->date }}</h4>
                                    </div>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                      <form action="meditExpenses" method="post">
                                        @csrf
                                    
                                            <input  type="text" class="form-control" hidden value="{{ $class->id }}" name="expenses_id" id="expenses_id">
                                            <div class="bank-inner-details">
                                            <div class="row">
                                            <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                            <label>Date</label>
                                            <input  type="date" class="form-control" value="{{ $class->date }}" name="date" id="date">
                                            </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                            <label>Amount</label>
                                            <input  type="number" step="any" class="form-control" value="{{ $class->amount }}" name="amount" id="amount">
                                            </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12 col-md-6">
                                            <div class="form-group">
                                            <label>Description</label>
                                            <textarea rows="4"  type="text" class="form-control" value="{{ $class->description }}" name="description" id="description">Description Here (Option)</textarea>
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
                                <div class="modal custom-modal fade" id="delete_paid{{ $class->id }}" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-body">
                                    <div class="form-header">
                                    <h3>Delete these Expenses</h3>
                                     <p>Are you sure want to delete?</p>
                                    </div>
                                    <div class="modal-btn delete-action">
                                    <div class="row">
                                    <div class="col-6">
                                        <form  method="POST" action="mdeleteExpenses">
                                          @csrf
                                           <input type="number" hidden value="{{ $class->id }}" name="expenses_id" id="expenses_id">
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


{{-- ADD Modal --}}
    <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="H4"> New Registration</h4><br>
                  <sup class="text-danger">*</sup>&nbsp; This symbol means the field is mandatory (Should filled)
              </div>
           
            <form role="form" method="post" action="admin-save-term" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp; Name</label>
                    <input required name="name" id="name" class="validate[required] form-control" />
                </div>
               <div class="form-group">
                    <label>Description</label>
                    <textarea  name="description" id="description" class="form-control" rows="4"></textarea>
                </div>
      
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submi" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
      </div>
  </div>

</div>
<!--END PAGE CONTENT -->

     <!-- PAGE LEVEL SCRIPTS -->
     <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
     <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
      <script>
          $(document).ready(function () {
              $('#dataTables-example').dataTable();
          });

          function getStream(value){
            
            $.ajax({
              type:'get',
              url:'teacherGetStream',
              data:{darasas_id:value},
              success:function (data) {
                alert(data);
              }
            });
          }
     </script>
@endsection

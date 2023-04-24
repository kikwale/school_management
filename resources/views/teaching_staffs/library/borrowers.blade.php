@extends('layouts.app')

@section('content')
  <!--PAGE CONTENT -->
  <div id="content">

    <div class="inner">
        <div class="row">
     
            <div class="col-lg-12">


                <h2>School &nbsp; {{ Auth::user()->role }} </h2>



            </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb bg-white">
              <li><a href="home">Dashboard</a></li>
              <li>Library Borrowers</li>
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
     
          <div class="col-lg-9">





          </div>
          <div class="col-lg-3">
            @if (Auth::user()->role == "Head Master")
            <a href="teacher-borrower-form" class="btn btn-primary btn-grad btn-rect" ><i class="icon-plus"></i> New Borrower</a>
   
            @endif
              
          </div>
      </div><br>

        <!-- AUTOMATIC JUMP-->
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <header>
                        <div class="icons"><i class="icon-exchange"></i></div>
                        <h5>Filter Borrowers</h5>
                    </header>
                    <div class="body">

                        <form method="POST" action="teachere-filter-borrowers" id="validVal" class="form-inline">
                            @csrf
                            {{-- <div class="row form-group">
                                <div class="col-lg-4">
                                    <input class="form-control autotab" type="text" maxlength="3" tabindex="11" />
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control autotab" type="text" maxlength="4" tabindex="12" />
                                </div>
                                <div class="col-lg-4">
                                    <input class="form-control" type="text" maxlength="5" tabindex="13" />
                                </div>
                            </div> --}}
                            <div class="row form-grou">
                                <div class="col-lg-6 col-md-4">
                                    <select class="form-control autotab chzn-select" name="user_type" tabindex="14">
                                        <option value="">Filter By</option>
                                        <option value="Student">Student</option>
                                        <option value="Teacher">Teacher</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-4">
                                  <button class="btn btn-primary btn-grad btn-rect" type="submit">Filter</button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div><br>
        <!--END AUTOMATIC JUMP-->

        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Borrowers
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Borrowing Date</th>
                                    <th>FullName</th>
                                    <th>Book</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    @if (Auth::user()->role == "Head Master" || Auth::user()->role == "Librarian")
                                    <th>Action</th>
                                    @endif
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                <tr class="odd gradeX">
                                   <td>{{ $value->borrowing_date }}</td>
                                   <td>{{ $value->fullname	 }}</td>
                                    <td>{{ $value->book_name }}</td>
                                    <td>{{ $value->returning_date }}</td>
                                    <td>
                                        @if ($value->returning_date < date('Y-m-d'))
                                        <span class="label label-danger">Time Out</span>
                                        @else
                                        <span class="label label-success">Within Time</span>
                                        @endif
                                      
                                    </td>
                                    @if (Auth::user()->role == "Head Master" || Auth::user()->role == "Librarian")
                                     <td><a data-toggle="modal" data-target="#delete{{ $value->id }}" href="#"><i class="icon-trash text-danger"></i></a></td>
                              
                                    @endif
                                </tr>

                                {{-- Editing Modal --}}
                                <div class="modal fade" id="edit{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="H4"> Editing Form</h4><br>
                                            </div>
                                        <form role="form" method="post" action="teacher-edit-library-user" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="modal-body">
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; FullName</label>
                                                <input required name="fullname" id="fullname" type="text" value="{{ $value->fullname }}" class="form-control" />
                                                <input required name="id" id="id" type="hidden"  value="{{ $value->id }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Date</label>
                                                <input required name="date" id="date" value="{{ $value->date }}" type="date" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; User Type</label>
                                                <select required name="user_type" id="user_type" type="text" class="form-control" >
                                                    <option value="{{ $value->user_type }}">{{ $value->user_type }}</option>
                                                    <option value="Student">Student</option>
                                                    <option value="Teacher">Teacher</option>
                                                    <option value="Teacher">Others</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger"></sup>&nbsp; Phone</label>
                                                <input  name="phone" id="phone" type="text" value="{{ $value->phone }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Entry Time</label>
                                                <input required name="entry_time" id="entry_time" value="{{ $value->entry_time }}" type="time" class="form-control" />
                                            </div>
                                        <div class="form-group">
                                                <label><sup class="text-danger"></sup>&nbsp;Outing Time</label>
                                                <input  type="time" step="any" value="{{ $value->outing_time }}"  name="outing_time" id="outing_time" class="form-control" />
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


                                {{-- Editing Modal --}}
                                <div class="modal fade" id="delete{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="H4">Delete Here</h4><br>
                                            </div>
                                            <div class="modal-body">
                                        <form role="form" method="post" action="teacher-delete-borrowers" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label class="text-danger" style="float:center;"> Are sure you want to delete ?</label>
                                                <input type="hidden" name="id" value="{{ $value->id }}" class="form-control" />
                                            </div>
                                          
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                <button type="submi" class="btn btn-primary">Yes</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
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
           
            <form role="form" method="post" action="teacher-save-library-user" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
             
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp; Date</label>
                    <input required name="date" id="date" type="date" class="form-control" />
                </div>
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp; Borrower Name</label>
                     <select name="library_users_id" id="library_users_id" class="chz n-select form-control ">
                        <option value=""></option>
                        @foreach ($library_users as $library_user)
                            <option value="{{ $library_user->id }}">{{ $library_user->fullname }}</option>
                        @endforeach
                     </select>
                </div>
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp; User Type</label>
                    <select required name="user_type" id="user_type" type="text" class="form-control" >
                        <option value=""></option>
                        <option value="Student">Student</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Teacher">Others</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><sup class="text-danger"></sup>&nbsp; Phone</label>
                    <input  name="phone" id="phone" type="number" step="any" class="form-control" />
                </div>
                <div class="form-group">
                    <label><sup class="text-danger"></sup>&nbsp; Entry Time</label>
                    <input  name="entry_time" id="entry_time" type="time" class="form-control" />
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
     </script>
@endsection

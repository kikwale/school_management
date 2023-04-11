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
              <li>Library Users</li>
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
            <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Library User</button>
   
            @endif
              
          </div>
      </div><br>

        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Library Users
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Book Name</th>
                                    <th>Author</th>
                                    <th>Volume</th>
                                    <th>Edition</th>
                                    <th>Number</th>
                                    <th>Location</th>
                                    @if (Auth::user()->role == "Head Master" || Auth::user()->role == "Librarian")
                                    <th>Action</th>
                                    @endif
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                <tr class="odd gradeX">
                                   <td>{{ $value->name	 }}</td>
                                    <td>{{ $value->author }}</td>
                                    <td>{{ $value->volume }}</td>
                                    <td>{{ $value->edition }}</td>
                                    <td>{{ $value->book_number }}</td>
                                    <td>{{ $value->location }}</td>
                                    @if (Auth::user()->role == "Head Master" || Auth::user()->role == "Librarian")
                                    <td class="center"><a data-toggle="modal" data-target="#edit{{ $value->id }}" href="#"><i class="icon-edit text-primary"></i></a> &nbsp; <a data-toggle="modal" data-target="#delete{{ $value->id }}" href="#"><i class="icon-trash text-danger"></i></a></td>
                              
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
                                        <form role="form" method="post" action="teacher-edit-book" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="modal-body">
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Book Name</label>
                                                <input required name="name" id="name" type="text" value="{{ $value->name }}" class="form-control" />
                                                <input required name="id" id="id" type="hidden"  value="{{ $value->id }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Author</label>
                                                <input required name="author" id="author" value="{{ $value->author }}" type="text" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger"></sup>&nbsp; Volume</label>
                                                <input  name="volume" id="volume" type="text" value="{{ $value->volume }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger"></sup>&nbsp; Edition</label>
                                                <input  name="edition" id="edition" type="text" value="{{ $value->edition }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Book Number</label>
                                                <input required name="book_number" id="book_number" value="{{ $value->book_number }}" type="text" class="form-control" />
                                            </div>
                                        <div class="form-group">
                                                <label><sup class="text-danger"></sup>&nbsp;Location</label>
                                                <input  type="text" step="any" value="{{ $value->location }}"  name="location" id="location" class="form-control" />
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
                                        <form role="form" method="post" action="teacher-delete-book" enctype="multipart/form-data">
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
           
            <form role="form" method="post" action="teacher-save-book" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp; Fullname</label>
                    <input required name="fullname" id="fullname" type="text" class="form-control" />
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

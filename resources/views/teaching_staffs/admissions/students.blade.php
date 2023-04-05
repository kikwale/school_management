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
              <li>Students</li>
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
     
          <div class="col-lg-6">





          </div>
          <div class="col-lg-6">

              <button class="btn btn-warning btn-grad btn-rect" data-toggle="modal" data-target="#"><i class="icon-pencil"></i> Bulk Editing </button>
              <button class="btn btn-success btn-grad btn-rect" data-toggle="modal" data-target="#"><i class="icon-upload"></i> Bulk Photo Updoading</button>
              <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Student</button>

          </div>
      </div><br>

        <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Data
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Entry Status</th>
                                    <th>Entry Date</th>
                                    <th>Health Problem</th>
                                    <th>Physical Condition</th>
                                    <th>Disabled Part(s)</th>
                                    <th>Roll Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                <tr class="odd gradeX">
                                    <td><img class="media-object img-thumbnail user-img" alt="User Picture" src="{{ $value->photo }}" width="64" height="64" srcset=""> </td>
                                    <td>{{ $value->fname }} &nbsp; {{ $value->mname }} &nbsp; {{ $value->lname }}</td>
                                    <td>{{ $value->gender }}</td>
                                    <td class="center">{{$value->entry_status}}</td>
                                    <td class="center">{{ $value->entry_date }}</td>
                                    <td class="center">{{ $value->health_problem }}</td>
                                    <td class="center">{{ $value->physical_condition }}</td>
                                    <td class="center">{{ $value->physical_parts }}</td>
                                    <td class="center">{{ $value->RegNo }}</td>
                                    <td class="center"><a data-toggle="modal" data-target="#edit{{ $value->id }}" href="#"><i class="icon-edit text-primary"></i></a> &nbsp; <a data-toggle="modal" data-target="#delete{{ $value->id }}" href="#"><i class="icon-trash text-danger"></i></a></td>
                                </tr>

                                {{-- Editing Modal --}}
                                <div class="modal fade" id="edit{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="H4"> Editing Form</h4><br>
                                            </div>
                                            <div class="modal-body">
                                        <form role="form" method="post" action="admin-edit-student" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="{{ $value->id }}" class="form-control" />
                                                <label><sup class="text-danger">*</sup>&nbsp; First Name</label>
                                                <input required name="fname" type="text" value="{{ $value->fname }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input  name="mname" value="{{ $value->mname }}" class="form-control" />
                                            </div>
                                           <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp;Last Name</label>
                                                <input required name="lname" value="{{ $value->lname }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Gender</label>
                                                <select required name="gender"  class="form-control">
                                                  <option value="{{ $value->gender }}">{{ $value->gender }}</option>
                                                  <option value="Male">Male</option>
                                                  <option value="Female">Female</option>
                                              </select>
                                            </div>
                                        <div class="form-group">
                                          <label><sup class="text-danger">*</sup>&nbsp; Entrance Status</label>
                                          <select required name="entry_status" id="entry_status"  class="form-control">
                                            <option value="{{ $value->entry_status }}">{{ $value->entry_status }}</option>
                                            <option value="Join">Join</option>
                                            <option value="New">New</option>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                          <label><sup class="text-danger">*</sup>&nbsp; Date of Entry</label>
                                          <input  required name="entry_date" type="date" value="{{ $value->entry_date }}" id="dp1" class="form-control" >
                                        </div>
                                        <div class="form-group">
                                          <label><sup class="text-danger">*</sup>&nbsp; Physical Condition</label>
                                          <select required name="physical_condition"  value="{{ $value->physical_condition }}" id="physical_condition"  class="form-control chzn" >
                                            <option value="{{ $value->physical_condition }}">{{ $value->physical_condition }}</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Disabled">Disabled</option>
                                          </select>
                                        </div>
                                        <div class="form-group">
                                          <label> Disabled Parts</label>
                                          <textarea  name="physical_parts" type="text" value="{{ $value->physical_parts }}" id="physical_parts"class="form-control" rows="4">{{ $value->physical_parts }}</textarea>
                                        </div>
                                        <div class="form-group">
                                          <label> Health Problems</label>
                                          <textarea  name="health_problem" type="text" value="{{ $value->health_problem }}" id="health_problem"class="form-control" rows="4">{{ $value->health_problem }}</textarea>
                                        </div>
                                        <div class="form-group">
                                          <label><sup class="text-danger">*</sup>&nbsp; Entry/Roll Number</label>
                                          <input  required name="RegNo" id="RegNo"class="form-control" value="{{ $value->RegNo }}" >
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Passport Image</label>
                                            <div class="col-lg-8">
                                                <input type="hidden" name="file_name"  value="{{ $value->photo }}" id="">
                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="{{ $value->photo }}" alt="" /></div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div>
                                                        <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input value="{{ $value->photo }}" type="file" name="file" /></span>
                                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <form role="form" method="post" action="admin-delete-student" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="file_name" value="{{ $value->photo }}">
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
      <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="H4"> New Registration</h4><br>
                  <sup class="text-danger">*</sup>&nbsp; This symbol means the field is mandatory (Should filled)
              </div>
              <div class="modal-body">
            <form role="form" method="post" action="admin-save-student" enctype="multipart/form-data">
                @csrf
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; First Name</label>
                  <input required name="fname" class="form-control" />
              </div>
              <div class="form-group">
                  <label>Middle Name</label>
                  <input  name="mname" class="form-control" />
              </div>
             <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp;Last Name</label>
                  <input required name="lname" class="form-control" />
              </div>
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; Gender</label>
                  <select required name="gender"  class="form-control">
                    <option value=""></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
              </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Entrance Status</label>
            <select required name="entry_status" id="entry_status"  class="form-control">
              <option value=""></option>
              <option value="Join">Join</option>
              <option value="New">New</option>
          </select>
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Date of Entry</label>
            <input  required name="entry_date" type="date" id="dp1" class="form-control" >
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Physical Condition</label>
            <select  required name="physical_condition" id="physical_condition"  class="form-control" >
              <option value=""></option>
              <option value="Normal">Normal</option>
              <option value="Disabled">Disabled</option>
            </select>
          </div>
          <div class="form-group" id="disabled">
            <label> Disabled Parts</label>
            <textarea  name="physical_parts" type="text" id="physical_parts" class="form-control" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label> Health Problems</label>
            <textarea  name="health_problem" type="text" id="health_problem"class="form-control" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Entry/Roll Number</label>
            <input  required name="RegNo" id="RegNo"class="form-control" >
          </div>
            <div class="form-group">
              <label class="control-label col-lg-4">Passport Image</label>
              <div class="col-lg-8">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;"><img src="assets/img/demoUpload.jpg" alt="" /></div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                          <span class="btn btn-file btn-primary"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="file" /></span>
                          <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                      </div>
                  </div>
              </div>
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

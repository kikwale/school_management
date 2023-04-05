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
              <li>Teaching Staffs</li>
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

              <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Teacher</button>

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
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Education Level</th>
                                    <th>Salary</th>
                                    <th>Adderss</th>
                                    <th>NIDA</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                <tr class="odd gradeX">
                                    <td><img class="media-object img-thumbnail user-img" alt="User Picture" src="{{ $value->photo }}" width="64" height="64" srcset=""> </td>
                                    <td>{{ $value->fname }} &nbsp; {{ $value->mname }} &nbsp; {{ $value->lname }}</td>
                                    <td>{{ $value->gender }}</td>
                                    <td class="center">{{$value->email}}</td>
                                    <td class="center">{{ $value->phone }}</td>
                                    <td class="center">{{ $value->edu_level }}</td>
                                    <td class="center">{{ $value->salary }}</td>
                                    <td class="center">{{ $value->address }}</td>
                                    <td class="center">{{ $value->national_id }}</td>
                                    <td class="center">{{ $value->role }}</td>
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
                                        <form role="form" method="post" action="admin-edit-teacher" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="file_name" value="{{ $value->photo }}">
                                                <label><sup class="text-danger">*</sup>&nbsp; First Name</label>
                                                <input required name="fname" value="{{ $value->fname }}" class="form-control" />
                                                <input type="hidden" name="id" value="{{ $value->id }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input  name="mname" value="{{ $value->mname }}"  class="form-control" />
                                            </div>
                                        <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp;Last Name</label>
                                                <input required value="{{ $value->lname }}"  name="lname" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Gender</label>
                                                <select required name="gender"  class="form-control">
                                                <option value="{{ $value->gender }}" >{{ $value->gender }} </option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                            <label><sup class="text-danger">*</sup>&nbsp;Phone</label>
                                            <input required name="phone" value="{{ $value->phone }}"  class="form-control" />
                                        </div>
                                            <div class="form-group">
                                            <label><sup class="text-danger">*</sup>&nbsp;Email</label>
                                            <input required name="email" value="{{ $value->email }}"  class="form-control" />
                                        </div>
                                        <div class="form-group">
                                        <label>Basic Salary</label>
                                        <input name="salary" value="{{ $value->salary }}"  id="salary"class="form-control" />
                                        </div>
                                        <div class="form-group">
                                        <label><sup class="text-danger">*</sup>&nbsp; Address</label>
                                        <input  required name="address" value="{{ $value->address }}"  id="address" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                        <label><sup class="text-danger">*</sup>&nbsp; Education Level</label>
                                        <select required name="edu_level" id="edu_level"  class="form-control">
                                            <option value="{{ $value->edu_level }}" >{{ $value->edu_level }} </option>
                                            <option value="O-Level">O-Level</option>
                                            <option value="A-Level">A-Level</option>
                                            <option value="Certificate">Certificate</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Degree">Degree</option>
                                            <option value="Masters">Masters</option>
                                            <option value="Phd">Phd</option>
                                            <option value="Proffessor">Proffessor</option>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                        <label><sup class="text-danger">*</sup>&nbsp; National ID Number</label>
                                        <input  required name="national_id" value="{{ $value->national_id }}" id="national_id"class="form-control" />
                                        </div>
                                        <div class="form-group">
                                        <label><sup class="text-danger">*</sup>&nbsp; Role</label>
                                        <select required name="role" id="role"  class="form-control chzn" >
                                            <option value="{{ $value->role }}" >{{ $value->role }} </option>
                                            <option value="Head Master">Head Master</option>
                                            <option value="Second Master">Second Master</option>
                                            <option value="Academic">Academic</option>
                                            <option value="Accountant">Accountant</option>
                                            <option value="Discipline">Discipline</option>
                                            <option value="Sport Teacher">Sport Teacher</option>
                                            <option value="Normal Teacher">Normal Teacher</option>
                                        </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Passport Image</label>
                                            <div class="col-lg-8">
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
                                        <form role="form" method="post" action="admin-delete-teacher" enctype="multipart/form-data">
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
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="H4"> New Registration</h4><br>
                  <sup class="text-danger">*</sup>&nbsp; This symbol means the field is mandatory (Should filled)
              </div>
              <div class="modal-body">
            <form role="form" method="post" action="admin-save-teacher" enctype="multipart/form-data">
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
                <label><sup class="text-danger">*</sup>&nbsp;Phone</label>
                <input required name="phone" class="form-control" />
            </div>
              <div class="form-group">
                <label><sup class="text-danger">*</sup>&nbsp;Email</label>
                <input required name="email" class="form-control" />
            </div>
          <div class="form-group">
            <label>Basic Salary</label>
            <input  name="salary" id="salary"class="form-control" />
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Address</label>
            <input  required name="address" id="address"class="form-control" />
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Education Level</label>
            <select required name="edu_level" id="edu_level"  class="form-control">
              <option value=""></option>
              <option value="O-Level">O-Level</option>
              <option value="A-Level">A-Level</option>
              <option value="Certificate">Certificate</option>
              <option value="Diploma">Diploma</option>
              <option value="Degree">Degree</option>
              <option value="Masters">Masters</option>
              <option value="Phd">Phd</option>
              <option value="Proffessor">Proffessor</option>
          </select>
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; National ID Number</label>
            <input  required name="national_id" id="national_id"class="form-control" />
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Role</label>
            <select required name="role" id="role"  class="form-control chzn" >
              <option value=""></option>
              <option value="Head Master">Head Master</option>
              <option value="Second Master">Second Master</option>
              <option value="Academic">Academic</option>
              <option value="Accountant">Accountant</option>
              <option value="Discipline">Discipline</option>
              <option value="Sport Teacher">Sport Teacher</option>
              <option value="Normal Teacher">Normal Teacher</option>
          </select>
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

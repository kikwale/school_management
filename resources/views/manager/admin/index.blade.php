@extends('layouts.app')

@section('content')
  <!--PAGE CONTENT -->
  <div id="content">

    <div class="inner">
        <div class="row">
     
            <div class="col-lg-12">


                <h2>School Admins </h2>



            </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb bg-white">
              <li><a href="#">Dashboard</a></li>
              <li>school Admin</li>
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

              <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Admin</button>

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
                                    <td class="center"><a hre><i class="icon-edit text-warning"></i></a> &nbsp; <a><i class="icon-trash text-danger"></i></a></td>
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
              <div class="modal-body">
            <form role="form" method="post" action="madmin-save" enctype="multipart/form-data">
                @csrf
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; First Name</label>
                  <input name="fname" class="form-control" />
              </div>
              <div class="form-group">
                  <label>Middle Name</label>
                  <input  name="mname" class="form-control" />
              </div>
             <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp;Last Name</label>
                  <input name="lname" class="form-control" />
              </div>
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; Gender</label>
                  <select name="gender"  class="form-control">
                    <option value=""></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
              </div>
              <div class="form-group">
                <label><sup class="text-danger">*</sup>&nbsp;Phone</label>
                <input name="phone" class="form-control" />
            </div>
              <div class="form-group">
                <label><sup class="text-danger">*</sup>&nbsp;Email</label>
                <input name="email" class="form-control" />
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
                  <button type="submi" class="btn btn-primary">Save Admin</button>
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

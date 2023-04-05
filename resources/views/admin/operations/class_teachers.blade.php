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
              <li>Class Teachers</li>
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

              <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Class Teacher</button>

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
                                    <th>Teacher Name</th>
                                    <th>Class Name</th>
                                    <th>Stream/Comb</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $value)
                                <tr class="odd gradeX">
                                   <td>{{ $value->fname	 }}&nbsp;{{ $value->lname }}</td>
                                   <td>{{ $value->class_name }}</td>
                                   <td>{{ $value->stream_name }}</td>
                                   <td>{{ $value->level }}</td>
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
                                            
                                        <form role="form" method="post" action="admin-edit-class-teacher" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label><sup class="text-danger">*</sup>&nbsp;Teacher Name </label>
                                                    <input type="hidden" name="id" value="{{ $value->id }}">
                                                    <select class="form-control" required name="teachers_id" id="teachers_id">
                                                        <option value="{{ $value->teachers_id }}">{{ $value->fname }}&nbsp;{{ $value->lname }}</option>
                                                        @foreach ($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}">{{ $teacher->fname }} &nbsp;{{ $teacher->lname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><sup class="text-danger">*</sup>&nbsp;Class Name </label>
                                                    <select class="form-control" required name="darasas_id" id="darasas_id">
                                                        <option value="{{ $value->darasas_id }}">{{ $value->class_name }}</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><sup class="text-danger">*</sup>&nbsp;Stream/Comb Name </label>
                                                    <select class="form-control" required name="stream_or_combs_id" id="stream_or_combs_id">
                                                        <option value="{{ $value->stream_or_combs_id }}">{{ $value->stream_name }}</option>
                                                        @foreach ($streams as $stream)
                                                            <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                                                        @endforeach
                                                    </select>
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
                                        <form role="form" method="post" action="admin-delete-class-teacher" enctype="multipart/form-data">
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
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title" id="H4"> New Registration</h4><br>
                  <sup class="text-danger">*</sup>&nbsp; This symbol means the field is mandatory (Should filled)
              </div>
           
            <form role="form" method="post" action="admin-save-class-teacher" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp;Teacher Name </label>
                    <select class="form-control" required name="teachers_id" id="teachers_id">
                        <option value=""></option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->fname }} &nbsp;{{ $teacher->lname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp;Class Name </label>
                    <select class="form-control" required name="darasas_id" id="darasas_id">
                        <option value=""></option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp;Stream/Comb Name </label>
                    <select class="form-control" required name="stream_or_combs_id" id="stream_or_combs_id">
                        <option value=""></option>
                        @foreach ($streams as $stream)
                            <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                        @endforeach
                    </select>
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

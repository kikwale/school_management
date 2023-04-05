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
              <li>Parents</li>
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
            <a class="btn btn-success btn-grad btn-rect" href="admin-students-parent" ><i class="icon-plus"></i> Asign Students Parent</a>
            <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Parent</button>

          </div>
      </div><br>

      <div class="row" id="students_parent" style="display: none;">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form role="form" method="post" action="admin-save-parent" enctype="multipart/form-data">
                @csrf
           
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; Parent</label>
                  <select required name="gender"  class=" form-control">
                    <option value=""></option>
                    @foreach ($parents as $parent)
                        
                    <option value="{{ $parent->id }}">{{ $parent->fname }} &nbsp;{{ $parent->lname }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; Students</label>
                  <select id="box1View" multiple="multiple" class="form-control" size="16">
                    <option value=""></option>
                    @foreach ($students as $student)
                     <option value="{{ $student->id }}">{{ $student->fname }} &nbsp;{{ $student->lname }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label><sup class="text-danger">*</sup>&nbsp;Relation</label>
                <input required name="phone" class="form-control" />
            </div>
           
        
            </form>
        </div>
        <div class="col-md-2"></div>
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
                                    <th>Employment Status</th>
                                    <th>Institution</th>
                                    <th>Position</th>
                                    <th>Work</th>
                                    <th>Adderss</th>
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
                                    <td class="center">{{ $value->employment_status }}</td>
                                    <td class="center">
                                        @if ($value->institute == "")
                                            - - -
                                        @else
                                        {{ $value->institute }}
                                        @endif 
                                    </td>
                                    <td class="center">
                                        @if ($value->institute == "")
                                            - - -
                                        @else
                                        {{ $value->position }}
                                        @endif 
                                    </td>
                                    <td class="center">
                                        @if ($value->work == "")
                                        - - -
                                        @else
                                        {{ $value->work }}
                                        @endif
                                    </td>
                                    <td class="center">{{ $value->address }}</td>
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
                                        <form role="form" method="post" action="admin-edit-parent" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="hidden" name="file_name" value="{{ $value->photo }}">
                                                <label><sup class="text-danger">*</sup>&nbsp; First Name</label>
                                                <input name="fname" value="{{ $value->fname }}" class="form-control" />
                                                <input type="hidden" name="id" value="{{ $value->id }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input  name="mname" value="{{ $value->mname }}"  class="form-control" />
                                            </div>
                                        <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp;Last Name</label>
                                                <input value="{{ $value->lname }}"  name="lname" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Gender</label>
                                                <select name="gender"  class="form-control">
                                                <option value="{{ $value->gender }}" >{{ $value->gender }} </option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                            <label><sup class="text-danger">*</sup>&nbsp;Phone</label>
                                            <input name="phone" value="{{ $value->phone }}"  class="form-control" />
                                        </div>
                                            <div class="form-group">
                                            <label><sup class="text-danger">*</sup>&nbsp;Email</label>
                                            <input name="email" value="{{ $value->email }}"  class="form-control" />
                                        </div>
                                        <div class="form-group">
                                        <label><sup class="text-danger">*</sup>&nbsp; Address</label>
                                        <input  name="address" value="{{ $value->address }}"  id="address" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><sup class="text-danger">*</sup>&nbsp; Employment Status</label>
                                            <select onchange="employmentStatusEdit(this.value)" required name="employment_status" id="employment_status"  type="text" class="form-control">
                                              <option value="{{ $value->employment_status }}">{{ $value->employment_status }}</option>
                                              <option value="Employed">Employed</option>
                                              <option value="Unemployed">Unemployed</option>
                                              <option value="Self Employed">Self Employed</option>
                                          </select>
                                          </div>
                                          <div class="form-group" id="instedit" style="display:none">
                                            <label> What Institute</label>
                                            <input  name="institute" id="institute" value="{{ $value->institute }}" type="text" class="form-control">
                                          </div>
                                          <div class="form-group" id="posiedit" style="display:none">
                                            <label>Position</label>
                                            <input  name="position" id="position" value="{{ $value->position }}"  type="text" class="form-control">
                                          </div>
                                          <div class="form-group">
                                            <label><sup class="text-danger">*</sup>&nbsp; Work</label>
                                            <input  required name="work" value="{{ $value->work }}" type="text" id="work"class="form-control" >
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
                                        <form role="form" method="post" action="admin-delete-parent" enctype="multipart/form-data">
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
            <form role="form" method="post" action="admin-save-parent" enctype="multipart/form-data">
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
            <label><sup class="text-danger">*</sup>&nbsp; Address</label>
            <input  required name="address" id="address"class="form-control" />
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Employment Status</label>
            <select onchange="employmentStatus(this.value)" required name="employment_status" id="employment_status"  type="text" class="form-control">
              <option value=""></option>
              <option value="Employed">Employed</option>
              <option value="Unemployed">Unemployed</option>
              <option value="Self Employed">Self Employed</option>
          </select>
          </div>
          <div class="form-group" id="inst" style="display:none">
            <label> What Institute</label>
            <input  name="institute" id="institute"  type="text" class="form-control">
          </div>
          <div class="form-group" id="posi" style="display:none">
            <label>Position</label>
            <input  name="position" id="position"  type="text" class="form-control">
          </div>
          <div class="form-group">
            <label><sup class="text-danger">*</sup>&nbsp; Work</label>
            <input  required name="work" type="text" id="work"class="form-control" >
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

          function employmentStatus(value){
             
             if (value == 'Employed' || value == 'Self Employed') {
                $('#inst').css('display','block');
                $('#posi').css('display','block');
             } else {
                $('#inst').css('display','none');
                $('#posi').css('display','none');
             }
          }

          function employmentStatusEdit(value){
             
             if (value == 'Employed' || value == 'Self Employed') {
                $('#instedit').css('display','block');
                $('#posiedit').css('display','block');
             } else {
                $('#instedit').css('display','none');
                $('#posiedit').css('display','none');
             }
          }
     </script>
@endsection

<script>
    function showForm(){
        $('#students_parent').css('display','block');
    }
</script>
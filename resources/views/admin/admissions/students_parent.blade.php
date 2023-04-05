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
                <li><a href="admin-parents">Parents</a></li>
                <li>Students Parent</li>
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
            <button class="btn btn-success btn-grad btn-rect" onclick="showForm()" ><i class="icon-plus"></i> Asign Students Parent</button>
            <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Parent</button>

          </div>
      </div><br>

      <div class="row" id="students_parent" >
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form role="form" method="post" action="admin-save-students-parent" enctype="multipart/form-data">
                @csrf
           
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; Parent</label>
                  <select required name="wazazis_id"  class=" form-control chzn-select">
                    <option value=""></option>
                    @foreach ($parents as $parent)
                        
                    <option value="{{ $parent->id }}">{{ $parent->fname }} &nbsp;{{ $parent->lname }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                  <label><sup class="text-danger">*</sup>&nbsp; Students</label>
                <select id="box1View" name="students_id[]" multiple="multiple" class="form-control" size="16">
                    <option value=""></option>
                    @foreach ($students as $student)
                     <option value="{{ $student->id }}">{{ $student->fname }} &nbsp;{{ $student->lname }}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label><sup class="text-danger">*</sup>&nbsp;Relation</label>
                <input required name="relation" class="form-control" />
            </div>
             <div class="form-group">
                <button type="submit" class="btn btn-primary">save</button>
             </div>
           
        
            </form>
        </div>
        <div class="col-md-2"></div>
      </div><br>

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

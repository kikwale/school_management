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
              <li> Students Contributions</li>
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
                <form action="admin-save-set-contribution" method="post" id="popup-validation">
                    @csrf
                <div class="row">
                   <div class="col-md-3">
                    <select required class="validate[required] form-control chzn-select" name="darasas_id" id="darasas_id" >
                        <option value="">Select Class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                   </div> 
                   <div class="col-md-3">
                    <select required class="validate[required] form-control chzn-select" name="contributions_id" id="contributions_id" >
                        <option value="">Select contribution</option>
                        @foreach ($contributions as $contribution)
                            <option value="{{ $contribution->id }}">{{ $contribution->name }} - {{ $contribution->amount }}</option>
                        @endforeach
                    </select>
                   </div> 
                   <div class="col-md-3">
                    <select class="form-control chzn-select" name="academic_years_id" id="academic_years_id" >
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    </select> 
                   </div> 
                   <div class="col-md-3">
                   <button class="btn btn-primary" type="submit">Set contribution</button>
                   </div> 
                </div>
            
            </form>
            </div>
        </div><br>


          <!-- AUTOMATIC JUMP-->
        
 
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
     </script>
@endsection

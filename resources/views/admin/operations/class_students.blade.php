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
                <form action="admin-save-class-students" method="post" id="popup-validation">
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
                    <select required class="validate[required] form-control chzn-select" name="stream_or_combs_id" id="stream_or_combs_id" >
                        <option value="">Select Stream Or Combination</option>
                        @foreach ($streams as $stream)
                            <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                        @endforeach
                    </select>
                   </div> 
                   <div class="col-md-4">
                    <select class="form-control chzn-select" name="academic_years_id" id="academic_years_id" >
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    </select> 
                   </div> 
                </div>
                <div class="box">
                    <header>
                        <h5><i class="icon-th-large"></i> Asign Class Students</h5>
{{--         
                        <div class="toolbar">
                            <ul class="nav pull-right">
                                <li><a href="#">Link</a></li>
                                <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#"><i
                                        class="icon-th-large"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Demo Link</a></li>
                                        <li><a href="#">Demo Link</a></li>
                                         <li><a href="#">Demo Link</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="accordion-toggle minimize-box" data-toggle="collapse" href="#div-3">
                                        <i class="icon-chevron-up"></i>
                                    </a>
                                </li>
                            </ul>
                        </div> --}}
        
                    </header>
                    <div id="div-3" class="accordion-body collapse in body">
                        <div class="row">
                            
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="box1Filter" type="text" placeholder="Filter" class="form-control" />
                                        <span class="input-group-btn">
                                            <button id="box1Clear" class="btn btn-warning" type="button">x</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select id="box1View" multiple="multiple" class="form-control" size="16">
                                       @foreach ($data as $value)
                                           <option value="{{ $value->id }}">{{ $value->fname }} &nbsp; {{ $value->mname }}&nbsp; {{ $value->lname }}</option>
                                       @endforeach
                                    </select>
                                    <hr>
                                </div>
                            </div>
        
                            <div class="col-lg-2">
                                <div class="btn-group btn-group-vertical" style="white-space: normal;">
                                    <button id="to2" type="button" class="btn btn-primary">
                                        <i class="icon-chevron-right"></i>
                                    </button>
                                    <button id="allTo2" type="button" class="btn btn-primary">
                                        <i class="icon-forward"></i>
                                    </button>
                                    <button id="allTo1" type="button" class="btn btn-danger">
                                        <i class="icon-backward"></i>
                                    </button>
                                    <button id="to1" type="button" class="btn btn-danger">
                                        <i class=" icon-chevron-left icon-white"></i>
                                    </button>
                                </div>
                            </div>
        
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <div class="input-group">
                                        <br><br>
                                        {{-- <input id="box2Filter" type="text" placeholder="Filter" class="form-control" />
                                        <span class="input-group-btn">
                                             <button id="box2Clear" class="btn btn-warning" type="button">x</button> 
                                        </span> --}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select required id="box2View" name="students_id[]" multiple="multiple" class="validate[required] form-control" size="16"></select>
                                </div>
                                <hr />
                                <button class="btn btn-primary" type="submit">save</button>
                                
                            </div>
                       
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
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

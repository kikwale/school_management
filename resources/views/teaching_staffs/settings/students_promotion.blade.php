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
              <li> Students Promotion</li>
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
                <form action="admin-save-promote" method="post" id="popup-validation">
                    @csrf
                <div class="row">
                   <div class="col-md-4">
                        <select onchange="levelChanged(this.value)" required class=" form-control chzn-select" name="level" id="level"   >
                            <option value="">Select Level</option>
                            <option value="Nursery">Nursery</option>
                            <option value="Primary">Primary</option>
                            <option value="O-Level">O-Level</option>
                            <option value="A-Level">A-Level</option>
                        </select>
                   </div> 
                   <div class="col-md-4" id="class_from">
                   
                    
                   </div> 
                   <div class="col-md-4" id="class_to">
                   
                   </div> 
                   
                </div><br>
                <div class="row">
                   
                   <div class="col-md-4" id="stream" style="display:none;">
                    <select class="form-control" name="stream_id" id="stream_id" >
                        <option value="">Current Stream/Combination Belonged</option>
                        @foreach (App\Models\StreamOrComb::where('schools_id',Session::get('school_id'))->get() as $stream)
                        <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                        @endforeach
                       
                    </select> 
                   </div> 
                   <div class="col-md-4" id="academic_years_id1" style="display:none">
                    <select class="form-control" name="academic_years_id" id="academic_years_id" >
                        <option value="{{ $year->id }}">{{ $year->year }}</option>
                    </select> 
                   </div> 
                   <div class="col-md-4" id="promote" style="display: none">
                   <button class="btn btn-primary"  type="submit">Promote</button>
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
<script >
    function levelChanged(value1){
       
        $.ajax({
            type:'get',
            url:'/admin-get-classes',
            data:{level:value1},
            success:function(data){
           
             $('#class_from').html(data);
            }
        });
    }

    function classFromChanged(value1){
        var level = document.getElementById('level').value;
       
        $.ajax({
            type:'get',
            url:'/admin-get-classes-to',
            data:{class_from:value1,level:level},
            success:function(data){
           
             $('#class_to').html(data);
             $('#academic_years_id1').css('display','block');
             $('#promote').css('display','block');
             $('#stream').css('display','block');
            }
        });
    }
</script>
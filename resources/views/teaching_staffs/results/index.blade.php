
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
              <li>Results</li>
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

              <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i>Record New Results</button>

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
                      <table class="table table-stripped table-hover" id="dataTables-example">
                        <thead class="thead-light">
                        <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Level</th>
                        <th>Subject Name</th>
                        <th class="text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                             
                        @foreach ($classes as $class)
                        <tr>
                        <td>
                            <a href="#" class="items-links">{{ $index++ }}</a>
                          </td>
                        <td>
                            {{ $class->class_name }}
                          </td>
                            <td class="text-">{{ $class->level }}</td>
                            <td class="text-">{{ $class->subject_name	 }}</td>
                            <td class="text-end">
                            <a href="teacher-edit-results?id={{ $class->id }}" class="btn btn-sm btn-white text-success me-2"><i class="far fa-edit me-1"></i> Edit</a>
                            <a class="btn btn-sm btn-white text-danger" href="teacher-delete-results?id={{  $class->id }}" ><i class="far fa-trash-alt me-1"></i>Delete</a>
                            </td>
                    
                            {{-- Modal for editing --}}
                            <div class="modal custom-modal fade bank-details" id="edit_teacher{{ $class->id }}" role="dialog">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                <div class="form-header text-start mb-0">
                                <h4 class="mb-0">Edit Expenses on &nbsp; {{ $class->date }}</h4>
                                </div>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                  <form action="meditExpenses" method="post">
                                    @csrf
                                
                                        <input  type="text" class="form-control" hidden value="{{ $class->id }}" name="expenses_id" id="expenses_id">
                                        <div class="bank-inner-details">
                                        <div class="row">
                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <label>Date</label>
                                        <input  type="date" class="form-control" value="{{ $class->date }}" name="date" id="date">
                                        </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <label>Amount</label>
                                        <input  type="number" step="any" class="form-control" value="{{ $class->amount }}" name="amount" id="amount">
                                        </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <label>Description</label>
                                        <textarea rows="4"  type="text" class="form-control" value="{{ $class->description }}" name="description" id="description">Description Here (Option)</textarea>
                                        </div>
                                        </div>
                                       
                                      
                                        </div>
                                        </div>
                                 
                                </div>
                                <div class="modal-footer">
                                <div class="bank-details-btn">
                                <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
                                <button type="submit" class="btn bank-save-btn">Save</button>
                                </div>
                                </div>
                                 </form>
                                </div>
                                </div>
                                </div>
                    
                            {{-- Modal for deleting --}}
                            <div class="modal custom-modal fade" id="delete_paid{{ $class->id }}" role="dialog">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-body">
                                <div class="form-header">
                                <h3>Delete these Expenses</h3>
                                 <p>Are you sure want to delete?</p>
                                </div>
                                <div class="modal-btn delete-action">
                                <div class="row">
                                <div class="col-6">
                                    <form  method="POST" action="mdeleteExpenses">
                                      @csrf
                                       <input type="number" hidden value="{{ $class->id }}" name="expenses_id" id="expenses_id">
                                        <button type="submit" class="btn btn-primary paid-continue-btn">Delete</button>
                                    </form>
                               </div>
                                <div class="col-6">
                                <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
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
<div class="modal custom-modal fade bank-details" id="newReg" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg">
  <div class="modal-content">
  <div class="modal-header">
  <div class="form-header text-start mb-0">
  <h4 class="mb-0"> Record New Results</h4>
  </div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  </div>
  <div class="modal-body">
    <form action="teacher-get-class-students" method="post">
      @csrf
  
          <div class="bank-inner-details">
          <div class="row">
        
          
              <div class="col-lg-6 col-sm-12 col-md-6">
              <div class="form-group">
               <select required onchange="getTeacherStream(this.value)" name="teacher_class_id" id="teacher_class_id" class="form-control">
                <option value="">Select Class</option>
                @foreach ($teacher_classes as $teacher_class)
                    <option value="{{ $teacher_class->id }}">{{ $teacher_class->name }}</option>
                @endforeach
               </select>
              </div>
              </div> 

              <div id="put_stream"></div>
              <div id="put_subject"></div>
             
         
          </div>
          </div>
   
  </div>
  <div class="modal-footer">
  <div class="bank-details-btn">
  <a href="javascript:void(0);" data-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
  <button type="submit" class="btn bank-save-btn">Save</button>
  </div>
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

           function getTeacherStream(value){
           
            $.ajax({
              type:'get',
              url:'getTeacherStream',
              data:{class_id:value},
              success:function(data){
               $('#put_stream').html(data);
              }
            });
           }

           function getTeacherSubject(value){
           var class_id =  document.getElementById('teacher_class_id').value;
           
            $.ajax({
              type:'get',
              url:'getTeacherSubject',
              data:{stream_id:value,class_id:class_id},
              success:function(data){
               $('#put_subject').html(data);
              }
            });
           }
      </script>
@endsection



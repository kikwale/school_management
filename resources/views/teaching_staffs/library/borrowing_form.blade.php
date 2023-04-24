@extends('layouts.app')

@section('content')
  <!--PAGE CONTENT -->
  <div id="content">

    <div class="inner">
        <div class="row">
     
            <div class="col-lg-12">


                <h2>School &nbsp; {{ Auth::user()->role }} </h2>



            </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb bg-white">
              <li><a href="home">Dashboard</a></li>
              <li><a href="teacher-borrowers">Library Borrowers</a> </li>
              <li>Form</li>
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
         
              
          </div>
      </div><br>

        <div class="row">
            <div class="col-md-3"></div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                   
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="teacher-save-borrower-form" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                     
            
                        <div class="form-group">
                            <label><sup class="text-danger">*</sup>&nbsp; Borrower Name</label>
                             <select required name="library_users_id" id="library_users_id" class="chzn-select form-control ">
                                <option value=""></option>
                                @foreach ($library_users as $library_user)
                                    <option value="{{ $library_user->id }}">{{ $library_user->fullname }}</option>
                                @endforeach
                             </select>
                        </div>
                        <div class="form-group">
                            <label><sup class="text-danger">*</sup>&nbsp;Book(S) Borrowed</label>
                             <select required name="books_id[]" id="books_id" class="chzn-select form-control " multiple="multiple" tabindex="4" style="height:25px;">
                                <option value=""></option>
                                @foreach ($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                             </select>
                        </div>
                        <div class="form-group">
                            <label><sup class="text-danger">*</sup>&nbsp; Date of Borrowing</label>
                            <input required id="borrowing_date"  name="borrowing_date" id="borrowing_date" type="date" step="any" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label><sup class="text-danger">*</sup>&nbsp; Deadline</label>
                            <input required name="returning_date" id="returning_date" type="date" step="any" class="form-control" />
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
        <div class="col-md-3"></div>
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


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
              <li>Fees Reports</li>
            </ul>
          </div>
        </div><br>
        <!--BLOCK SECTION -->
        <div class="row">
            <div class="col-lg-12">
                <div style="text-align: center;">
                
                    <a class="quick-btn" href="#">
                        <i class="icon-calendar icon-2x"></i>
                        <span> Current year</span>
                        <span class="label label-danger">{{ $current_year->year }}</span>
                    </a>

                    <a class="quick-btn" href="#">
                        <i class="icon-user icon-2x"></i>
                        <span>Students No</span>
                        <span class="label label-success">{{ number_format($total_students) }}</span>
                    </a>
                    <a class="quick-btn" href="#">
                        <i class="icon-gift icon-2x"></i>
                        <span>Paid Fees</span>
                        <span class="label btn-metis-2">{{ number_format($students_fees_paid) }}</span>
                    </a>
                    <a class="quick-btn" href="#">
                        <i class="icon-signal icon-2x"></i>
                        <span>Unpaid Fee </span>
                        <span class="label label-warning">{{ number_format($total_students_fees) }}</span>
                    </a>
                    <a class="quick-btn" href="#">
                        <i class="icon-gift icon-2x"></i>
                        <span>Estimated </span>
                        <span class="label btn-metis-2">{{ number_format($students_fees_paid + $total_students_fees) }}</span>
                    </a>
                    {{-- <a class="quick-btn" href="#">
                        <i class="icon-lemon icon-2x"></i>
                        <span>tasks</span>
                        <span class="label btn-metis-4">107</span>
                    </a>
                    <a class="quick-btn" href="#">
                        <i class="icon-bolt icon-2x"></i>
                        <span>Tickets</span>
                        <span class="label label-default">20</span>
                    </a> --}}

                    
                    
                </div>

            </div>

        </div><br>
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
         
        </div><hr><br>

        <div class="row">
          <div class="col-md-1"></div>
          <div class="col-lg-9 col-md-10">
            <form role="form" method="post" action="adminGetClassFeeReport" enctype="multipart/form-data">
                @csrf
                <div class="col-md-2">
                    <div class="form-group">
                        <label><sup class="text-danger">*</sup>&nbsp;Filter By</label>
                        <select onchange="getClass(this.value)" class=" form-control chzn-select" name="filter_name" id="filter_name">
                            <option value=""></option>
                            <option value="Class">Class</option>
                            <option value="Term">Term</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
 
                    <div class="form-group" id="filtered_area">
                       
                    </div>
                </div>
               
                <div class="col-md-2">
 
                    <div class="form-group" id="year_report" style="display:none;">
                        <label><sup class="text-danger">*</sup>&nbsp;Select Year</label>
                        <select class=" form-control chzn-" name="year" id="year">
                            <option value=""></option>
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            
                <div class="col-md-2">
 
                    <div class="form-group" id="btn_search" style="display:none;"><br>
                    <button type="submit" class="btn btn-primary btn-grad btn-rect "><i class="icon-search"></i>&nbsp;Search</button>
                    </div>
                </div>
       
           
                
               
            </form>   
          </div>
          <div class="col-lg-1">

              {{-- <button class="btn btn-primary btn-grad btn-rect" data-toggle="modal" data-target="#newReg"><i class="icon-plus"></i> New Fee</button> --}}

          </div>
      </div><br>

      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Students Fees Collection
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Balance</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                           
                                @foreach ($data as $value)
                                <tr class="odd gradeX">
                                   <td><img class="media-object img-thumbnail user-img" alt="User Picture" src="{{ $value->photo }}" width="64" height="64" srcset=""> </td>
                                   <td>{{ $value->fname	 }}</td>
                                    <td>{{ $value->lname }}</td>
                                    <td>{{ number_format( $value->amount) }}</td>
                                    <td>
                                    @if ($value->amount == 0)
                                        <span class="label label-success">Completed</span>
                                    @else
                                    <span class="label label-danger ">UnCompleted</span>
                                    @endif 
                                    </td>
                                    <td class="center">
                                        <a data-toggle="modal" class="text-success" data-target="#fee_payment{{ $value->id }}" href="#"><i class="icon-pencil text-success"></i>Record</a>
                                        &nbsp;<a data-toggle="modal" data-target="#delete{{ $value->id }}" href="#"><i class="icon-edit text-warning"></i>Edit</a> 
                                  </td>
                                </tr>
                                
                                {{-- Editing Modal --}}
                                <div class="modal fade" id="fee_payment{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="H4">Fee Payment Form</h4><br>
                                                <sup class="text-danger">*</sup>&nbsp; This symbol means the field is mandatory (Should filled)
                                            </div>
                                        <form role="form" method="post" action="admin-save-fee-payment" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="modal-body">
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Date of Payments</label>
                                                <input required name="date" type="date" id="date" value="{{ $value->name }}" class="form-control" />
                                                <input type="hidden" name="id" value="{{ $value->id }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Paid Amount</label>
                                                <input required name="amount" id="amount" type="number" step="any" value="{{ $value->name }}" class="form-control" />
                                           </div>
                                           <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp;Term of Payment</label>
                                                <select class="form-control" name="terms_id" id="terms_id">
                                                    <option value=""></option>
                                                    @foreach ($terms as $term)
                                                        <option value="{{ $term->id }}">{{ $term->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                           <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp;Payment Method</label>
                                                <select required onchange="paymentMethod(this.id)" class="form-control" name="methode" id="{{ $value->id }}">
                                                    <option value=""></option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Phone">Phone</option>
                                                    <option value="Bank">Bank</option>
                                                    <option value="Cheque">Cheque</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group" id="provider_bank{{ $value->id }}" style="display: none;">
                                                <label>&nbsp;Provider Name</label>
                                                <select class="form-control" name="methode_name" id="methode_name">
                                                    <option value=""></option>
                                                    <option value="CRDB">CRDB</option>
                                                    <option value="NMB">NMB</option>
                                                    <option value="KCB">KCB</option>
                                                    <option value="NBC">NBC</option>
                                                    <option value="AMANA BANK">AMANA BANK</option>
                                                    <option value="DIAMOND TRUST BANK">DIAMOND TRUST BANK</option>
                                                    <option value="EXIM BANK">EXIM BANK</option>
                                                </select> 
                                            </div>
                                            <div class="form-group" id="provider_phone{{ $value->id }}" style="display: none;">
                                                <label>&nbsp;Provider Name</label>
                                                <select class="form-control" name="methode_name" id="methode_name">
                                                    <option value=""></option>
                                                    <option value="TIGOPESA">TIGOPESA</option>
                                                    <option value="M-PESA">M-PESA</option>
                                                    <option value="AIRTELMONEY">AIRTELMONEY</option>
                                                    <option value="TIGOPESA">TIGOPESA</option>
                                                    <option value="EZYPESA">EZYPESA</option>
                                                    <option value="HALOPESA">HALOPESA</option>
                                                    <option value="T-PESA">T-PESA</option>
                                                 
                                                </select> 
                                            </div>
                                            <div class="form-group" id="no{{ $value->id }}" style="display:none;">
                                                <label>&nbsp; Number </label>
                                                <input  name="number" id="number" type="number" step="any"  class="form-control" />
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
                                                <h4 class="modal-title" id="H4">Update Fee Here</h4><br>
                                            </div>
                                            <div class="modal-body">
                                        <form role="form" method="post" action="admin-edit-fee-payment" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label  style="float:center;">Student First Name</label>
                                                <input type="hidden" name="id" value="{{ $value->id }}" class="form-control" />
                                                <input type="text" disabled name="fname" value="{{ $value->fname }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label  style="float:center;"> Student Last Name</label>
                                                <input type="text" name="lname" disabled value="{{ $value->lname }}" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label  style="float:center;"> Fee Amount</label>
                                                <input type="text" name="amount"  value="{{ $value->amount }}" class="form-control" />
                                            </div>
                                          
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                <button type="submi" class="btn btn-primary">save</button>
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
           
            <form role="form" method="post" action="admin-save-fee" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp; Fee Name</label>
                    <input required name="name" id="name" type="text" class="form-control" />
                </div>
               <div class="form-group">
                    <label><sup class="text-danger">*</sup>&nbsp;Amount</label>
                    <input required type="number" step="any"  name="amount" id="amount" class="form-control" />
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

          function paymentMethod(id){
            value = document.getElementById(id).value;
            if (value == 'Bank') {
                
                $('#provider_phone'+id).css('display','none');
                $('#provider_bank'+id).css('display','block');
                $('#no'+id).css('display','block');

            }
            if (value == 'Phone') {
                
                $('#provider_phone'+id).css('display','block');
                $('#provider_bank'+id).css('display','none');
                $('#no'+id).css('display','block');
            }
            if (value == 'Cheque') {
                
                $('#provider_phone'+id).css('display','none');
                $('#provider_bank'+id).css('display','block');
                $('#no'+id).css('display','block');
            }
            if (value == 'Cash') {
                $('#provider_phone'+id).css('display','none');
                $('#provider_bank'+id).css('display','none');
                $('#no'+id).css('display','none');
            }
          }

          function getClass(value){

            if (value == 'Class') {
                $.ajax({
              type:'get',
              url:'adminGetClassesReport',
              success:function(data){
                $('#filtered_area').html(data);
                $('#year_report').css('display','block');
                $('#btn_search').css('display','block');
              }
            }); 
            }

            if (value == 'Stream') {
              $.ajax({
              type:'get',
              url:'adminGetStream',
              success:function(data){
                $('#filtered_area').html(data);
                $('#year_report').css('display','block');
                $('#btn_search').css('display','block');
              }
            }); 
          
            }
          }

       

        //   function getClassFeeReport(value){
        //     var year_id = document.getElementById('year').value;
        //     if (year_id != "") {
        //         $.ajax({
        //       type:'get',
        //       url:'adminGetClassFeeReport',
        //       data:{darasas_id:value,year_id:year_id},
        //       success:function(data){
        //         $('#fee_table').html(data);
        //       }
        //     });
        //     }
         
        //   }

          function getYear(value){
            var filter_name = document.getElementById('filter_name').value;
            if(filter_name == 'Class'){
                var darasa_id = document.getElementById('darasa_id').value;
                var year_id = document.getElementById('year').value;
                $.ajax({
                type:'get',
                url:'adminGetClassFeeReport',
                data:{darasa_id:darasa_id,year_id:year_id},
                success:function(data){
                 
                    $('#fee_table').html(data);
                }
                });
            }else if(filter_name == 'Term'){
             
            }else if(filter_name == 'Stream'){

            }
          }
     </script>
@endsection



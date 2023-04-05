
@extends('layouts.app')

@section('content')
  <!--PAGE CONTENT -->
  <div id="content">

    <div class="inner">
        <div class="row">
     
            <div class="col-lg-12">


                <h2>School {{ Auth::user()->role }} </h2>



            </div>
        </div>
        <hr />
        <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb bg-white">
              <li><a href="home">Dashboard</a></li>
              <li><a href="teacher-collect-fees"> Fees Collections</a></li>
              <li>Fee Payments</li>
            </ul>
          </div>
        </div><br>
        <!--BLOCK SECTION -->
        
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
            <div class="col-md-3"></div>
            <div class="col-md-7">
                <h1>Payment Informations of Student:</h1>
                <h2 class="text-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $student->fname }}&nbsp;{{ $student->mname }}&nbsp;{{ $student->lname }}</h2>
            </div>
            <div class="col-md-2"></div>
        </div><br>

      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Students Fees Payments
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>date</th>
                                    <th>Term</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($fee_payments as $fee_payment)
                              <tr class="odd gradeX">
                                 <td>{{ $index++	 }}</td>
                                 <td>{{ $fee_payment->date	 }} </td>
                                 <td>{{ $fee_payment->term_name }}</td>
                                 <td>{{ number_format( $fee_payment->amount) }}</td>
                                 <td class="center">
                                   <a href="teacher-view-fee-payments?id={{ $fee_payment->id }}" class="btn"><i class="icon-download text-primary"></i>&nbsp;Reciept</a> &nbsp;
                                   <a data-toggle="modal" data-target="#fee_payment{{ $fee_payment->id }}" href="#" class="btn btn-info"><i class="icon-envelope text-primary"></i>&nbsp;send to parent</a>
                                </td>

                                {{-- ADD Modal --}}
                              <div class="modal fade" id="fee_payment{{ $fee_payment->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title" id="H4"> Form</h4><br>
                                              <sup class="text-danger">*</sup>&nbsp; This symbol means the field is mandatory (Should filled)
                                          </div>
                                      
                                        <form role="form" method="post" action="teacher-send-fee-receipt" enctype="multipart/form-data">
                                            @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label><sup class="text-danger">*</sup>&nbsp; Parent to send email</label>
                                                <input type="hidden" name="fee_payment_id" id="fee_payment_id" value="{{ $fee_payment->id }}">
                                                <select required name="parent_id" id="parent_id" class="form-control">
                                                 <option value=""></option>
                                                 @foreach ($student_parents as $student_parent)
                                                     <option value="{{ $student_parent->wazazis_id }}">{{ $student_parent->fname }}&nbsp;{{ $student_parent->lname }}&nbsp;-&nbsp;{{ $student_parent->relation }}</option>
                                                 @endforeach
                                                </select>
                                            </div>
                                          
                                  
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <button type="submi" class="btn btn-primary">Send</button>
                                          </div>
                                        </form>
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
            $.ajax({
              type:'get',
              url:'adminGetClasses',
              data:{level:value},
              success:function(data){
                $('#darasas1').html(data);
              }
            });
          }

          function getClassFee(value){
            $.ajax({
              type:'get',
              url:'adminGetClassFee',
              data:{darasas_id:value},
              success:function(data){
                $('#fee_table').html(data);
              }
            });
          }
     </script>
@endsection




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
              <li><a href="admin-collect-fees"> Fees Collections</a></li>
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
                                    <th>date</th>
                                    <th>Term</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($fee_payments as $fee_payment)
                              <tr class="odd gradeX">
                                 <td>{{ $fee_payment->date	 }} &nbsp;{{ $fee_payment->lname }}</td>
                                 <td>{{ $fee_payment->term_name }}</td>
                                 <td>{{ number_format( $fee_payment->amount) }}</td>
                                 <td class="center">
                                   <a href="admin-view-fee-payments?id={{ $fee_payment->id }}"><i class="icon-download text-primary"></i>&nbsp;Reciept</a>
                                </td>

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



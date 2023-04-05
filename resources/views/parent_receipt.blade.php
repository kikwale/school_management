<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD-->
<head>
   
     <meta charset="UTF-8" />
    <title>{{ config('app.name') }}</title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <!-- GLOBAL STYLES -->
  <!-- GLOBAL STYLES -->
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/theme.css" />
    <link rel="stylesheet" href="assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->
    <!--END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- END PAGE LEVEL  STYLES -->
       <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
    <!-- END  HEAD-->
    <!-- BEGIN BODY-->
<body class="padTop53 " >

     <!-- MAIN WRAPPER -->
    <div id="wrap">


        <!--PAGE CONTENT -->
        <div id="content">

            <div class="inner" style="min-height:1200px;">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>{{ $title }}</h2>
                        <h3> <b>Receipt No: #{{ $fee_payment->id }}</b></h3>


                    </div>
                </div>
                <hr />
                <div class="row">

                 <div class="col-lg-4 col-md-4">
                    <h2>From</h2>
                    <p><b>School Name:</b>&nbsp; {{ $school->school_name }}</p>
                    <p><b>Address:</b>&nbsp;Country&nbsp; {{ $school->country }} ,&nbsp;Region&nbsp; {{ $school->region }},&nbsp;District&nbsp; {{ $school->district }},&nbsp; Streeet:&nbsp; {{ $school->street }}</p>
                    <p><b>Reg Number:</b>&nbsp; {{ $school->scool_number }}</p>
                 </div>
                 <div class="col-lg-4 col-md-4">
                    <h2>To</h2>
                    <p><b>Parent/Guardian Name:</b>&nbsp; {{ $parent->fname }}&nbsp; {{ $parent->lname }}</p>
                    <p><b>Email:</b>&nbsp; {{ $parent->email }} </p>
                    <p><b>Phone:</b>&nbsp; {{ $parent->phone }}</p>
                 </div>
                 <div class="col-lg-4 col-md-4">
                    <h3>Student Details</h3>
                    <p><b>Fullname:</b>&nbsp; {{ $student->fname }}&nbsp; {{ $student->lname }}</p>
                    <p><b>Health Proplem:</b>&nbsp; {{ $student->health_problem }} </p>
                 </div>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-4">
               
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h2>Payments Informations</h2>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Date Paid</th>
                                    <th>Amount Paid</th>
                                    <th>Term</th>
                                    <th>Payment Method</th>
                                    <th>Provider</th>
                                    <th>Number</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $fee_payment->date }}</td>
                                    <td>{{ $fee_payment->amount }}</td>
                                    <td>{{ $fee_payment->term_name }}</td>
                                    <td>{{ $fee_payment->methode }}</td>
                                    <td>{{ $fee_payment->provider }}</td>
                                    <td>{{ $fee_payment->number }}</td>
                                </tr>
                            </tbody>
                        </table>
                     
                    </div>
                    <div class="col-lg-2 col-md-2"><br>
                        <p>Download pdf file below</p>
                      <a href="http://192.168.1.106:8000/teacher-download-pdf?scl_id={{ $school->id }}&&feepymnt_id={{ $fee_payment->id }}&&prnt_id={{ $parent->users_id }}&&stn_id={{ $student->id }}" target="__blank" class="btn btn-primary"><i class="icon-download"></i>Download PDF</a>
                    </div>
                   </div>
                




            </div>




        </div>
       <!--END PAGE CONTENT -->


    </div>

     <!--END MAIN WRAPPER -->

   <!-- FOOTER -->
    <div id="footer">
        <p>&copy; Copyright 2023 by <a href="www.shotram.com" target="__blank"> Shotram Digital Link</a>  &nbsp; &nbsp;</p>
    </div>
    <!--END FOOTER -->
     <!-- GLOBAL SCRIPTS -->
    <script src="assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

    <script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
</body>
    <!-- END BODY-->
    
</html>

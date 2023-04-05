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


                        <h2>{{ $data->title }}</h2>
                        <h3> <b>Receipt No: #{{ $data->fee_payment_id }}</b></h3>



                    </div>
                </div>
                <hr />
                <div class="row">

                 <div class="col-lg-4 col-md-4">
                    <h2>From</h2>
                    <p><b>School Name:</b>&nbsp; {{ $data->school_name }}</p>
                    <p><b>Address:</b>&nbsp;Country&nbsp; {{ $data->country }} ,&nbsp;Region&nbsp; {{ $data->region }},&nbsp;District&nbsp; {{ $data->district }},&nbsp; Streeet:&nbsp; {{ $data->street }}</p>
                    <p><b>Reg Number:</b>&nbsp; {{ $data->scool_number }}</p>
                 </div>
                 <div class="col-lg-4 col-md-4">
                    <h2>To</h2>
                    <p><b>Parent/Guardian Name:</b>&nbsp; {{ $data->parent_fname }}&nbsp; {{ $data->parent_lname }}</p>
                    <p><b>Email:</b>&nbsp; {{ $data->parent_email }} </p>
                    <p><b>Phone:</b>&nbsp; {{ $data->parent_phone }}</p>
                 </div>
                 <div class="col-lg-4 col-md-4">
                    <h2>Student Details</h2>
                    <p><b>Fullname:</b>&nbsp; {{ $data->student_fname }}&nbsp; {{ $data->student_lname }}</p>
                    <p><b>Health Proplem:</b>&nbsp; {{ $data->student_health_problem }} </p>
                 </div>
                </div>

                <div class="row">

                    <div class="col-lg-4 col-md-4">
               
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h2>Payments Informations</h2>
                        <p><b>Date of Payments:</b>&nbsp; {{ $data->date }} </p>
                        <p><b>Amount Paid:</b>&nbsp; {{ $data->amount }} </p>
                        <p><b>Term:</b>&nbsp; {{ $data->term_name }} </p>
                        <p><b>Payment Method:</b>&nbsp; {{ $data->methode }} </p>
                        <p><b>Provider:</b>&nbsp; {{ $data->provider }} </p>
                        <p><b>Number:</b>&nbsp; {{ $data->number }} </p>
                       
                    </div>
                    <div class="col-lg-2 col-md-2">
                        
                    </div>
                   </div>


            </div>




        </div>
       <!--END PAGE CONTENT -->


    </div>

     <!--END MAIN WRAPPER -->

 

</body>
    <!-- END BODY-->
    
</html>

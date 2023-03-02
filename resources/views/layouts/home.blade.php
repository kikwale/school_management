<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
   <title>{{ config('app.name','School-Management') }}</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />
    <!--[if IE]>
       <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
       <![endif]-->
   <!-- GLOBAL STYLES -->
    <!-- PAGE LEVEL STYLES -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.css" />
   <link rel="stylesheet" href="assets/css/login.css" />
   <link rel="stylesheet" href="assets/plugins/magic/magic.css" />
    <!-- END PAGE LEVEL STYLES -->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
</head>

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body >


 
    @yield('content')

<!--END MAIN WRAPPER -->



  <!-- PAGE LEVEL SCRIPTS -->
  <script src="assets/plugins/jquery-2.0.3.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/login.js"></script>
  <!--END PAGE LEVEL SCRIPTS -->


</body>

<!-- END BODY -->
</html>
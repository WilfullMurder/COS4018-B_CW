<!-- Admin index -->
<?php

include "includes/unset-sessions.php";


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Life Admin</title>
    <!-- Bootstrap Styles-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- FontAwesome Styles-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Admin Styles-->
    <link href="assets/css/admin-styles.css?version=55" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
    <?php include "includes/header.php"; include "includes/sidebar.php"; ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <!-- page inner  -->
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Dashboard <small class="nav-dash-small">Summary of your products</small>
                        </h1>
                    </div>
                </div>
                
                <!-- just a bunch of made up stuff for now. needs linking to genuine site data -->
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-border bg-color-green">
                            <div class="panel-body">
                            <i class="fa fa-database fa-5x"></i>
                                <h3>1,457</h3>
                            </div>
                            <div class="panel-footer back-footer-green">
                                Products
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-border bg-color-brown">
                            <div class="panel-body">
                                <i class="fa fa-users fa-5x"></i>
                                <h3>36,752 </h3>
                            </div>
                            <div class="panel-footer back-footer-brown">
                                Total Visits
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-border bg-color-red">
                            <div class="panel-body">
                                <i class="fa fa-usd fa-5x"></i>
                                <h3>5,823 </h3>
                            </div>
                            <div class="panel-footer back-footer-red">
                                Sales
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-border bg-color-purple">
                            <div class="panel-body">
                            <i class="fa fa-headphones fa-5x"></i>
                                <h3>other data</h3>
                            </div>
                            <div class="panel-footer back-footer-purple">
                                Optional else
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-border bg-color-blue">
                            <div class="panel-body">
                                <i class="fa fa fa-comments fa-5x"></i>
                                <h3>other data</h3>
                            </div>
                            <div class="panel-footer back-footer-blue">
                                Optional else
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-border bg-color-yellow">
                            <div class="panel-body">
                                <i class="fa fa-fire fa-5x"></i>
                                <h3>other data</h3>
                            </div>
                            <div class="panel-footer back-footer-yellow">
                                Optional else
                            </div>
                        </div>
                    </div>
                </div>
				<?php  include "includes/footer.php"; ?>
            </div>
            <!-- page inner  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Metis Menu Js -->
    <script src="js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="js/morris/raphael-2.1.0.min.js"></script>
    <script src="js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="js/custom-scripts.js"></script>
</body>
</html>
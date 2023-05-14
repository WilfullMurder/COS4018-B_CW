<!--Admin UI page for editing existing users-->
<?php 
require "includes/dbh.php";
include "includes/unset-sessions.php";
//only query users, not admin --> admin add/drops should be done in db!
$sqlusers = "SELECT * FROM accounts WHERE b_admin = 0";
$queryusers = mysqli_query($con, $sqlusers);
$numusers = mysqli_num_rows($queryusers);
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Admin</title>
	<!-- Bootstrap Styles-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
     <!-- FontAwesome Styles-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Admin Styles-->
    <link href="assets/css/admin-styles.css?version=1" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <?php include "includes/header.php"; include "includes/sidebar.php";?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			    <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            <!--Page inner-->
                            Users <small class="nav-dash-small"> View, edit or delete a user</small>
                        </h1>
                    </div>
                </div>

                <?php
                
                    if(isset($_REQUEST['adduser']))
                    {
                        //process add user request
                        if($_REQUEST['adduser'] == "success")
                        {
                            echo "<div class='alert alert-success'> 
                                    <strong>Success!</strong> user added!
                                  </div>";
                        }
                    }
                    if(isset($_REQUEST['updateuser']))
                    {
                        //process update user request
                        if($_REQUEST['updateuser'] == "success")
                        {
                            echo "<div class='alert alert-success'> 
                                    <strong>Success!</strong> user saved!
                                  </div>";
                        }
                    }

                   if(isset($_REQUEST['deleteuser']))
                    {
                        //process delete user request
                        if($_REQUEST['deleteuser'] == "success")
                        {
                            echo "<div class='alert alert-success'> 
                                    <strong>Success!</strong> user deleted!
                                  </div>";
                        }
                        else if ($_REQUEST['deleteuser'] == "error")
                        {
                             echo "<div class='alert alert-danger'> 
                                    <strong>Unexpected Error!</strong> user not deleted!
                                  </div>";
                        }
                    }

                ?>

            <div class="row">
                <div class="col-lg-12">
                    

                    <!-- Info Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All users
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Member Since</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $counter = 0;
                                            //fetch users
                                            while($rowusers = mysqli_fetch_assoc($queryusers))
                                            {
                                                $counter++;
                                                $userID = $rowusers['n_id'];
                                                $username = $rowusers['v_username'];
                                                $userEmail = $rowusers['v_email'];
                                                $dateJoined = $rowusers['d_date_joined'];

                                            
                    
                                        ?>

                                        <tr>
                                            <td><?php echo $counter; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td><?php echo  $userEmail; ?></td>
                                            <td><?php echo $dateJoined; ?></td>
                                            <td>
                                                <!--View button should direct admin to a user page that breaks down the user activity, purchases and comments-->
                                                <!--<button class="popup-button" onclick="window.open('includes/single-user.php?user=<?php echo $username; ?>', '_blank');">View</button>-->
                                                <!--Edit button should direct admin to a page that allows them to change emails, passwords, etc-->
                                                <!--<button class="popup-button" onclick="location.href='includes/edit-user.php?userid=<?php echo $userID; ?>'">Edit</button>-->

                                                <button class="popup-button" data-bs-toggle="modal" data-bs-target="#delete<?php echo $userID; ?>">Delete</button>
                                            </td>
                                        </tr>
                                        <!--modals for button press confirmation-->
                                    <div class="modal fade" id="delete<?php echo $userID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="includes/delete-user.php">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="user-id" value="<?php echo $userID; ?>">
                                                        <p>Are you sure that you want to delete this user?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="delete-user-btn">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!-- End  Info Table -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

                </div> 
                 <!-- /. ROW  -->
				<?php include "includes/footer.php"; ?>
				</div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
    
   
</body>
</html>

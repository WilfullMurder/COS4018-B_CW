<?php
    //fetch categories
    require "includes/dbh.php";
    include "includes/unset-sessions.php";
    $sqlCategories = "SELECT * FROM Product_category";
    $queryCategories = mysqli_query($con, $sqlCategories);
    $numCategories = mysqli_num_rows($queryCategories);
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product post Admin</title>
	<!-- Bootstrap Styles-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
     <!-- FontAwesome Styles-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Custom Styles-->
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
                            <!--page-inner-->
                            Product Categories <small class="nav-dash-small">Organise Products by custom category.</small>
                        </h1>
                    </div>
                    <?php 
                        if(isset($_REQUEST['addcategory']))
                        {
                            //process add category request
                            if($_REQUEST['addcategory'] == "success")
                            {
                                echo "<div class= 'alert alert-success'>
                                        <strong>Success</strong> Category added.
                                      </div>";
                            }
                            elseif ($_REQUEST['addcategory'] == "error") 
                            {
                                echo "<div class= 'alert alert-error'>
                                        <strong>Error</strong> Unexpected error! Category not added!
                                      </div>";
                            }

                        }
                        elseif(isset($_REQUEST['editcategory']))
                        {
                            //process edit category request
                            if($_REQUEST['editcategory'] == "success")
                            {
                                echo "<div class= 'alert alert-success'>
                                        <strong>Success!</strong> Category edited.
                                      </div>";
                            }
                            elseif ($_REQUEST['editcategory'] == "error") 
                            {
                                echo "<div class= 'alert alert-error'>
                                        <strong>Error!</strong> Unexpected error! Category not edited!
                                      </div>";
                            }

                        }                        
                        elseif(isset($_REQUEST['deletecategory']))
                        {
                            //process delete category request
                            if($_REQUEST['deletecategory'] == "success")
                            {
                                echo "<div class= 'alert alert-success'>
                                        <strong>Success!</strong> Category deleted.
                                      </div>";
                            }
                            elseif ($_REQUEST['deletecategory'] == "error") 
                            {
                                echo "<div class= 'alert alert-error'>
                                        <strong>Error!</strong> Unexpected error! Category not deleted!
                                      </div>";
                            }

                        }

                    ?>
                    <!--submit button-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add a category
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" method="POST" action="includes/add-category.php">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name="category-name">

                                        </div>
                                        <div class="form-group">
                                            <label>Category Path</label>
                                            <input class="form-control" name = "category-path">
                                            <p class="help-block">Path must be lower case, no spaces.</p>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-default" name="add-category-btn">Add Category</button>
                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->

                    <!--  Info Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All Categories
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="admin-table-header">
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Category Path</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            //fetch exisiting categories for table
                                            $count = 0;
                                            while($rowCategories = mysqli_fetch_assoc($queryCategories))
                                            {
                                                $count++;
                                                $id = $rowCategories['n_category_id'];
                                                $name = $rowCategories['v_category_title'];
                                                $categoryPath = $rowCategories['v_category_path'];
                                        ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $name; ?></td>
                                                <td><?php echo $categoryPath; ?></td>
                                                <td>
                                                    <!--View button needs link to an admin products page refined by category-->
                                                    <!--<button class="popup-button" onclick="window.open('../categories.php?group=<?php echo $categoryPath?>','_blank');">View</button>-->
                                                    <!--Edit & delete buttons are linked-->
                                                    <button data-bs-toggle="modal" data-bs-target="#edit<?php echo $id; ?>" class="popup-button">Edit</button>
                                                    <button data-bs-toggle="modal" data-bs-target="#delete<?php echo $id; ?>" class="popup-button">Delete</button>
                                                </td>
                                                <!--modals for button press confirmation-->
                                                <div class="modal fade" id="edit<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                         <div class="modal-content">
                                                            <form method="POST" action="includes/edit-category.php">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Edit Category</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="category-id" value="<?php echo $id; ?>">
                                                                    <div class="form-group">
                                                                        <label>Name</label>
                                                                        <input class="form-control" name="edit-category-name" value="<?php echo $name; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Path</label>
                                                                        <input class="form-control" name="edit-category-path" value="<?php echo $categoryPath; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" name="edit-category-btn">Save changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="delete<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                         <div class="modal-content">
                                                            <form method="POST" action="includes/delete-category.php">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="category-id" value="<?php echo $id; ?>">
                                                                    <p>Are you sure you want to delete category?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" name="delete-category-btn">Delete</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr> 
                                    <?php 
                                            }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                     <!-- End Info Table -->
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

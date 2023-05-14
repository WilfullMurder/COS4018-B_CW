<!--Admin UI page for editing existing products-->
<?php 
//fetch products
require "includes/dbh.php";
include "includes/unset-sessions.php";
$sqlProducts = "SELECT * FROM products";
$queryProducts = mysqli_query($con, $sqlProducts);
$numProducts = mysqli_num_rows($queryProducts);
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>product post Admin</title>
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
        <!-- /. NAV SIDE BAR  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			    <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            <!--Page inner-->
                            Product Posts <small class="nav-dash-small"> View, edit or delete an existing product post</small>
                        </h1>
                    </div>
                </div>

                <?php
                
                    if(isset($_REQUEST['addproduct']))
                    {
                        //process add product request
                        if($_REQUEST['addproduct'] == "success")
                        {
                            echo "<div class='alert alert-success'> 
                                    <strong>Success!</strong> product added!
                                  </div>";
                        }
                    }
                    if(isset($_REQUEST['updateproduct']))
                    {
                        //process update productr request
                        if($_REQUEST['updateproduct'] == "success")
                        {
                            echo "<div class='alert alert-success'> 
                                    <strong>Success!</strong> product saved!
                                  </div>";
                        }
                    }

                   if(isset($_REQUEST['deleteproduct']))
                    {
                        //process delete product request
                        if($_REQUEST['deleteproduct'] == "success")
                        {
                            echo "<div class='alert alert-success'> 
                                    <strong>Success!</strong> product deleted!
                                  </div>";
                        }
                        else if ($_REQUEST['deleteproduct'] == "error")
                        {
                             echo "<div class='alert alert-danger'> 
                                    <strong>Unexpected Error!</strong> product not deleted!
                                  </div>";
                        }
                    }

                ?>

            <div class="row">
                <div class="col-lg-12">
                    

                    <!-- Info Table -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            All products
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Sold Since</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php 
                                            $counter = 0;
                                            //fetch products                                            
                                            while($rowproducts = mysqli_fetch_assoc($queryProducts))
                                            {
                                                $counter++;
                                                $prodID = $rowproducts['n_id'];
                                                $prodName = $rowproducts['v_name'];
                                                $catID = $rowproducts['n_category_id'];
                                                $prodDesc = $rowproducts['v_description'];
                                                $prodPrice = $rowproducts['f_price'];
                                                $prodRRP = $rowproducts['f_rrp'];
                                                $img = $rowproducts['v_img'];
                                                $datePosted = $rowproducts['d_date_created'];

                                                $sqlGetCatName = "SELECT v_category_title FROM product_category WHERE n_category_id = '$catID'";
                                                $queryCatName = mysqli_query($con, $sqlGetCatName);

                                                if($rowGetCatName = mysqli_fetch_assoc($queryCatName))
                                                {
                                                    $catName = $rowGetCatName['v_category_title'];
                                                }
                    
                                        ?>

                                        <tr>
                                            <td><?php echo $counter; ?></td>
                                            <td><?php echo $prodName; ?></td>
                                            <td><?php echo $catName; ?></td>
                                            <td><?php echo $datePosted; ?></td>
                                            <td>
                                                <!--View button needs to take admin to product page-->
                                                <!--<button class="popup-button" onclick="window.open('product=<?php echo $prodName; ?>', '_blank');">View</button>-->
                                                <!--Edit button needs to take admin to bring up edit modal-->
                                                <!--<button class="popup-button" onclick="location.href='includes/edit-product.php?productid=<?php echo $prodID; ?>'">Edit</button>-->
                                                <button class="popup-button" data-bs-toggle="modal" data-bs-target="#delete<?php echo $prodID; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <!--modals for button press confirmation-->
                                    <div class="modal fade" id="delete<?php echo $prodID; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form method="POST" action="includes/delete-product.php">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Delete product Post</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="product-id" value="<?php echo $prodID; ?>">
                                                        <p>Are you sure that you want to delete this product post?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="delete-product-btn">Delete</button>
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

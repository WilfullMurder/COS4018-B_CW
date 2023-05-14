<!-- Admin page for adding new products -->
<?php 
require "includes/dbh.php";
session_start();
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Admin</title>
	 <!-- Bootstrap Styles-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

     <!-- FontAwesome Styles-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="assets/css/admin-styles.css?version=1" rel="stylesheet" />
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <?php include "includes/header.php"; include "includes/sidebar.php"; ?>
       
        <div id="page-wrapper" >
            <div id="page-inner">
			    <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            <!-- page inner  -->
                            Add a product <small class="nav-dash-small">Create a new product post</small>
                        </h1>
                    </div>
                </div>
                
                <?php 

                
                    if(isset($_REQUEST['addproduct']))
                    {
                        //Run through the last request by error type
                        // <!-- title errors -->
                        if($_REQUEST['addproduct'] == "emptytitle")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> please add a product title.
                                  </div>";
                        }
                        else if($_REQUEST['addproduct'] == "titlebeingused")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> Title being used by existing product. Please rename new or existing product and try again.
                                  </div>";
                        }
                        // <!-- end title errors -->
                        else if($_REQUEST['addproduct'] == "emptyprice")
                        {
                            echo "<div class = 'alert alert-danger'>
                            <strong>Error!</strong> please include an actual price.
                            </div>";
                        }
                        // <!-- category errors -->
                        else if($_REQUEST['addproduct'] == "emptycategory")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> please select a category.
                                  </div>";
                        }

                        // <!-- content errors -->
                        else if($_REQUEST['addproduct'] == "emptycontent")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> please add a product content.
                                  </div>";
                        }
                        // <!-- tag errors -->
                        else if($_REQUEST['addproduct'] == "emptytags")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> please add at least one product tag.
                                  </div>";
                        }
                        // <!-- path errors -->
                        else if($_REQUEST['addproduct'] == "emptypath")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> please add a product path.
                                  </div>";
                        }
                        else if($_REQUEST['addproduct'] == "pathbeingused")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> Path being used by existing product. Please rename new or existing product path and try again.
                                  </div>";
                        }
                        else if($_REQUEST['addproduct'] == "pathcontainspaces")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> product path format error! product path must not contain spaces! please try again.
                                  </div>";
                        }
                        // <!-- end path errors -->

                        // <!-- sql errors -->
                        else if($_REQUEST['addproduct'] == "sqlerror")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> SQL error! please try again.
                                  </div>";
                        }
                        // <!-- image errors - main -->
                        else if($_REQUEST['addproduct'] == "emptymainimage")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> Main Image error! No main image selected! please upload main image file.
                                  </div>";
                        }
                        else if($_REQUEST['addproduct'] == "mainimageerror")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> Main Image error! Please upload different main image file.
                                  </div>";
                        }
                        else if($_REQUEST['addproduct'] == "invalidtypemainimage")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> Main Image error! Invalid file type! Please upload valid main image file (jpg, jpeg, png, gif, bmp).
                                  </div>";
                        }
                        else if($_REQUEST['addproduct'] == "erroruploadingmainimage")
                        {
                            echo "<div class = 'alert alert-danger'>
                                    <strong>Error!</strong> Main Image upload error! please try again.
                                  </div>";
                        }
                        // <!-- end image errors - main -->

                        else if($_REQUEST['addproduct'] == "success")
                        {
                            echo "<div class= 'alert alert-success'>
                                        <strong>Success!</strong> Product added.
                                      </div>";
                        }

                    }
                ?>
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Write a product
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- validate image format on submit -->
                                    <form role="form" method="POST" action="includes/add-product.php" enctype="multipart/form-data" onsubmit="return validateImage();">
                                        <!-- form groups - if session is set form groups will set to session var -->
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input class="form-control" name="product-name" value="<?php if(isset($_SESSION['productName'])){echo $_SESSION['productName'];} ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>RRP</label>
                                            <input class="form-control" name="product-rrp" value="<?php if(isset($_SESSION['productRRP'])){echo $_SESSION['productRRP'];} ?>">
                                            <label>Actual price</label>
                                            <input class="form-control" name="product-ap" value="<?php if(isset($_SESSION['productAP'])){echo $_SESSION['productAP'];} ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Product Category</label>
                                            <select class="form-control" name="product-category">
                                                <option value="">Select a category...</option>
                                                <?php
                                                // category drop down menu, Admin can create custom categories so we pull from sql db.
                                                $sqlCategories = "SELECT * FROM product_category";
                                                $queryCategories = mysqli_query($con, $sqlCategories);

                                                while($rowCategories = mysqli_fetch_assoc($queryCategories))
                                                {
                                                    //fetch the categories and add to dropdown
                                                    $catID = $rowCategories['n_category_id'];
                                                    $catName = $rowCategories['v_category_title'];

                                                    if(isset($_SESSION['productCategory']))
                                                    {
                                                        if($_SESSION['productCategory'] == $catID)
                                                        {
                                                            echo "<option value='".$catID."' selected=''> ".$catName." </option>";
                                                        }
                                                        else
                                                        {
                                                            echo "<option value='".$catID."'> ".$catName." </option>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='".$catID."'> ".$catName." </option>";
                                                    }
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                        <!-- rest of the form -->
                                        <div class="form-group">
                                            <label>Main Image upload</label>
                                            <div class=container-img-upload>
                                                <input type="file" name="product-main-image" id="product-main-image">    
                                            </div> 
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea class="form-control" rows="3" name="product-content"><?php if (isset($_SESSION['productContent'])) { echo $_SESSION['productContent'];} ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Tags <small> must be comma separated</small></label>
                                            <textarea class="form-control" rows="3" name="product-tags"><?php if(isset($_SESSION['productTags'])){echo $_SESSION['productTags'];} ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Path <small>must be lower case, must not contain spaces</small></label>
                                            <div class = "input-group">
                                                <span class="input-group-addon">www.SmartLife.com/ </span>
                                                <input type="text" class="form-control" placeholder="" name="product-path" value="<?php if(isset($_SESSION['productPath'])){echo $_SESSION['productPath'];} ?>">
                                            </div>
                                        </div>
                                        <!-- submit btn -->
                                        <button type="submit" class="btn btn-default btn-publish" name="product-submit">Publish</button>
                                    </form>
                                </div>
                                 <!-- /form groups -->
                            </div>
                           <!-- /.row (nested) --> 
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<?php include "includes/footer.php"; ?>
			</div>
             <!-- /. page inner  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->

    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>
      <!-- Bootstrap Js -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Validate Image -->
    <script>
        // validates image file extension
        function validateImage()
        {
           
            var mainImage = $("#product-main-image").val();
            var extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            var mainImageExtension = mainImage.split('.');

            //we always want the back end
            mainImageExtension = mainImageExtension.reverse();

            mainImageCheck = false;

            if(mainImage.length > 0)
            {
                if($.inArray(mainImageExtension[0].toLowerCase(), extensions) >= -1)
                {
                    mainImageCheck = true;
                }
                else
                {
                    alert("Error -> Main Image file upload is using incorrect extension! Upload only 'jpg', 'jpeg', 'png', 'gif', 'bmp'");
                    mainImageCheck = false;
                }
            }
            else
            {
                alert("Error -> No Main Image file!  please upload only 'jpg', 'jpeg', 'png', 'gif', 'bmp'");
                mainImageCheck = false;
            }

            if(mainImageCheck)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    </script>
    
   
</body>
</html>

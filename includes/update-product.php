<!-- Admin update product page -->
<?php
require "dbh.php";
session_start();

if (isset($_POST['submit-edit-product'])) {
    //edit product button clicked
    //get from POST
    $productId = $_POST['product-id'];
    $name = $_POST['product-name'];
    $productCategoryId = $_POST['product-category'];
    $productContent = $_POST['product-content'];
    $productTags = $_POST['product-tags'];

    //form validation
    if (empty($name)) {
        formError("emptyname");
    }
    else if (empty($productCategoryId)) {
        formError("emptycategory");
    }
    else if (empty($productSummary)) {
        formError("emptysummary");
    }
    else if (empty($productContent)) {
        formError("emptycontent");
    }
    else if (empty($productTags)) {
        formError("emptytags");
    }
    else if (empty($productPath)) {
        formError("emptypath");
    }
    if (strpos($productPath, " ") !== false) {
        formError("pathcontainsspaces");
    }

    //prepare query
    $sqlCheckproductname = "SELECT v_name FROM products WHERE v_name = '$name' AND v_name != '$name'";
    $queryCheckproductname = mysqli_query($conn, $sqlCheckproductname);

    //already a product
    if (mysqli_num_rows($queryCheckproductname) > 0) {
        formError("namebeingused");
    }

    //validate img
    $mainImgUrl = uploadImage($_FILES["main-product-image"]["name"], "main-product-image", "main", "v_main_image_url", $name);


    if ($mainImgUrl == "noupdate") {
            //img not changed
            $sqlUpdateproduct = "UPDATE products SET n_category_id = '$productCategoryId', v_name = '$name', v_content = '$productContent',  d_date_created = '$date' WHERE n_id = '$productId'";
    }
    else {
        //img also changed
        $sqlUpdateproduct = "UPDATE products SET n_category_id = '$productCategoryId', v_name = '$name', v_content = '$productContent', v_main_image_url = '$mainImgUrl', d_date_created = '$date' WHERE n_id = '$productId'";
    }
    //update tags
    $sqlUpdateproductTags = "UPDATE product_tags SET v_tag = '$productTags' WHERE n_productid = '$productId'";


    if (mysqli_query($con, $sqlUpdateproduct) && mysqli_query($conn, $sqlUpdateproductTags)) {
        //we updated product and tags
        formSuccess();
    }
    else {
        //something went wrong
        formError("sqlerror");
    }

}
else {
    //button not pressed
    header("Location: ../index.php?success=failure");
    exit();
}

function formSuccess() {
    //form is success so unset sessions
    require "dbh.php";
    mysqli_close($conn);

    unset($_SESSION['editproductId']);
    unset($_SESSION['editname']);
    unset($_SESSION['editCategoryId']);
    unset($_SESSION['editContent']);
    unset($_SESSION['editTags']);

    header("Location: ../products.php?updateproduct=success");
    exit();

}

function formError($errorCode) {
    //some sort of error occured
    require "dbh.php";
    
    $_SESSION['editname'] = $_POST['product-name'];
    $_SESSION['editCategoryId'] = $_POST['product-category'];
    $_SESSION['editContent'] = $_POST['product-content'];
    $_SESSION['editTags'] = $_POST['product-tags'];

    mysqli_close($conn);
    header("Location: ../edit-product.php?updateproduct=".$errorCode);
    exit();

}

function uploadImage($img, $imgName, $imgType, $imgDbColumn, $name) {
    //check img valididty
    require "dbh.php";

    $imgUrl = "";

    $validExt = array("jpg", "png", "jpeg", "bmp", "gif");

    if ($img == "") {
        return "noupdate";
    }
    else {

        if ($_FILES[$imgName]["size"] <= 0) {
            formError($imgType."imageerror");
        }
        else {
    
            $ext = strtolower(end(explode(".", $img)));
            if (!in_array($ext, $validExt)) {
                formError("invalidtype".$imgType."image");
            }

            // delete old image
            $productId = $_POST['product-id'];

            $sqlGetOldImage = "SELECT ".$imgDbColumn." FROM product_post WHERE n_product_post_id = '$productId'";
            $queryGetOldImage = mysqli_query($conn, $sqlGetOldImage);

            if ($rowGetOldImage = mysqli_fetch_assoc($queryGetOldImage)) {
                $oldImgURL = $rowGetOldImage[$imgDbColumn];
            }

            if (!empty($oldImgURL)) {
                $oldImgURLArray = explode("/", $oldImgURL);
                $oldImgName = end($oldImgURLArray);
                $oldImgPath = "../images/product-images/".$oldImgName;
                unlink($oldImgPath);
            }
    
            $folder = "../assets/img/";
            $imgNewName = $name.'.'.$extension;
            $imgPath = $folder.$imgNewName;
    
            if (move_uploaded_file($_FILES[$imgName]['tmp_name'], $imgPath)) {
                $imgUrl = "http://localhost/product/admin/images/product-images/".$imgNewName;
            }
            else {
                formError("erroruploading".$imgType."image");
            }
        }

        return $imgPath;

    }
}
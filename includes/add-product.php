<?php

require "dbh.php";
session_start();

if(isset($_POST['product-submit']))
{
	$name = $_POST['product-name'];
	$category = $_POST['product-category'];
	$content = $_POST['product-content'];
	$price = $_POST['product-ap'];
	$rrp = $_POST['product-rrp'];
	$tags = $_POST['product-tags'];
	$path = $_POST['product-path'];
	$date = date ('Y-m-d H:i:s');

	if(empty($name))
	{
		formError("emptyname");
	}
	else if(empty($price))
	{
		formError('emptyprice');
	}
	else if(empty($category))
	{
		formError("emptycategory");
	}
	else if(empty($content))
	{
		formError("emptycontent");
	}
		else if(empty($tags))
	{
		formError("emptytags");
	}
		else if(empty($path))
	{
		formError("emptypath");
	}
	if(strpos($path, " ") !== false)
	{
		formError("pathcontainsspaces");
	}

	$sqlCheckname = "SELECT v_name FROM products WHERE v_name = '$name'";
	$queryCheckname = mysqli_query($con, $sqlCheckname);


	if(mysqli_num_rows($queryCheckname) > 0)
	{
		formError("nameinuse");
	}
		
	$filePath=$_FILES["product-main-image"]["name"];

	$mainImgURL = uploadImage($filePath, "product-main-image", "main", $name);

	$sqlAddproduct = "INSERT INTO products (v_name, n_category_id, v_description, f_price, f_rrp,
										  n_quantity,v_img, d_date_created) 
										  VALUES ('$name', '$category','$content',
												  $price, $rrp,'1','$mainImgURL','$date')";

	if(mysqli_query($con, $sqlAddproduct))
	{
		$productID = mysqli_insert_id($con);
		$sqlAddTags = "INSERT INTO product_tags (n_product_id, v_tag) VALUES ('$productID', '$tags')";
		if(mysqli_query($con, $sqlAddTags))
		{
			mysqli_close($con);

			unset($_SESSION['productName']);
			unset($_SESSION['productCategory']);
			unset($_SESSION['productContent']);
			unset($_SESSION['product-ap']);
			unset($_SESSION['product-rrp']);
			unset($_SESSION['productTags']);
			unset($_SESSION['productPath']);

			header("Location: ../products.php?addproduct=success");
			exit();
		}
		else
		{
			formError("sqlerror");
		}
	}
	else
	{
	formError("sqlerror");
	}

}
else 
{
	header("Location: index.php?page=admindex");
	exit();
}


function formError($errorCode)
{
	require "dbh.php";

	$_SESSION['productName'] = $_POST['product-name'];
	$_SESSION['productCategory'] = $_POST['product-category'];
	$_SESSION['price'] = $_POST['product-ap'];
	$_SESSION['productContent'] = $_POST['product-content'];
	$_SESSION['productTags'] = $_POST['product-tags'];
	$_SESSION['productPath'] = $_POST['product-path'];

	mysqli_close($con);

	//change to toast
	header("Location: ../add-a-product.php?addproduct=$errorCode");
	exit();
}

function uploadImage($path, $imgName, $imgType, $name)
{
	
	$imgURL = "";
	$validExtension = array('jpg', 'jpeg', 'png', 'gif', 'bmp');

	if($path == "")
	{
		formError("empty".$imgType."image");
	}
	else if($_FILES[$imgName]["size"] <= 0)
	{
		formError($imgType."imageError");
	}
	else
	{

		$extension = pathinfo($path, PATHINFO_EXTENSION);
		if(!in_array($extension, $validExtension))
		{
			formError("invalidType".$imgType."image");
		}

		$folder = "../assets/img/";
		$imgNewName = $name.'.'.$extension;
		$imgPath = $folder.$imgNewName;

		if(move_uploaded_file($_FILES[$imgName]['tmp_name'], $imgPath))
		{
			$imgURL = "http://localhost/JacobFarrow20007972/assets/img/".$imgNewName;
		}
		else
		{
			formError("Upload error -> ".$imgType." image");
		}
	}

	return $imgNewName;
}

?>
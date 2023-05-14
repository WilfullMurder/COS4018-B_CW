<?php

require "dbh.php";

if(isset($_POST['delete-product-btn']))
{
	$prodID = $_POST['product-id'];

	$sqlDeleteProductPost = "DELETE FROM products WHERE n_id = '$prodID'";
	$sqlDeleteProductTags = "DELETE FROM product_tags WHERE n_product_id ='$prodID'";
	
	//we could get rid of the tag checks and just run the query regardless
	$productTags = mysqli_query($con, $sqlDeleteProductTags);
	$deleteProduct = FALSE;

	if(!$productTags)
	{
		//there are no tags associated with this product, delete product regardless
		$deleteProduct = TRUE;
	}
	else if($productTags && mysqli_query($con, $sqlDeleteProductTags))
	{
			//there are tags and we have deleted them
			$deleteProduct = TRUE;
	}
	if($deleteProduct)
	{
		//no tags, or tags deleted so delete the product
		if(mysqli_query($con, $sqlDeleteProductPost))
		{
			//product deleted
			mysqli_close($con);
			header("Location: ../edit-products.php?deleteproduct=success");
			exit();
			
		}
		else
		{
			//sql_error
			mysqli_close($con);
			header("Location: ../edit-products.php?deleteproduct=error");
			exit();
		}
	}
	
}
else
{
	//btn not pressed
	header("Location: ../index.php?page=admindex");
	exit();
}



?>
<?php
	require "dbh.php";

	if(isset($_POST['delete-category-btn']))
	{
		$id = $_POST['category-id'];

		$sqlDeleteCategory = "DELETE FROM product_category WHERE n_category_id = '$id'";

		if(mysqli_query($con, $sqlDeleteCategory))
		{
			mysqli_close($con);
			header("Location: ../product-category.php?deletecategory=success");
			exit();
		}
		else
		{
			mysqli_close($con);
			header("Location: ../product-category.php?deletecategory=error");
			exit();
		}
	}
	else
	{
		header("Location: /index.php?page=admindex");
		exit();
	}


?>
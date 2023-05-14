<?php

	// database handler
	require "dbh.php";

	
	if(isset($_POST['add-category-btn']))
	{
		//btn press, get name and path (for when we want to sort items by category)
		$name = $_POST['category-name'];
		$categoryPath = $_POST['category-path'];
		$date = date ('Y-m-d H:i:s');

		//ready the query
		$sqlAddCategory= "INSERT INTO product_category (v_category_title, v_category_path, d_date_created) 
							VALUES ('$name', '$categoryPath', '$date')";

		if(mysqli_query($con, $sqlAddCategory))
		{
			//query success, category added
			mysqli_close($con);
			header("Location: ../product-category.php?addcategory=success");
			exit();
		}
		else
		{
			mysqli_close($con);
			header("Location: ../product-category.php?addcategory=error");
			exit();
		}
	
	}
	else 
	{
		header("Location: /index.php?page=admindex");
		exit();
	}


	?>
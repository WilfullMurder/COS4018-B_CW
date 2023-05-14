<?php
	require "dbh.php";

	if(isset($_POST['delete-user-btn']))
	{
		$id = $_POST['user-id'];

		$sqlDeleteuser = "DELETE FROM accounts WHERE n_id = '$id'";

		if(mysqli_query($con, $sqlDeleteuser))
		{
			mysqli_close($con);
			header("Location: ../edit-users.php?delete-user=success");
			exit();
		}
		else
		{
			mysqli_close($con);
			header("Location: ../edit-users.php?delete-user=error");
			exit();
		}
	}
	else
	{
		header("Location: /index.php?page=admindex");
		exit();
	}


?>
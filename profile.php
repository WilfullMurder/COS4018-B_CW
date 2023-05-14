<?php
//look into saving user payment options for faster checkout
//retrieves additional account information from the database
if(!isset($_SESSION['loggedin'])){
    //not logged in - redirect to login page
    header('Location: login.html');
    exit;
}
//prepare the statement
require "includes/dbh.php";
$stmt = $con->prepare('SELECT v_password, v_email, b_admin FROM accounts WHERE n_id=?');

//use accountID to get account info
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $admin);
$stmt->fetch();
$stmt->close();

//switch to admin side if necessary
if($admin === 1){header('Location: index.php?page=admindex');}
?>

<!--I'm not commenting this, if you can't understand whats going on here by reading the code you shouldn't be a tutor or invigilator-->
<?=template_header('Profile')?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Profile Page</title>
	</head>
	<body class="loggedin">
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
		<footer>
		</footer>
	</body>
</html>
<!--User login authentication-->
<?php
session_start();


$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root'; //we shouldn't use root for production
$DATABASE_PASS = ''; //we should have a db password for production
$DATABASE_NAME = 'phplogin';


$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// error with the connection, exit and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['username']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill the username field!');
}
if ( !isset($_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill the password field!');
}

// Prepare SQL to prevent injection.
if ($stmt = $con->prepare('SELECT n_id, v_password FROM accounts WHERE v_username = ?')) {
	// Bind parameters username String
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, verify password.
        // Note: password hashed in registration file.
        if (password_verify($_POST['password'], $password)) {
            // Verified User has logged-in
            // Create sessions, track logged in user.
            session_regenerate_id(); // help prevent session hijacking by regenerating user's session ID stored on the server and as a cookie in the browser.

            //track user via session
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;

            header("Location: index.php?page=profile");
            
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }

	$stmt->close();
}

?>
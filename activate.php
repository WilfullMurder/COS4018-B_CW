<?php
//vaguely working atm (see db phplogin->accounts->v_activation_code) - needs activation.php adding in, needs linking with actual domain and email for said domain
//for when we want to mess with user account activation via email
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if(isset($_GET['email'], $_GET['code'])){
    if($stmt = $con->prepare('SELECT * FROM accounts WHERE email=? AND activation_code = ?')){
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();

        $stmt->store_result();
        if($stmt->num_rows > 0)
        {
            //account exists with email & code
            if($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code=?')){
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                echo 'Your account is now activated. Please <a href="index.html>login</a>"';
            }
        }
        else{
            echo 'The account is already activated or doesn\'t exist!';
        }
    }
}

?>
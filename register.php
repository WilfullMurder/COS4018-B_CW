<?php

require "includes/dbh.php";

//basic validation (null/empty data)
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	exit('Please complete the registration form!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Please complete the registration form');
}

//further validate form data (data rules)
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    exit('A valid email address is required');
}
if(preg_match('/^[a-zA-Z0-9]+$/',$_POST['username'] == 0)){
    exit('Username must only contain alpha/numeric characters!');
}
if(strlen($_POST['password']) < 5 || strlen($_POST['password']) > 30){
    exit('Password must be between 5 and 30 characters');
}

//prepare statement
if($stmt=$con->prepare('SELECT n_id, v_password FROM accounts WHERE v_username = ?')){
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        echo 'Username already exists! Please choose a different username';
        //think about suggesting similar, available usernames
    }
    else{
        //insert new account, prepare SQL to prevent injection
        if($stmt = $con->prepare('INSERT INTO accounts (v_username, v_password, v_email, v_activation_code) VALUES (?,?,?,?)')){
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $uniqid = uniqid();
            $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
            $stmt->execute();
        }
        else{
            echo 'Could not prepare statement!';
        }
    }
    $stmt->close();
}
else{
    //something is wrong with the SQL, check the db and table!
    echo 'Could not prepare SQL statement!';
}
$con->close();

//redirect to login page
header('Location: login.html');
exit();

?>

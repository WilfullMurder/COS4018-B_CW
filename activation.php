<?php
//not working atm
//for when we want to mess with user account activation via email
            
$from = 'noreply@domain.com';
$subject='Account activtion required';
$headers = 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n".'X-Mailer: PHP/'.phpversion()."\r\n".'MIME-Version: 1.0'."\r\n".'Content-Type: text/html; charset=UTF-8'."\r\n";
$activate_link = 'http://localhost/JacobFarrow20007972/phplogin/activate.php?email='.$_POST['email'].'&code='.$uniqid;
$msg = '<p>Please click the following link to activate your account: <a href ="'.$activate_link.'">'.'Activate Account'.'</a></p>';
mail($_POST['email'], $subject, $msg, $headers);
echo 'Please check your email in order to activate your account';
?>
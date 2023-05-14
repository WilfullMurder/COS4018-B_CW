<!--if you can't understand whats going on here by reading the code you shouldn't be a tutor or invigilator-->
<?php
session_start();
//clear session data
setcookie(session_name(), '', 100);
session_unset();

//destroy remaining session data
session_destroy();
$_SESSION = array();

//redirect to home
header('Location: index.php?page=home');
exit;
?>


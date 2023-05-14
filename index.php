<!--default index page for page routing-->
<!--if you can't understand whats going on here by reading the code you shouldn't be a tutor or invigilator-->
<?php
session_start();
include 'functions.php';

$pdo = pdo_connect_mysql();

//basic routing

//page defaults home.php
$page = isset($_GET['page']) && file_exists($_GET['page'].'.php') ? $_GET['page']:'home';

//include and show requested page
include $page.'.php';


?>
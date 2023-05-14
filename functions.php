<!-- common functions -->

<?php
function pdo_connect_mysql(){
    //PDO Represents a connection between PHP and a database server
    //we can use it to abstract the data access, to issue queries and fetch data
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phplogin';

    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	exit('Failed to connect to database!');
    }
    $cart_items = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    
}

//Template header for user UI
function template_header($title){
    echo <<<EOT
    <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css?version=1" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
    <body>
    <header>
        <div class="content-wrapper">
            <!--home page redirect (change to about page? change to nav-dropdown?->move stuff into it?)-->
            <a href="index.php?page=home"><h1>Smart Life</h1></a>
            
            <!--navbar center links-->
            <nav>
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=products">Products</a>
            </nav>
            <!--navbar icon links-->
            <div class="link-icons">
                            <div class="input-group">
                                <form class="search-bar" method="POST" action="products.php" enctype="multipart/form-data">
                                <input type="text" placeholder="Search.." name="search">
                                <button type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                <div class="container">
                    <div class="row">
                        <a class="nav-top-user" href="index.php?page=cart">
                            <i class="fas fa-shopping-cart"></i>
                            <small class="nav-dash-small">cart</small>
                        </a>
                        <a class="nav-top-user" href="index.php?page=profile">
                            <i class="nav-top-icon fas fa-user "></i>
                            <small class="nav-dash-small">profile</small>
                        </a>
                        <a class="nav-top-user" href="index.php?page=logout">
                            <i class="fas fa-sign-out nav-top-icon"></i>
                            <small class="nav-dash-small" >sign out</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
EOT;

}

//Template footerfor user UI
//I'm not commenting this, if you can't understand whats going on here by reading the code you REALLY shouldn't be a tutor or invigilator
function template_footer() {
    $year = date('Y');
    echo <<<EOT
            </main>
            <footer>
                <div class="content-wrapper">
                    <p>&copy; $year, Smart Life</p>
                </div>
            </footer>
        </body>
    </html>
    EOT;
    }

?>
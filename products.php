<?php
include "includes/dbh.php";

$products_per_page = 4;
//Current page - URL appears: index.php?page=products&p=1, p=2, etc...
$current_page=isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

if(isset($_POST['search']))
{
    //pdo needs resetting and reconnecting
    
    if(!isset($pdo)){require "functions.php";$pdo=pdo_connect_mysql();}
    
    $keyWord = $_POST['search'];

    //check keyword length

    if(strlen($keyWord) <= 0){
        //no keyword, load default products page
        $stmt = $pdo->prepare('SELECT * FROM products ORDER BY d_date_created DESC LIMIT ?,?');
        $stmt->bindValue(1, ($current_page - 1) * $products_per_page, PDO::PARAM_INT);
        $stmt->bindValue(2, $products_per_page, PDO::PARAM_INT);
    }
    else{
        //keyword used

        //query for row num
        $result = mysqli_query($con, "SELECT * FROM products WHERE MATCH(v_name) AGAINST('$keyWord')");
        $products_per_page = mysqli_num_rows($result);

        //prepare statement and bind values to allow use of integer in statement for LIMIT clause
        $stmt = $pdo->prepare("SELECT * FROM products WHERE MATCH(v_name) AGAINST('$keyWord') ORDER BY d_date_created DESC LIMIT ?,?");
        $stmt->bindValue(1, ($current_page - 1) * $products_per_page, PDO::PARAM_INT);
        $stmt->bindValue(2, $products_per_page, PDO::PARAM_INT);
    }
}
else{
    //search not used, load default products page
    if(!isset($pdo)){$pdo=pdo_connect_mysql();}
    $stmt = $pdo->prepare('SELECT * FROM products ORDER BY d_date_created DESC LIMIT ?,?');
    $stmt->bindValue(1, ($current_page - 1) * $products_per_page, PDO::PARAM_INT);
    $stmt->bindValue(2, $products_per_page, PDO::PARAM_INT);
}


$stmt->execute();

//Fetch products from database, return result as Array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

//get product total
$total_products=$pdo->query('SELECT * FROM products')->rowCount();
?>

<?=template_header('Products')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?=$total_products?> Products</p>
    <div class="products-wrapper">
        <!--loop the list, get the product to show-->
        <?php foreach ($products as $product): ?>
            <!--link the product to it's own page-->
        <a href="index.php?page=product&id=<?=$product['n_id']?>" class="product">
            <!--get product info-->
            <img src="assets/img/<?=$product['v_img']?>" width="200" height="200" alt="<?=$product['v_name']?>">
            <span class="name"><?=$product['v_name']?></span>
            <span class="price">
                &dollar;<?=$product['f_price']?>
                <?php if ($product['f_rrp'] > 0): ?>
                <span class="rrp">&dollar;<?=$product['f_rrp']?></span>
                <?php endif; ?>
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    <!--add in paginated buttons (where appropriate)-->
    <div class="buttons">
        <?php if ($current_page > 1): ?>
        <a href="index.php?page=products&p=<?=$current_page-1?>">Prev</a>
        <?php endif; ?>
        <?php if ($total_products > ($current_page * $products_per_page) - $products_per_page + count($products)): ?>
        <a href="index.php?page=products&p=<?=$current_page+1?>">Next</a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
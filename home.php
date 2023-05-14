<?php

// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY d_date_created DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?=template_header('Home')?>

<div class="featured">
    <h2>Smart Life</h2>
    <p>Essential gadgets for everyday use</p>
</div>
<div class="recentlyadded content-wrapper">

    <h2>Recently Added Products</h2>
    <div class="products">
            <!--Loop the 4 most recently added products-->
        <?php foreach ($recently_added_products as $product): ?>
            <!--get product info-->
        <a href="index.php?page=product&id=<?=$product['n_id']?>" class="product">
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
</div>

<?=template_footer()?>
<?php
//fetch product from db
if(isset($_GET['id'])){
    $stmt = $pdo->prepare('SELECT * FROM products WHERE n_id = ?');
    $stmt->execute([$_GET['id']]);

    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product){
        exit('Product does not exist!');
    }
    
}else{
    exit('Product does not exist!');
}

?>
<?=template_header('Product')?>
<div class="product content-wrapper">
    <!--get product info-->
    <img src="assets/img/<?=$product['v_img']?>" width="500" height="500" alt="<?=$product['v_name']?> image">
    <div>
        <h1 class="name"><?=$product['v_name']?></h1>
        <span class="price">
            &dollar;<?=$product['f_price']?>
            <?php if ($product['f_rrp'] > 0): ?>
            <span class="rrp">&dollar;<?=$product['f_rrp']?></span>
            <?php endif; ?>
        </span>
        <!--add to cart stuff-->
        <form action="index.php?page=cart" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product['n_quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product['n_id']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$product['v_description']?>
        </div>
        <!-- for when we want to do sorting by cat, etc. -->
        <div class="category">
            <!-- <?=$product['n_category_id']?> -->
        </div>
    </div>
</div>

<?=template_footer()?>
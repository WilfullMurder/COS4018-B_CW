<?php

/*
add product to cart
*/
if(isset($_POST['product_id'], $_POST['quantity']) 
    && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])){

        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        //prepare check if product exists in database
        $stmt = $pdo->prepare('SELECT * FROM products WHERE n_id = ?');
        $stmt->execute([$_POST['product_id']]);

        //fetch product from db, return result array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if($product && $quantity > 0){
            //product found in db
            if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])){
                if(array_key_exists($product_id, $_SESSION['cart'])) {
                    //product in cart, update quantity
                    $_SESSION['cart'][$product_id] += $quantity;
                }
                else{
                    //product not in cart, add to cart.
                    $_SESSION['cart'][$product_id] = $quantity;
                }
            }
            else{
                //empty cart, add first product
                $_SESSION['cart'] = array($product_id => $quantity);
            }
        }
        // Prevent form resubmission
        header('Location: index.php?page=cart');
        exit;
}

/*
remove product from cart
*/
if(isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart'])
        && isset($_SESSION['cart'][$_GET['remove']])) {
            unset($_SESSION['cart'][$_GET['remove']]);
        }


/*
Update product quantities
*/
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop post data,update quantity for whole cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            //validate
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {

                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission
    header('location: index.php?page=cart');
    exit;
}

/*
Handle place order
*/
if(isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    header('Location: index.php?page=placeorder');
    exit;
}

/*
Read cart from DB
*/
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;

if($products_in_cart){
    //products in car, find in db, convert prod-in-car to String array (?,?,?...etc)
    $array_to_symbols = implode(',', array_fill(0, count($products_in_cart), '?'));

    $stmt = $pdo->prepare('SELECT * FROM products WHERE n_id IN ('.$array_to_symbols.')');
    //only need keys
    $stmt->execute(array_keys($products_in_cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //calculate subtotal
    foreach($products as $product){
        $subtotal += (float)$product['f_price'] * (int)$products_in_cart[$product['n_id']];
    }

}
?>

<?=template_header('Cart')?>
<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                
                <?php if (empty($products)): ?>
                <tr>
                    <!-- no products -->
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                    <!-- fetch products -->
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="index.php?page=product&id=<?=$product['n_id']?>">
                            <img src="assets/img/<?=$product['v_img']?>" width="50" height="50" alt="<?=$product['v_name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="index.php?page=product&id=<?=$product['n_id']?>"><?=$product['v_name']?></a>
                        <br>
                        <a href="index.php?page=cart&remove=<?=$product['n_id']?>" class="remove">Remove</a>
                    </td>
                    <td class="price">&dollar;<?=$product['f_price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['n_id']?>" value="<?=$products_in_cart[$product['n_id']]?>" min="1" max="<?=$product['n_quantity']?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?=$product['f_price'] * $products_in_cart[$product['n_id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>
<!--Needs payment options inserting between cart & placeorder-->

<!--if you can't understand whats going on here by reading the code you shouldn't be a tutor or invigilator-->
<?php
unset($_SESSION['cart'])
?>
<?=template_header('Place Order')?>

<div class="placeorder content-wrapper">
    <h1>Your Order Has Been Placed</h1>
    <p>Thank you for ordering with us! We'll contact you by email with your order details.</p>
</div>

<?=template_footer()?>
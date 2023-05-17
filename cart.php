<?php
session_start();

// Handle clear cart action
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    
    // Redirect back to the cart page or display a success message
    header("Location: cart.php");
    exit;
}

function calculateCartTotal($cart)
{
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'];
    }
    return $total;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Shopping Cart</h1>

    <?php if (empty($_SESSION['cart'])) : ?>
        <p>Your cart is empty.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $item) : ?>
                <li>
                    <?php echo $item['name']; ?> - $<?php echo $item['price']; ?>
                    <a href="index.php?remove_from_cart=<?php echo $item['id']; ?>">Remove</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <p>Total: $<?php echo calculateCartTotal($_SESSION['cart']); ?></p>

        <form method="POST" action="cart.php">
            <button type="submit" name="clear_cart">Clear Cart</button>
        </form>

        <form method="POST" action="checkout.php">
            <button type="submit">Checkout</button>
        </form>
    <?php endif; ?>
</body>
</html>

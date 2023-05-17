<?php
session_start();

// Check if the cart array exists in the session, initialize it if not
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle add to cart action
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    
    // Add the product to the cart array
    $_SESSION['cart'][] = [
        'id' => $product_id,
        'name' => $product_name,
        'price' => $product_price
    ];
    
    // Redirect back to the product listing page or display a success message
    header("Location: index.php");
    exit;
}

// Handle remove from cart action
if (isset($_GET['remove_from_cart'])) {
    $product_id = $_GET['remove_from_cart'];
    
    // Loop through the cart and remove the item with the matching product ID
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] === $product_id) {
            unset($_SESSION['cart'][$index]);
            break;
        }
    }
    
    // Redirect back to the cart page or display a success message
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Webshop</title>
</head>
<body>
    <h1>Webshop</h1>

    <!-- Product Listing -->
    <h2>Products</h2>
    <ul>
        <li>
            <span>Product A</span>
            <form method="POST" action="index.php">
                <input type="hidden" name="product_id" value="1">
                <input type="hidden" name="product_name" value="Product A">
                <input type="hidden" name="product_price" value="10.99">
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </li>
        <li>
            <span>Product B</span>
            <form method="POST" action="index.php">
                <input type="hidden" name="product_id" value="2">
                <input type="hidden" name="product_name" value="Product B">
                <input type="hidden" name="product_price" value="19.99">
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </li>
        <!-- Add more products as needed -->
    </ul>

    <!-- Cart -->
    <h2>Shopping Cart</h2>
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
    <?php endif; ?>

    <p>
        Total: $<?php echo calculateCartTotal($_SESSION['cart']); ?>
        <a href="cart.php">View Cart</a>
    </p>
</body>
</html>

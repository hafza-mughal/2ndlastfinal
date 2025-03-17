<?php
session_start();
include ("include/header.php");
include ("include/connection.php");
include ("include/footer.php");

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'price' => floatval($_POST['price']),
        'image' => $_POST['image'],
        'quantity' => 1
    ];

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product['id']) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $product;
    }

    echo json_encode(['status' => 'success']);
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $itemId = $_POST['id'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($itemId) {
        return $item['id'] !== $itemId;
    });
    header("Location: cart.php"); // Redirect to refresh cart
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $itemId = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $itemId) {
            $item['quantity'] = max(1, $quantity); // Prevent zero quantity
            break;
        }
    }
    header("Location: cart.php"); // Redirect to refresh cart
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to external CSS file -->
    <style>body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.cart-container {
    width: 80%;
    margin: 20px auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

.empty-cart {
    text-align: center;
    padding: 20px;
}

.shop-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.cart-table th, .cart-table td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.product-image {
    width: 50px;
    height: auto;
}

input[type="number"] {
    width: 60px;
    padding: 5px;
    text-align: center;
}

.remove-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 16px;
}

.total-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background-color: #f8f9fa;
    border-top: 1px solid #ddd;
    margin-top: 20px;
}

.checkout-btn {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}</style>
</head>
<body>
    <div class="cart-container">
        <h1>Your Cart</h1>
        <?php if (empty($_SESSION['cart'])): ?>
            <div class="empty-cart">
                <h2>Your cart is empty</h2>
                <a href="index.php" class="shop-btn">Continue Shopping</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td><img src="seller_panel/uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="product-image"></td>
                            <td><?php echo $item['name']; ?></td>
                            <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="updateQuantity(event, '<?php echo $item['id']; ?>')">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="update_quantity" value="1">
                                    <button type="submit" style="display: none;"></button> <!-- Hidden submit button -->
                                </form>
                            </td>
                            <td>Rs. <?php echo number_format((float) ($item['price'] * $item['quantity']), 2); ?></td>

                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="remove" class="remove-btn">&#128465;</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total-box">
                <strong>Total: Rs. <?php echo number_format($total, 2); ?> PKR</strong>
                <a href="checkout.php" class="checkout-btn">Place Order</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Function to update quantity dynamically
        function updateQuantity(event, itemId) {
            event.preventDefault(); // Prevent form submission
            const form = event.target;
            const quantity = form.querySelector('input[name="quantity"]').value;

            // Send an AJAX request to update the quantity
            fetch('', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `update_quantity=1&id=${itemId}&quantity=${quantity}`,
            }).then(() => {
                location.reload(); // Reload the page to reflect the updated total price
            });
        }
    </script>
</body>
</html>
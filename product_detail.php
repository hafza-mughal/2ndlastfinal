<?php
include ("include/header.php");
include ("include/connection.php");
include ("include/footer.php");

// Get product ID from URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $product = mysqli_fetch_assoc($result);
    if (!$product) {
        die("Product not found!");
    }
} else {
    die("Invalid product ID!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <style>/* General Body Styling */


body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Product Detail Container */
        .product-detail-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Product Image Section */
        .product-image {
            flex: 1;
            text-align: center;
            padding: 20px;
        }

        .product-image img {
            width:300px;
            height: 400px;
            border-radius: 10px;
        }

        /* Product Info Section */
        .product-information {
            flex: 1;
            padding:20px ;
            height:400px
        }

        .product-information h2 {
            font-size: 30px;
            font-weight: bold;
            margin-top: 40px;
        }

        .product-information p {
            font-size: 18px;
            color: #555;
            margin-top: 50px;
        }

        /* Pricing Style */
        .price {
            font-size: 24px;
         
            margin-top:60px;
           
        }

        .price del {
            color: black;
            font-size: 18px;
            margin-top: 60px;
            font-weight: bold;
        }

        .sale {
            color:rgb(0, 0, 0);
            font-size: 22px;
            
        }

        /* Buttons */
        .add-to-cart-btn {
            width: 38%;
            padding: 12px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top:70px;
        }
        .buy-now {
            width: 38%;
            padding: 12px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
           
        }

        .add-to-cart-btn {
            background:rgb(0, 0, 0);
            color: white;
        }

        .buy-now {
            background:rgb(0, 0, 0);
            color: white;
        }

        .add-to-cart-btn:hover {
            background:rgb(37, 37, 36);
        }

        .buy-now:hover {
            background: rgb(37, 37, 36);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-detail-container {
                flex-direction: column;
            }

            .product-image img {
                max-height: 300px;
            }

            .product-info {
                text-align: center;
            }

            .add-to-cart, .buy-now {
                width: 100%;
            }
        }

     
</style>
</head>
<body>

<script>function addToCart(productId) {
    // AJAX request to add product to cart
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Show cart alert
            document.getElementById("cart-alert").style.display = "block";
        }
    };
    
    xhr.send("id=" + productId);
}

function buyNow(productId) {
    window.location.href = "checkout.php?id=" + productId;
}
</script>
    <div class="product-detail-container">
        <div class="product-image">
            <img src="seller_panel/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        </div>
        <div class="product-information">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            
            <?php if ($product['discount'] > 0): ?>
                <p class="price"><del>$<?php echo $product['price']; ?></del> <span class="sale">$<?php echo $product['price']; ?></span></p>
            <?php else: ?>
                <p class="price">$<?php echo $product['price']; ?></p>
            <?php endif; ?>
            
            <button class="add-to-cart-btn" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
            <button class="buy-now" onclick="buyNow(<?php echo $product['id']; ?>)">Buy Now</button>
        </div>
    </div>



    <h1 class="productH1">related products</h1>
<div class="product-container">

    <?php
    // Fetch products from database
   
    $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 4";
    $result = $connection->query($sql);
    
    while ($row = $result->fetch_assoc()): ?>
        <div class="product-card">
            <div class="image-container">
                <img src="seller_panel/uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                     alt="<?php echo htmlspecialchars($row['name']); ?>">

                <button class="add-to-cart" 
                        data-id="<?php echo htmlspecialchars($row['id']); ?>" 
                        data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                        data-price="<?php echo htmlspecialchars($row['price']); ?>" 
                        data-image="<?php echo htmlspecialchars($row['image']); ?>">
                    Add to Cart
                </button>
            </div>
            <div class="product-info">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p class="description"><?php echo htmlspecialchars($row['description']); ?></p> <!-- ✅ Added Description -->
                <p><strong>Price:</strong> $<?php echo number_format($row['price'], 2); ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function() {
            let productId = this.getAttribute("data-id");
            let productName = this.getAttribute("data-name");
            let productPrice = this.getAttribute("data-price");
            let productImage = this.getAttribute("data-image");

            let formData = new FormData();
            formData.append("add_to_cart", true);
            formData.append("id", productId);
            formData.append("name", productName);
            formData.append("price", productPrice);
            formData.append("image", productImage);

            fetch("add_to_cart.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("Your product has been successfully added to the cart!");
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>

    
    <div id="cart-alert">
        <p>Product added to cart!</p>
        <button onclick="window.location.href='cart.php'">View Cart</button>
        <button onclick="window.location.href='checkout.php'">Checkout</button>
    </div>
</body>
</html>

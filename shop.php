<?php
include ("include/header.php");
include ("include/connection.php"); // Connection already included
include ("include/footer.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Card</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
       body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            flex-wrap: wrap;
        }
        .product-card {
            width: 250px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 380px;
            margin: 10px;
        }
        .image-container {
            position: relative;
            width: 100%;
            height: 250px;
            overflow: hidden;
        }
        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease-in-out;
        }
        .product-card:hover img {
            transform: scale(1.1);
        }
        .sale-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: orange;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 5px;
            z-index: 10;
        }
        .product-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .product-price {
            color: green;
            font-size: 18px;
            font-weight: bold;
        }
        .original-price {
            text-decoration: line-through;
            color: gray;
            font-size: 14px;
            margin-left: 5px;
        }
        .buttons {
            display: flex;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            border-top: 1px solid #ddd;
        }
        .buttons a {
            flex: 1;
            text-decoration: none;
            color: #333;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: color 0.3s ease-in-out;
        }
        .buttons a i {
            margin-right: 5px;
            color:black;
        }
        .buttons a:not(:last-child) {
            border-right: 1px solid #ddd;
        }
        .buttons a:hover {
            color: #000;
        }
    </style>
    
    <script>
        function addToCart(id, name, image, price) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "add_to_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert(name + " has been added to your cart!"); // Show success alert
                }
            };

            let data = "add_to_cart=1&id=" + id + "&name=" + encodeURIComponent(name) + "&image=" + encodeURIComponent(image) + "&price=" + price;
            xhr.send(data);
        }
    </script>

</head>
<body>

<?php
// Query Execute Karna (Tumhara connection include ho chuka hai)
$sql = "SELECT * FROM products";
$result = mysqli_query($connection, $sql); // Ensure karo ke `$conn` define hai

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product-card">';
        echo '<div class="image-container">';
        if (!empty($row['discount']) && $row['price'] > $row['discount']) {
            $discount = round((($row['price'] - $row['discount']) / $row['price']) * 100);
            echo '<span class="sale-badge">' . $discount . '% OFF</span>';
        }
        echo '<img src="seller_panel/uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';

        echo '</div>';
        echo '<div class="product-title">' . $row['name'] . '</div>';
        echo '<div>';
        $finalPrice = (!empty($row['discount']) && $row['price'] > $row['discount']) ? $row['discount'] : $row['price'];
        echo '<span class="product-price">$' . $finalPrice . '</span>';
        if (!empty($row['discount']) && $row['price'] > $row['discount']) {
            echo '<span class="original-price">$' . $row['price'] . '</span>';
        }
        echo '</div>';
        echo '<div class="buttons">';
        echo '<a href="product_detail.php?id=' . $row['id'] . '" class="view-detail"><i class="fas fa-eye"></i> View Detail</a>';
        echo '<a href="#" class="add-to-cart_btn" onclick="addToCart(' . $row['id'] . ', \'' . addslashes($row['name']) . '\', \'' . addslashes($row['image']) . '\', ' . $finalPrice . ')"><i class="fas fa-shopping-cart"></i> Add to Cart</a>';
        echo '</div></div>';
    }
} else {
    echo "<p style='text-align:center; font-size:20px; color:red;'>No products found.</p>";
}
?>

</body>
</html>

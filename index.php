<?php
include ("include/header.php");
include ("include/connection.php");
include ("include/footer.php");
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="images/logo.png" alt="Logo">
                <span class="ms-2 fw-bold">Artify</span>
            </a>
            <div class="d-flex gap-3 nav-icons d-lg-none">
                <i class="fas fa-search"></i>
                <i class="fas fa-shopping-cart"></i>
                <i class="fas fa-user"></i>
            </div>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#home">Gallery</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#shop" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#electronics">Electronics</a></li>
                            <li><a class="dropdown-item" href="#fashion">Fashion</a></li>
                            <li><a class="dropdown-item" href="#beauty">Beauty</a></li>
                            <li><a class="dropdown-item" href="#home-appliances">Home Appliances</a></li>
                            <li><a class="dropdown-item" href="#sports">Sports</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#home">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#home">Contact</a></li>
                </ul>
            </div>
            <div class="d-flex gap-3 nav-icons d-none d-lg-flex">
                <i class="fas fa-search"></i>
                <li class="nav-item">
						<a class="nav-link p-0" href="add_to_cart.php"><i class="fa-solid fa-cart-shopping" style="color: #000000; font-size: 1.5rem;"></i></a>
					</li>
                <i class="fas fa-user"></i>
            </div>
        </div>
    </nav>
    
    <section class="hero">
        <video class="background-video" autoplay muted loop>
            <source src="images/video.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="hero-text">
            <h1>Discover the Best Shopping Experience</h1>
            <p>Shop your favorite products at unbeatable prices with fast delivery.</p>
            <a href="#shop" class="btn">Start Shopping</a>
        </div>
        <div class="hero-image">
            <img src="images/hero-right-img.png" alt="Shopping Illustration">
        </div>
    </section>

				<!-- catagory -->

				<section class="category-section">
					<div class="section-header">
					<h1 class="productH1">Category</h1>
						<div class="swiper-buttons">
							<a href="#" class="btn btn-primary">View All</a>
							<button class="swiper-button-prev">❮</button>
							<button class="swiper-button-next">❯</button>
						</div>
					</div>
					<div class="swiper-container category-slider">
						<div class="swiper-wrapper">
                                  

							<div class="swiper-slide">
								<img src="images/perfume3.webp" alt="Meat Products">
								<h4 class="category-title">Wall Art</h4>
							</div>



							<div class="swiper-slide">
								<img src="images/handbags3.webp" alt="Fruits & Veges">
								<h4 class="category-title">Hand Bag</h4>
							</div>
							<div class="swiper-slide">
								<img src="images/watch.jpg" alt="Breads & Sweets">
								<h4 class="category-title">Men's Wallet</h4>
							</div>
							<div class="swiper-slide">
								<img src="images/perfume3.webp" alt="Fruits & Veges">
								<h4 class="category-title">Perfume</h4>
							</div>
							<div class="swiper-slide">
								<img src="images/doll3.webp" alt="Beverages">
								<h4 class="category-title">Dolls</h4>
							</div>
							<div class="swiper-slide">
								<img src="images/watch.jpg" alt="Meat Products">
								<h4 class="category-title">Watch</h4>
							</div>

							<div class="swiper-slide">
								<img src="images/greeting card.jpg" alt="Meat Products">
								<h4 class="category-title">Greeting Cards</h4>
							</div>

							<div class="swiper-slide">
								<img src="images/beauty2.webp" alt="Meat Products">
								<h4 class="category-title">Beauty Products</h4>
							</div>
						</div>
					</div>
				</section>

				<script>
					var swiper = new Swiper('.category-slider', {
						slidesPerView: 4,
						spaceBetween: 20,
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev',
						},
						loop: true,
						autoplay: {
							delay: 3000,
							disableOnInteraction: false,
						},
						breakpoints: {
							320: { slidesPerView: 1 },
							480: { slidesPerView: 2 },
							768: { slidesPerView: 3 },
							1024: { slidesPerView: 4 }
						}
					});
				</script>
				<!-- End-catagory -->
</body>
</html>

<h1 class="productH1">Latest Products</h1>

<?php
$sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 4";
$result = $connection->query($sql);
?>

<div class="product-container1">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="column2">
            <img src="seller_panel/uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                 alt="<?php echo htmlspecialchars($row['name']); ?>">

            <div class="layer">
                <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="explore-btn">Explore More</a>
            </div>
        </div>
    <?php endwhile; ?>
</div>




<style>.product-container1 {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important; /* Center align */
            gap: 20px !important; /* Cards کے درمیان gap */
            padding: 20px !important; /* Outer padding for spacing */
        }
        
        .column2 {
            width: 20% !important;
            height: 350px !important;
            border-radius: 10px !important;
            margin-bottom: 30px !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .column2 img {
            width: 100% !important;
            height: 100% !important;
            display: block !important;
        }
        .layer {
          background: transparent !important;
          height: 100% !important;
          width: 100% !important;
          position: absolute !important;
          top: 0 !important;
          left: 0 !important;
          transition: background 0.4s ease-in-out !important;
          display: flex !important;
          justify-content: center !important;
          align-items: flex-end !important; /* Align to bottom */
          padding-bottom: 150px !important; /* Space at bottom */
        }
        
        .layer:hover {
          background: rgba(39, 37, 37, 0.7) !important;
        }
        
        .explore-btn {
          text-decoration: none !important;
          background: #ffffff !important;
          color: rgb(0, 0, 0) !important;
          padding: 10px 20px !important;
          border-radius: 5px !important;
          font-weight: bold !important;
          opacity: 0 !important;
          transform: translateY(90px) !important; /* Initially lower */
          transition: opacity 0.5s ease-out, transform 0.5s ease-out !important;
        }
        
        .layer:hover .explore-btn {
          opacity: 1 !important;
          transform: translateY(0) !important; /* Move up on hover */
        }






        
        </style>










<h1 class="productH1">Latest products</h1>
<div class="product-container">

    <?php
    // Fetch products from database
    $sql = "SELECT * FROM products";
    $result = $connection->query($sql); 
    while ($row = $result->fetch_assoc()): ?>
        <div class="product-card">
            <div class="image-container">
                <img src="seller_panel/uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                     alt="<?php echo htmlspecialchars($row['name']); ?>">

                     <button class="add-to-cart-btn" 
    data-id="<?php echo $product['id']; ?>" 
    data-name="<?php echo $product['name']; ?>" 
    data-price="<?php echo $product['price']; ?>" 
    data-image="<?php echo $product['image']; ?>">
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

<?php
// File: product.php
// Author: Gabriel Sullivan
// Purpose: Product template page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

function show404()
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php';
    http_response_code(404);
    exit();
}

$category_slug = isset($_GET['category_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['category_slug']) : '';
$product_slug = isset($_GET['product_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['product_slug']) : '';

if (!$category_slug || !$product_slug) {
    show404();
}

try {
    $product_data = $conn->fetchAll("SELECT p.id, p.name, p.description, p.meta_description, p.tags, p.price, p.terms, p.preview_image_ids, c.name AS category FROM products AS p JOIN shop_categories AS c ON c.slug = ? AND p.slug = ? AND p.category = c.name WHERE p.public = 1 LIMIT 1", [$category_slug, $product_slug]);

    if (!empty($product_data)) {
        $product = $product_data[0];
    } else {
        show404();
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    show404();
}

// Fetch image details if there are any image IDs
$image_data = [];
if (!empty($product['preview_image_ids'])) {
    $image_ids = explode(',', $product['preview_image_ids']);
    foreach ($image_ids as $image_id) {
        $image_id = trim($image_id);
        $fetched_image = $conn->fetchAll("SELECT image_url, caption, credit, credit_url, alttext, public FROM images WHERE id = ? AND public = 1 LIMIT 1", [$image_id]);
        if (!empty($fetched_image)) {
            $image_data[] = $fetched_image[0]; // Append the image to the array
        }
    }
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        $product['name'],
        $product['meta_description'],
        !empty($image_data) ? $image_data[0]['image_url'] : 'https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg',
        SITE_URL . "/shop/product/{$category_slug}/{$product_slug}",
        SITE_NAME
    );
    $pageMeta->render();
    ?>
</head>

<body>
    <?php
    require_once CONSENT_BANNER_PATH;
    require_once NAVBAR_PATH;
    ?>
    <main class="main-page">
        <div class="product-info">
            <section class="carousel">
                <div class="carousel-images">
                    <?php foreach ($image_data as $image) : ?>
                        <div class="carousel-image">
                            <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="<?php echo htmlspecialchars($image['alttext']); ?>">
                            <?php if (!empty($image['caption'])) : ?>
                                <p class="caption"><?php echo htmlspecialchars($image['caption']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($image['credit'])) : ?>
                                <p class="credit">
                                    Credit: <a href="<?php echo htmlspecialchars($image['credit_url']); ?>" target="_blank">
                                        <?php echo htmlspecialchars($image['credit']); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-nav prev" onclick="prevSlide()">&#10094;</button>
                <button class="carousel-nav next" onclick="nextSlide()">&#10095;</button>
            </section>

            <section class="product-action">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-price">$<?php echo number_format($product['price'], 2); ?> each</p>
                <div class="atc-section">
                    <div class="atc-quantity-section">
                        <label class="atc-quantity-label" for="quantity">Quantity:</label>
                        <input class="atc-quantity-selector" type="number" id="quantity" name="quantity" value="1" min="1">
                    </div>

                    <button class="add-to-cart-button" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                </div>

                <hr class="small-hr-separator" />

                <a href="https://www.blueskyhomesteading.com/shop/checkout?product_id=<?php echo $product['id']; ?>" class="buy-now-button">Buy Now</a>
                <p class="button-footnote">* This will bring you straight to checkout.</p>
                <p class="button-footnote">* Checkout is handled by Stripe.</p>
                <?php echo $product['description']; ?>
            </section>
        </div>
    </main>

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-image');
        const prevButton = document.querySelector('.carousel-nav.prev');
        const nextButton = document.querySelector('.carousel-nav.next');

        function updateCarousel() {
            const totalSlides = slides.length;
            const offset = -currentSlide * 100;
            document.querySelector('.carousel-images').style.transform = `translateX(${offset}%)`;

            // Hide navigation buttons if there's only one image
            prevButton.disabled = totalSlides <= 1 || currentSlide === 0;
            nextButton.disabled = totalSlides <= 1 || currentSlide === totalSlides - 1;
        }

        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        }

        function nextSlide() {
            if (currentSlide < slides.length - 1) {
                currentSlide++;
                updateCarousel();
            }
        }

        // Initialize carousel
        updateCarousel();

        function addToCart(productId) {
            const quantity = document.getElementById('quantity').value || 1;
            fetch('https://www.blueskyhomesteading.com/shop/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'product_id': productId,
                        'quantity': quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    window.location.href = "https://www.blueskyhomesteading.com/shop/cart"; // Redirects to Google
                })
                .catch(error => alert('An error occurred.'));
        }
    </script>

    <?php require_once FOOTER_PATH; ?>
</body>

</html>
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

function fetch_product($conn, $category_slug, $product_slug)
{
    $product_data = $conn->fetchAll(
        "SELECT p.id, p.name, p.description, p.meta_description, p.tags, p.price, p.terms, p.preview_image_ids, c.name AS category
         FROM products AS p
         JOIN shop_categories AS c ON p.category = c.name
         WHERE c.slug = ? AND p.slug = ? AND p.public = 1
         LIMIT 1",
        [$category_slug, $product_slug]
    );

    if (empty($product_data[0])) show404();

    return $product_data[0]; // set the product to the first product
}

function fetch_images($conn, $image_ids)
{
    $image_data = [];
    // loop through them
    foreach ($image_ids as $image_id) {
        $image_id = trim($image_id); // clean up the id
        $fetched_image = new Image($conn); // create the image object
        $fetched_image->fetchImage($image_id); // fetch the image details
        // check if exists
        if ($fetched_image->url) {
            $image_data[] = $fetched_image; // Append the image to the array
        }
    }

    return $image_data;
}

function fetch_options($conn, $product_id)
{
    $options = $conn->fetchAll("SELECT id, name FROM product_options WHERE product_id = ?", [$product_id]);
    return $options;
}

function fetch_choices($conn, $options)
{
    $choices = [];
    foreach ($options as $option) {
        $choices_data = $conn->fetchAll("SELECT id, name FROM product_options_choices WHERE option_id = ?", [$option['id']]);
        // Ensure each option is mapped to its choices
        $choices[$option['id']] = $choices_data;
    }
    return $choices;
}


$category_slug = isset($_GET['category_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['category_slug']) : ''; // sanitize/get the category slug
$product_slug = isset($_GET['product_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['product_slug']) : ''; // sanitize/get the product slug

if (!$category_slug || !$product_slug) show404(); // Check if the category and product slugs are empty

// fetch the product
$product = fetch_product($conn, $category_slug, $product_slug);
if (!$product) show404();

// fetch the options
$options = fetch_options($conn, $product['id']);

// fetch the options
$choices = fetch_choices($conn, $options);

// check if there even are any images to fetch
if (!empty($product['preview_image_ids'])) {
    // separate out the image ids
    $image_ids = explode(',', $product['preview_image_ids']);

    // Fetch image details if there are any image IDs
    $image_data = fetch_images($conn, $image_ids);
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
        !empty($image_data) ? $image_data[0]->url : 'https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg',
        SITE_URL . "/shop/{$category_slug}/{$product_slug}",
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
                            <img src="<?php echo htmlspecialchars($image->url); ?>" alt="<?php echo htmlspecialchars($image->alttext); ?>">
                            <?php if (!empty($image->caption)) : ?>
                                <p class="caption"><?php echo htmlspecialchars($image->caption); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($image->credit)) : ?>
                                <p class="credit">
                                    Credit: <a href="<?php echo htmlspecialchars($image->credit_url); ?>" target="_blank">
                                        <?php echo htmlspecialchars($image->credit); ?>
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
                    <?php
                    // Render tile-based options
                    foreach ($options as $option) {
                        echo "<div class='atc-option-section'>";
                        echo "<label class='atc-option-label' data-name='{$option['name']}'>{$option['name']}:</label>";
                        echo "<div class='atc-tile-container' data-option-id='{$option['id']}'>";

                        // Render each selection choice as a tile
                        if (!empty($choices[$option['id']])) {
                            foreach ($choices[$option['id']] as $index => $choice) {
                                $checked = ($index === 0) ? 'checked' : ''; // Automatically check the first choice
                                echo "<label class='atc-tile-option'>";
                                echo "<input type='radio' name='{$option['name']}' value='{$choice['id']}' $checked>";
                                echo htmlspecialchars($choice['name']);
                                echo "</label>";
                            }
                        }

                        echo "</div>";
                        echo "</div>";
                    }
                    ?>

                    <div class="atc-quantity-section">
                        <label class="atc-quantity-label">Quantity:</label>
                        <div class="quantity-container">
                            <button class="quantity-btn minus">-</button>
                            <input type="number" class="quantity-input" value="1" min="1" max="99">
                            <button class="quantity-btn plus">+</button>
                        </div>
                    </div>

                    <button class="add-to-cart-button" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                </div>
                <?php
                // render out the terms and conditions
                echo $product['terms'];
                // render out the description
                echo $product['description'];
                ?>
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

        // Tile Selection Script
        document.querySelectorAll('.atc-tile-container').forEach(container => {
            container.addEventListener('click', function(e) {
                const clickedTile = e.target.closest('.atc-tile-option');
                if (!clickedTile) return;

                // Remove 'selected' class from all tiles in this container
                container.querySelectorAll('.atc-tile-option').forEach(tile => {
                    tile.classList.remove('selected');
                });

                // Add 'selected' class to clicked tile
                clickedTile.classList.add('selected');

                // Check the radio button
                const radio = clickedTile.querySelector('input');
                radio.checked = true;
            });
        });

        // Enhanced Quantity Selector Script
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.atc-tile-container').forEach(container => {
                const checked = container.querySelector('input:checked');
                if (checked) {
                    checked.closest('.atc-tile-option').classList.add('selected');
                }
            });

            const quantityInput = document.querySelector('.quantity-input');
            const minusBtn = document.querySelector('.minus');
            const plusBtn = document.querySelector('.plus');

            minusBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            plusBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < 99) {
                    quantityInput.value = currentValue + 1;
                }
            });

            // Input validation
            quantityInput.addEventListener('change', () => {
                let value = parseInt(quantityInput.value);
                if (isNaN(value) || value < 1) {
                    quantityInput.value = 1;
                } else if (value > 99) {
                    quantityInput.value = 99;
                }
            });
        });

        function addToCart(productId) {
            const quantity = document.querySelector('.quantity-input').value || 1;
            const optionContainers = document.querySelectorAll('.atc-tile-container');
            const selectedOptions = {};

            // Validation: ensure each option group has a selected input
            for (const container of optionContainers) {
                const checked = container.querySelector('input:checked');
                const optionLabel = container.previousElementSibling;
                const optionName = optionLabel.dataset.name;

                if (!checked) {
                    alert(`Please select a choice for "${optionName}".`);
                    return; // Stop if any required option is not selected
                }

                selectedOptions[optionName] = checked.value;
            }

            fetch('https://www.blueskyhomesteading.com/shop/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'product_id': productId,
                        'quantity': quantity,
                        'options': JSON.stringify(selectedOptions)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    window.location.href = "https://www.blueskyhomesteading.com/shop/cart";
                })
                .catch(error => alert('An error occurred.'));
        }
    </script>

    <?php require_once FOOTER_PATH; ?>
</body>

</html>
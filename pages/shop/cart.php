<?php
// File: cart.php
// Author: Gabriel Sullivan
// Purpose: Cart page for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';
require_once INCLUDES_PATH . 'shop_databaseconnection.php';

$status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 0, 'max_range' => 1]]);
$cart_items = [];

try {
    // Retrieve cart items
    $cart_result = $shop_conn->fetchAll("SELECT product_id, quantity FROM cart WHERE session_id = ?", [$session_id]);

    foreach ($cart_result as $cart_item) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];

        // Retrieve product details
        $product_result = $conn->fetchAll("SELECT name, price, category, slug FROM products WHERE id = ? LIMIT 1", [$product_id]);

        $product = $product_result[0];
        $cart_items[] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'category' => $product['category'],
            'slug' => $product['slug']
        ];
    }
} catch (Exception $e) {
    error_log($e->getMessage());
}

$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        "Your Cart - " . SITE_NAME,
        "Your shopping cart.",
        "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg",
        SITE_URL . "/shop/cart",
        SITE_NAME
    );
    $pageMeta->render();
    ?>
</head>

</head>

<body>
    <?php
    require_once CONSENT_BANNER_PATH;
    require_once NAVBAR_PATH;
    ?>
    <div class="cart-page">
        <?php
        // Check if the status indicates a failure (1) or success (0)
        if ($status === 1) {
            // Failure case
            // Implement failure handling logic here
            echo '<p class="error-message">Your transaction could not be completed. Please try again. For help, please <a href="https://www.blueskyhomesteading.com/contact">contact us.</a></p>';
        } else {
            // Success case
        }

        ?>

        <h1>Your Cart</h1>
        <div id="cart-content" class="cart-content">
            <?php if (empty($cart_items)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <div class="items-list">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item" data-item-id="<?php echo $item['id']; ?>">
                            <?php
                            $item_product = $conn->fetchAll("SELECT slug FROM shop_categories WHERE public = 1 AND name = ?", [$item['category']]);
                            ?>
                            <a href="https://www.blueskyhomesteading.com/shop/<?php echo $item_product['slug'] . "/";
                                                                                echo $item['slug']; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
                            <input type="number" class="item-quantity" data-item-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                            <span id="item-price-<?php echo $item['id']; ?>">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            <button onclick="removeItem(<?php echo $item['id']; ?>)"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#d81a1a" style="vertical-align: middle;">
                                    <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z" />
                                </svg><span>Remove</span></button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="total-section">
                    <p class="total-price">Total: $<?php echo number_format($total_price, 2); ?></p>
                    <a href="https://www.blueskyhomesteading.com/shop/checkout" class="checkout-button" id="checkout-button">Checkout</a>
                    <p class="small-note">Payment is securely handled by Stripe. Your satisfaction is our highest priority. Read about our <a href="https://www.blueskyhomesteading.com/refunds">refunds and returns policy.</a></p>
                </div>
            <?php endif; ?>

        </div>

        <p class="button-footnote">* Checkout is handled by Stripe.</p>
    </div>

    <?php
    $conn->close();
    ?>

    <script>
        function updateTotalPrice() {
            const items = document.querySelectorAll('.cart-item');
            const itemData = [];

            items.forEach(item => {
                const itemId = item.dataset.itemId;
                const quantity = document.querySelector(`.item-quantity[data-item-id="${itemId}"]`).value;
                itemData.push({
                    id: itemId,
                    quantity: quantity
                });
            });

            fetch('https://www.blueskyhomesteading.com/shop/calculate-total', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'item_data': JSON.stringify(itemData)
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.total-price').textContent = `Total: $${data.totalPrice}`;
                });
        }

        document.querySelectorAll('.item-quantity').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.itemId;
                const quantity = this.value;

                fetch('https://www.blueskyhomesteading.com/shop/update-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'item_id': itemId,
                            'quantity': quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`#item-price-${itemId}`).textContent = `$${data.itemTotalPrice}`;
                            document.querySelector('.total-price').textContent = `Total: $${data.totalPrice}`;
                        } else {
                            alert(data.message);
                        }
                    });
            });
        });

        function removeItem(itemId) {
            fetch('https://www.blueskyhomesteading.com/shop/remove-from-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'item_id': itemId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const itemElement = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                        itemElement.remove();

                        // Check if the cart is empty
                        const cartItems = document.querySelectorAll('.cart-item');
                        if (cartItems.length === 0) {
                            document.getElementById('cart-content').innerHTML = '<p>Your cart is empty.</p>';
                        } else {
                            updateTotalPrice();
                        }
                    } else {
                        alert(data.message);
                    }
                });
        }
    </script>

    <?php require_once FOOTER_PATH ?>
</body>

</html>
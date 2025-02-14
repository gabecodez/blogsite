<?php
// File: cart.php
// Author: Gabriel Sullivan
// Purpose: Cart page for BlueSky Homesteading
declare(strict_types=1);

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/databaseconnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/shop_databaseconnection.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/session_starter.php';

$status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 0, 'max_range' => 1]]);
$cart_items = [];

try {
    // Retrieve cart items
    $stmt = $shop_conn->prepare("SELECT product_id, quantity FROM cart WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    while ($cart_item = $cart_result->fetch_assoc()) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];

        // Retrieve product details
        $product_stmt = $conn->prepare("SELECT name, price, category, slug FROM products WHERE id = ?");
        $product_stmt->bind_param("i", $product_id);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();

        if ($product = $product_result->fetch_assoc()) {
            $cart_items[] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'category' => $product['category'],
                'slug' => $product['slug']
            ];
        }
        $product_stmt->close();
    }

    $stmt->close();
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
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/head.php';
    $pageTitle = "Your Cart";
    $pageDescription = "Your shopping cart";
    $imageURL = "https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg";
    $pageURL = "https://www.blueskyhomesteading.com/shop/cart";
    $siteName = "BlueSky Homesteading";
    $twitterHandle = "";
    $creatorHandle = "";
    ?>
    <title><?php echo $pageTitle; ?></title>
    <link rel="canonical" href="<?php echo $pageURL; ?>">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="keywords" content="cart, shopping cart">
    <meta name="author" content="BlueSky Homesteading">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($imageURL); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageURL); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($siteName); ?>">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="<?php echo htmlspecialchars($twitterHandle); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($imageURL); ?>">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($pageURL); ?>">
    <meta name="twitter:creator" content="<?php echo htmlspecialchars($creatorHandle); ?>">
    <meta name="linkedin:card" content="summary_large_image">
    <meta name="linkedin:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta name="linkedin:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="linkedin:image" content="<?php echo htmlspecialchars($imageURL); ?>">
    <meta name="twitter:domain" content="blueskyhomesteading.com">
</head>

</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/consentbanner.php'; ?>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/navbar.php'; ?>

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
                            $cat_stmt = $conn->prepare("SELECT slug FROM shop_categories WHERE public = 1 AND name = ?"); 
                            $cat_stmt->bind_param("s", $item['category']); 
                            $cat_stmt->execute(); 
                            $result = $cat_stmt->get_result(); 
                            if ($result->num_rows > 0) { 
                                $item_product = $result->fetch_assoc();
                            }
                        ?>
                        <a href="https://www.blueskyhomesteading.com/shop/<?php echo $item_product['slug']."/"; echo $item['slug']; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
                        <input type="number" class="item-quantity" data-item-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                        <span id="item-price-<?php echo $item['id']; ?>">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        <button onclick="removeItem(<?php echo $item['id']; ?>)"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#d81a1a" style="vertical-align: middle;"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/></svg><span>Remove</span></button>
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
                itemData.push({ id: itemId, quantity: quantity });
            });

            fetch('https://www.blueskyhomesteading.com/shop/calculate-total', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'item_data': JSON.stringify(itemData) })
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
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ 'item_id': itemId, 'quantity': quantity })
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
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'item_id': itemId })
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

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/../../includes/blueskyhomesteading/footer.php'; ?>
</body>
</html>

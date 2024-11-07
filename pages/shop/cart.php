<?php
// cart.php

include '../../includes/sitewide_std_vars.php';
include '../../includes/shop_databaseconnection.php';
include '../../includes/databaseconnection.php';
session_start();

$status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 0, 'max_range' => 1]]);
$session_id = session_id();
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
    $shop_conn->close();
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
    <?php include '../../includes/head.php'; ?>
    <title>Your Cart</title>
    <link rel="stylesheet" href="<?php echo SITE_URL ?>/styles/styles.css">
</head>
<body>
    <?php include '../../includes/consentbanner.php'; ?>
    <?php include '../../includes/navbar.php'; ?>

    <div class="cart-page">
    <?php
        // Check if the status indicates a failure (1) or success (0)
        if ($status === 1) {
            // Failure case
            // Implement failure handling logic here
            echo '<p class="error-message">Your transaction could not be completed. Please try again. For help, please <a href="'.SITE_URL.'/contact">contact us.</a></p>';
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
                        <input type="checkbox" class="item-checkbox" data-item-id="<?php echo $item['id']; ?>" checked>
                        <?php
                            $cat_stmt = $conn->prepare("SELECT slug FROM shop_categories WHERE public = 1 AND name = ?"); 
                            $cat_stmt->bind_param("s", $item['category']); 
                            $cat_stmt->execute(); 
                            $result = $cat_stmt->get_result(); 
                            if ($result->num_rows > 0) { 
                                $item_product = $result->fetch_assoc();
                            }
                        ?>
                        <a href="<?php echo SITE_URL ?>/shop/<?php echo $item_product['slug']."/"; echo $item['slug']; ?>"><?php echo htmlspecialchars($item['name']); ?></a>
                        <input type="number" class="item-quantity" data-item-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                        <span id="item-price-<?php echo $item['id']; ?>">$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                        <button onclick="removeItem(<?php echo $item['id']; ?>)"><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#d81a1a" style="vertical-align: middle;"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm336-552H312v480h336v-480ZM384-288h72v-336h-72v336Zm120 0h72v-336h-72v336ZM312-696v480-480Z"/></svg><span>Remove</span></button>
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="total-section">
                    <p class="total-price">Total: $<?php echo number_format($total_price, 2); ?></p>
                    <a href="<?php echo SITE_URL ?>/shop/checkout" class="checkout-button">Checkout</a>
                    <p class="small-note">Payment is securely handled by Stripe. Your satisfaction is our highest priority. Read about our <a href="<?php echo SITE_URL ?>/refunds">refunds and returns policy.</a></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $conn->close();
    ?>

    <script>
        function updateTotalPrice() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            const itemData = [];

            checkedItems.forEach(item => {
                const itemId = item.dataset.itemId;
                const quantity = document.querySelector(`.item-quantity[data-item-id="${itemId}"]`).value;
                itemData.push({ id: itemId, quantity: quantity });
            });

            fetch('<?php echo SITE_URL ?>/shop/calculate-total', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'item_data': JSON.stringify(itemData) })
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector('.total-price').textContent = `Total: $${data.totalPrice}`;
            });
        }

        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const itemId = this.dataset.itemId;
                const includeForCheckout = this.checked ? 1 : 0;

                fetch('<?php echo SITE_URL ?>/shop/update-include-for-checkout', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ 'item_id': itemId, 'include_for_checkout': includeForCheckout })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateTotalPrice();
                    } else {
                        alert(data.message);
                    }
                });
            });
        });

        document.querySelectorAll('.item-quantity').forEach(input => {
            input.addEventListener('change', function() {
                const itemId = this.dataset.itemId;
                const quantity = this.value;

                fetch('<?php echo SITE_URL ?>/shop/update-cart', {
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
            fetch('<?php echo SITE_URL ?>/shop/remove-from-cart', {
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

    <?php include '../../includes/footer.php'; ?>
</body>
</html>

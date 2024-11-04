<?php 
session_start();
include '../../includes/shop_databaseconnection.php';
include '../../includes/databaseconnection.php';

$session_id = session_id();
$cart_items = [];

try {
    // Step 1: Retrieve cart items from the cart table in shop database
    $stmt = $shop_conn->prepare("SELECT product_id, quantity FROM cart WHERE session_id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();

    while ($cart_item = $cart_result->fetch_assoc()) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];

        // Step 2: Retrieve product details from products table in the main database
        $product_stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
        $product_stmt->bind_param("i", $product_id);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();

        if ($product = $product_result->fetch_assoc()) {
            // Merge cart and product data
            $cart_items[] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
        $product_stmt->close();
    }

    $stmt->close();
    $shop_conn->close();
    $conn->close();
    
} catch (Exception $e) {
    error_log($e->getMessage());
}

// Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <div class="cart-page">
        <h1>Your Cart</h1>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <span><?php echo htmlspecialchars($item['name']); ?></span>
                    <input type="number" class="item-quantity" data-item-id="<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="1">
                    <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                    <button onclick="removeItem(<?php echo $item['id']; ?>)">Remove</button>
                </div>
            <?php endforeach; ?>
            <div class="total-price">Total: $<?php echo number_format($total_price, 2); ?></div>
            <a href="/shop/checkout" class="checkout-button">Checkout</a>
        <?php endif; ?>
    </div>

    <script>
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
                    .then(data => alert(data.message))
                    .catch(error => alert('Error updating cart.'));
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
                        location.reload(); // Reload the page to update the cart display
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => alert('Error removing item.'));
        }
    </script>
</body>

</html>
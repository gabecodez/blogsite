function updateTotalPrice() {
  const items = document.querySelectorAll(".cart-item");
  const itemData = [];

  items.forEach((item) => {
    const itemId = item.dataset.itemId;
    const quantity = document.querySelector(
      `.item-quantity[data-item-id="${itemId}"]`
    ).value;
    itemData.push({
      id: itemId,
      quantity: quantity,
    });
  });

  fetch("https://www.blueskyhomesteading.com/shop/calculate-total", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      item_data: JSON.stringify(itemData),
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      document.querySelector(
        ".total-price"
      ).textContent = `Total: $${data.totalPrice}`;
    });
}

document.querySelectorAll(".item-quantity").forEach((input) => {
  input.addEventListener("change", function () {
    const itemId = this.dataset.itemId;
    const quantity = this.value;

    fetch("https://www.blueskyhomesteading.com/shop/update-cart", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        item_id: itemId,
        quantity: quantity,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          document.querySelector(
            `#item-price-${itemId}`
          ).textContent = `$${data.itemTotalPrice}`;
          document.querySelector(
            ".total-price"
          ).textContent = `Total: $${data.totalPrice}`;
        } else {
          alert(data.message);
        }
      });
  });
});

function removeItem(itemId) {
  fetch("https://www.blueskyhomesteading.com/shop/remove-from-cart", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      item_id: itemId,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const itemElement = document.querySelector(
          `.cart-item[data-item-id="${itemId}"]`
        );
        itemElement.remove();

        // Check if the cart is empty
        const cartItems = document.querySelectorAll(".cart-item");
        if (cartItems.length === 0) {
          document.getElementById("cart-content").innerHTML =
            "<p>Your cart is empty.</p>";
        } else {
          updateTotalPrice();
        }
      } else {
        alert(data.message);
      }
    });
}

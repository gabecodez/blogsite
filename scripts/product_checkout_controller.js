function addToCart(productId) {
  const quantity = document.querySelector(".quantity-input").value || 1;
  const optionContainers = document.querySelectorAll(".atc-tile-container");
  const selectedOptions = {};

  // Validation: ensure each option group has a selected input
  for (const container of optionContainers) {
    const checked = container.querySelector("input:checked");
    const optionLabel = container.previousElementSibling;
    const optionName = optionLabel.dataset.name;

    if (!checked) {
      alert(`Please select a choice for "${optionName}".`);
      return; // Stop if any required option is not selected
    }

    selectedOptions[optionName] = checked.value;
  }

  fetch("https://www.blueskyhomesteading.com/shop/add-to-cart", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      product_id: productId,
      quantity: quantity,
      options: JSON.stringify(selectedOptions),
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      window.location.href = "https://www.blueskyhomesteading.com/shop/cart";
    })
    .catch((error) => alert("An error occurred."));
}

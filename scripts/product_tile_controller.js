// Tile Selection Script
document.querySelectorAll(".atc-tile-container").forEach((container) => {
  container.addEventListener("click", function (e) {
    const clickedTile = e.target.closest(".atc-tile-option");
    if (!clickedTile) return;

    // Remove 'selected' class from all tiles in this container
    container.querySelectorAll(".atc-tile-option").forEach((tile) => {
      tile.classList.remove("selected");
    });

    // Add 'selected' class to clicked tile
    clickedTile.classList.add("selected");

    // Check the radio button
    const radio = clickedTile.querySelector("input");
    radio.checked = true;
  });
});

// Enhanced Quantity Selector Script
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".atc-tile-container").forEach((container) => {
    const checked = container.querySelector("input:checked");
    if (checked) {
      checked.closest(".atc-tile-option").classList.add("selected");
    }
  });

  const quantityInput = document.querySelector(".quantity-input");
  const minusBtn = document.querySelector(".minus");
  const plusBtn = document.querySelector(".plus");

  minusBtn.addEventListener("click", () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
      quantityInput.value = currentValue - 1;
    }
  });

  plusBtn.addEventListener("click", () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue < 99) {
      quantityInput.value = currentValue + 1;
    }
  });

  // Input validation
  quantityInput.addEventListener("change", () => {
    let value = parseInt(quantityInput.value);
    if (isNaN(value) || value < 1) {
      quantityInput.value = 1;
    } else if (value > 99) {
      quantityInput.value = 99;
    }
  });
});

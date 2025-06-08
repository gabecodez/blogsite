// JavaScript for handling the modal, dynamic image upload blocks, and AJAX requests.
const modal = document.getElementById("productModal");
const createBtn = document.getElementById("createProductBtn");
const closeModal = document.querySelector(".close");
const productForm = document.getElementById("productForm");
const modalTitle = document.getElementById("modalTitle");
const productIdInput = document.getElementById("productId");
const imageUploadContainer = document.getElementById("imageUploadContainer");
const addImageBtn = document.getElementById("addImageBtn");

// Create an image upload block (for existing and new images).
function createImageUploadElement({
  existing = false,
  id = "",
  image_url = "",
  caption = "",
  credit = "",
  credit_url = "",
  alttext = "",
} = {}) {
  const container = document.createElement("div");
  container.className = "image-upload";

  if (existing) {
    const hiddenId = document.createElement("input");
    hiddenId.type = "hidden";
    hiddenId.name = "existing_image_ids[]";
    hiddenId.value = id;
    container.appendChild(hiddenId);

    const hiddenUrl = document.createElement("input");
    hiddenUrl.type = "hidden";
    hiddenUrl.name = "existing_image_url[]";
    hiddenUrl.value = image_url;
    container.appendChild(hiddenUrl);
  }

  const fileLabel = document.createElement("label");
  fileLabel.textContent = "Upload Image:";
  container.appendChild(fileLabel);

  const fileInput = document.createElement("input");
  fileInput.type = "file";
  fileInput.accept = "image/*";
  fileInput.name = existing ? "existing_file[]" : "new_file[]";
  container.appendChild(fileInput);

  const previewDiv = document.createElement("div");
  previewDiv.className = "image-preview";
  if (existing && image_url) {
    const img = document.createElement("img");
    img.src = image_url;
    img.alt = alttext;
    img.style.maxWidth = "100%";
    previewDiv.appendChild(img);
  }
  container.appendChild(previewDiv);

  // Caption field.
  const captionLabel = document.createElement("label");
  captionLabel.textContent = "Caption:";
  container.appendChild(captionLabel);
  const captionInput = document.createElement("input");
  captionInput.type = "text";
  captionInput.name = existing ? "existing_caption[]" : "new_caption[]";
  captionInput.value = caption;
  container.appendChild(captionInput);

  // Credit field.
  const creditLabel = document.createElement("label");
  creditLabel.textContent = "Credit:";
  container.appendChild(creditLabel);
  const creditInput = document.createElement("input");
  creditInput.type = "text";
  creditInput.name = existing ? "existing_credit[]" : "new_credit[]";
  creditInput.value = credit;
  container.appendChild(creditInput);

  // Credit URL field.
  const creditUrlLabel = document.createElement("label");
  creditUrlLabel.textContent = "Credit URL:";
  container.appendChild(creditUrlLabel);
  const creditUrlInput = document.createElement("input");
  creditUrlInput.type = "text";
  creditUrlInput.name = existing ? "existing_credit_url[]" : "new_credit_url[]";
  creditUrlInput.value = credit_url;
  container.appendChild(creditUrlInput);

  // Alt Text field.
  const altTextLabel = document.createElement("label");
  altTextLabel.textContent = "Alt Text:";
  container.appendChild(altTextLabel);
  const altTextInput = document.createElement("input");
  altTextInput.type = "text";
  altTextInput.name = existing ? "existing_alttext[]" : "new_alttext[]";
  altTextInput.value = alttext;
  container.appendChild(altTextInput);

  // Remove button.
  const removeBtn = document.createElement("button");
  removeBtn.type = "button";
  removeBtn.className = "removeImageBtn";
  removeBtn.textContent = "Remove Image";
  removeBtn.addEventListener("click", () => {
    if (existing) {
      const removalInput = document.createElement("input");
      removalInput.type = "hidden";
      removalInput.name = "remove_image_ids[]";
      removalInput.value = id;
      productForm.appendChild(removalInput);
    }
    container.remove();
  });
  container.appendChild(removeBtn);

  return container;
}

// Load image-upload blocks from an array of image objects.
function loadImageUploads(images) {
  imageUploadContainer.innerHTML = "";
  if (images && images.length) {
    images.forEach((image) => {
      imageUploadContainer.appendChild(
        createImageUploadElement({
          existing: true,
          id: image.id,
          image_url: image.image_url,
          caption: image.caption,
          credit: image.credit,
          credit_url: image.credit_url,
          alttext: image.alttext,
        })
      );
    });
  } else {
    imageUploadContainer.appendChild(
      createImageUploadElement({ existing: false })
    );
  }
}

// Open modal for new product.
createBtn.onclick = () => {
  modalTitle.textContent = "Create Product";
  productForm.reset();
  productIdInput.value = "";
  document
    .querySelectorAll('input[name="remove_image_ids[]"]')
    .forEach((el) => el.remove());
  loadImageUploads([]);
  modal.style.display = "block";
};

// Open modal for editing.
document.querySelectorAll(".editBtn").forEach((btn) => {
  btn.onclick = () => {
    modalTitle.textContent = "Edit Product";
    const productId = btn.dataset.id;
    // Use a template literal for the URL.
    fetch(
      `https://www.blueskyhomesteading.com/pages/admin/get_product.php?id=${productId}`
    )
      .then((res) => res.json())
      .then((data) => {
        productIdInput.value = data.id;
        document.getElementById("name").value = data.name;
        document.getElementById("category").value = data.category;
        document.getElementById("price").value = data.price;
        document.getElementById("description").value = data.description;
        document
          .querySelectorAll('input[name="remove_image_ids[]"]')
          .forEach((el) => el.remove());
        loadImageUploads(data.images);
        modal.style.display = "block";
      })
      .catch((err) => {
        alert("Failed to load product data.");
        console.error(err);
      });
  };
});

// Add a new image block.
addImageBtn.onclick = () => {
  imageUploadContainer.appendChild(
    createImageUploadElement({ existing: false })
  );
};

// Close modal.
closeModal.onclick = () => {
  modal.style.display = "none";
};

// Submit form.
productForm.onsubmit = (e) => {
  e.preventDefault();
  const formData = new FormData(productForm);
  fetch("https://www.blueskyhomesteading.com/pages/admin/save_product.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      alert(data.message || data.error);
      if (data.success) location.reload();
    })
    .catch((err) => {
      alert("An error occurred while saving the product.");
      console.error(err);
    });
};

// Delete product.
document.querySelectorAll(".deleteBtn").forEach((btn) => {
  btn.onclick = () => {
    if (confirm("Are you sure you want to delete this product?")) {
      // Use a template literal for the URL.
      fetch(
        `https://www.blueskyhomesteading.com/pages/admin/delete_product.php?id=${btn.dataset.id}`,
        {
          method: "DELETE",
        }
      )
        .then((res) => res.json())
        .then((data) => {
          alert(data.message || data.error);
          if (data.success) location.reload();
        })
        .catch((err) => {
          alert("An error occurred while deleting the product.");
          console.error(err);
        });
    }
  };
});

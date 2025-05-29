<?php
// Filename: ProductList.php
// Purpose: handles the rendering of products in a list or carousel

class ProductList
{
    private array $products = [];
    private Database $conn;

    // Constructor
    // Input: $conn - the database connection
    // Output: none
    // Raises: none
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Function name: fetchProducts
    // Purpose: fetches all the public products
    // Input: none
    // Output: none
    // Raises: none
    private function fetchProducts($sql)
    {
        // Query for products
        $this->products = $this->conn->fetchAll($sql);
    }

    // Function name: render
    // Purpose: renders out the product list
    // Input: none
    // Output: none
    // Raises: none
    public function render($sql = "SELECT p.id, p.name, p.price, p.preview_image_ids, p.slug AS product_slug, c.slug AS category_slug 
        FROM products AS p 
        JOIN shop_categories AS c ON p.category = c.name 
        WHERE p.public = 1 
        ORDER BY p.id DESC")
    {
        $this->fetchProducts($sql);

        if (!empty($this->products)) {
            foreach ($this->products as $product) {
                // Fetch image details if there are any image IDs
                $image_data = [];
                if (!empty($product['preview_image_ids'])) {
                    $image_ids = explode(',', $product['preview_image_ids']); // separate ids out

                    $image_id = trim($image_ids[0]); // remove the whitespace for the first id (the only one needed)
                    // Fetch that first image
                    $images_sql = "SELECT image_url, alttext, public FROM images WHERE id = ? AND public = 1 LIMIT 1";
                    $image_data = $this->conn->fetchAll($images_sql, [$image_id]);
                }

                // Render out the product preview card
?>
                <a class="product-preview" href="<?= SITE_URL . '/shop/' . htmlspecialchars($product['category_slug']) . '/' . htmlspecialchars($product['product_slug']) ?>">
                    <?php foreach ($image_data as $image) { ?>
                        <div class="product-image-container">
                            <img src="<?= htmlspecialchars($image['image_url']) . '" alt="' . htmlspecialchars($image['alttext']) ?>">
                        </div>
                    <?php } ?>
                    <div class="text">
                        <span class="name"><?= $product['name'] ?></span>
                        <span class="price"><?= '$' . number_format($product['price'], 2) ?></span>
                    </div>
                </a>
<?php
            }
        }
    }
}

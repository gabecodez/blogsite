<?php
// Filename: BlogPostList.php
// Purpose: handles the rendering of blog posts in a list or carousel

class BlogPostList
{
    private array $articles = [];
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
    private function fetchProducts($sql, $params = [])
    {
        // Query for posts
        $this->articles = $this->conn->fetchAll($sql, $params);
    }

    // Function name: render
    // Purpose: renders out the product list
    // Input: none
    // Output: none
    // Raises: none
    public function render($sql, $params = [])
    {
        $this->fetchProducts($sql, $params);

        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
?>
                <a class="top-article" href="<?= SITE_URL . '/blog/' . htmlspecialchars($article['category_slug']) . '/' . htmlspecialchars($article['article_slug']) ?>">
                    <div class="frontpage-article-image-parent">
                        <?php if (!empty($article['image_url'])) { ?>
                            <img src="<?= htmlspecialchars($article['image_url']) . '" alt="' . htmlspecialchars($article['alttext']) ?>" class="frontpage-article-image" loading="lazy">
                        <?php } ?>
                    </div>
                    <div class="frontpage-article-text">
                        <h3><?= htmlspecialchars($article['title']) ?></h3>
                    </div>
                </a>
<?php
            }
        } else {
            echo "No articles found.";
        }
    }
}

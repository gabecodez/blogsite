<?php
// File: Article.php
// Author: Gabriel Sullivan
// Purpose: Handles article retrieval
class Article
{
    public $id;
    public $title;
    public $meta_description;
    public $meta_keywords;
    public $category;
    public $image_id; // contains image IDs to then query with
    public $content;
    public $slug;

    private Database $conn; // the database connection

    // Constructor
    // Input: $conn - the database connection
    // Output: none
    // Raises: none
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Function name: fetch_article
    // Purpose: fetches the article from the database
    // Input: string $category_slug - the category part of the URL
    // Output: string $article_slug - the article part of the URL
    public function fetch_article(string $category_slug, string $article_slug): bool
    {
        try {
            $article_sql = "
                 SELECT a.id, a.title, a.content, a.meta_description, a.meta_keywords, a.image_id, c.name AS category 
                 FROM articles AS a 
                 JOIN categories AS c ON c.slug = ? AND a.slug = ? AND a.category = c.name 
                 WHERE a.public = 1
             ";
            $article = $this->conn->fetchAll($article_sql, [$category_slug, $article_slug]);

            if (sizeof($article) > 0) {
                $article = $article[0];
                $this->id = $article["id"];
                $this->title = $article['title'];
                $this->category = $article['category'];
                $this->meta_description = $article['meta_description'];
                $this->meta_keywords = $article['meta_keywords'];
                $this->image_id = (int) $article['image_id'];
                $this->content = $article['content'];
                $this->slug = $category_slug . '/' . $article_slug;
                return true;
            } else {
                // Create the article object
                return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }

        return false;
    }
}

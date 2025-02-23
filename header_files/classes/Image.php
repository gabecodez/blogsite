<?php
// File: Image.php
// Author: Gabriel Sullivan
// Purpose: Handles image retrieval for articles
class Image
{
    private $conn;
    public ?string $url = null;
    public ?string $caption = null;
    public ?string $credit = null;
    public ?string $credit_url = null;
    public ?string $alttext = null;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function fetchImage(int $image_id): bool
    {
        try {
            $image_sql = "SELECT image_url, caption, credit, credit_url, alttext FROM images WHERE id = ? AND public = 1";
            $image = $this->conn->fetchAll($image_sql, [$image_id]);
        
            if (sizeof($image) > 0) {
                $image = $image[0];
                $this->url = $image['image_url'];
                $this->caption = $image['caption'];
                $this->credit = $image['credit'];
                $this->credit_url = $image['credit_url'];
                $this->alttext = $image['alttext'];
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

    public function render(): void
    {
        if (!empty($this->url)) {
            echo '<figure class="article-image">';
            echo '<img src="' . $this->url . '" alt="' . $this->alttext . '" class="responsive-img">';
            if (!empty($this->caption)) {
                echo '<figcaption>' . $this->caption . '</figcaption>';
            }
            if (!empty($this->credit) && !empty($this->credit_url)) {
                echo '<p class="image-credit">';
                echo 'Credit: <a href="' . $this->credit_url . '" target="_blank" rel="noopener noreferrer">' . $this->credit . '</a>';
                echo '</p>';
            } else if (!empty($this->credit)) {
                echo '<p class="image-credit">Credit: ' . $this->credit . '</p>';
            }
            echo '</figure>';
        }
    }
}
?>

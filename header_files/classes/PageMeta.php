<?php

class PageMeta {
    private $title;
    private $description;
    private $imageURL;
    private $url;
    private $siteName;
    private $twitterHandle;
    private $creatorHandle;

    public function __construct($title, $description, $imageURL, $url, $siteName, $twitterHandle = '', $creatorHandle = '') {
        $this->title = $title;
        $this->description = $description;
        $this->imageURL = $imageURL;
        $this->url = $url;
        $this->siteName = $siteName;
        $this->twitterHandle = $twitterHandle;
        $this->creatorHandle = $creatorHandle;
    }

    public function render() {
        echo "<title>" . htmlspecialchars($this->title) . "</title>\n";
        echo "<link rel=\"canonical\" href=\"" . htmlspecialchars($this->url) . "\">\n";
        echo "<meta name=\"description\" content=\"" . htmlspecialchars($this->description) . "\">\n";
        echo "<meta name=\"keywords\" content=\"homesteading, sustainable living, about us, mission\">\n";
        echo "<meta name=\"author\" content=\"" . htmlspecialchars($this->siteName) . "\">\n";
        echo "<meta property=\"og:title\" content=\"" . htmlspecialchars($this->title) . "\">\n";
        echo "<meta property=\"og:description\" content=\"" . htmlspecialchars($this->description) . "\">\n";
        echo "<meta property=\"og:image\" content=\"" . htmlspecialchars($this->imageURL) . "\">\n";
        echo "<meta property=\"og:url\" content=\"" . htmlspecialchars($this->url) . "\">\n";
        echo "<meta property=\"og:type\" content=\"website\">\n";
        echo "<meta property=\"og:site_name\" content=\"" . htmlspecialchars($this->siteName) . "\">\n";
        echo "<meta property=\"og:locale\" content=\"en_US\">\n";
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
        echo "<meta name=\"twitter:site\" content=\"" . htmlspecialchars($this->twitterHandle) . "\">\n";
        echo "<meta name=\"twitter:title\" content=\"" . htmlspecialchars($this->title) . "\">\n";
        echo "<meta name=\"twitter:description\" content=\"" . htmlspecialchars($this->description) . "\">\n";
        echo "<meta name=\"twitter:image\" content=\"" . htmlspecialchars($this->imageURL) . "\">\n";
        echo "<meta name=\"twitter:url\" content=\"" . htmlspecialchars($this->url) . "\">\n";
        echo "<meta name=\"twitter:creator\" content=\"" . htmlspecialchars($this->creatorHandle) . "\">\n";
        echo "<meta name=\"linkedin:card\" content=\"summary_large_image\">\n";
        echo "<meta name=\"linkedin:title\" content=\"" . htmlspecialchars($this->title) . "\">\n";
        echo "<meta name=\"linkedin:description\" content=\"" . htmlspecialchars($this->description) . "\">\n";
        echo "<meta name=\"linkedin:image\" content=\"" . htmlspecialchars($this->imageURL) . "\">\n";
        echo "<meta name=\"twitter:domain\" content=\"blueskyhomesteading.com\">\n";
        echo '<script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "' . htmlspecialchars($this->title) . '",
            "url": "' . htmlspecialchars($this->url) . '",
            "description": "' . htmlspecialchars($this->description) . '"
        }
        </script>';
    }
}

?>
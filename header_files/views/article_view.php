<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once HEAD_PATH;
    $pageMeta = new PageMeta(
        $article->title,
        $article->meta_description,
        $image->url,
        SITE_URL . "/blog/{$article->slug}",
        SITE_NAME
    );
    $pageMeta->render();
    ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <?php
    require_once CONSENT_BANNER_PATH;
    require_once NAVBAR_PATH;
    ?>
    <main class="main-page">
        <div class="article-content">
            <header>
                <h1><?= htmlspecialchars($article->title); ?></h1>
                <?php
                $breadcrumb->render();
                $socialShare->render();
                $image->render();
                ?>
            </header>
            <article>
                <?= $article->content; ?>
            </article>
        </div>
        <section style="overflow:hidden; width:100%;">
            <h2>See more</h2>
            <div class="blog-articles">
                <?php
                // Query to get the latest articles along with their category slugs
                $sql = "SELECT articles.slug AS article_slug, articles.title, articles.meta_description, articles.image_id, categories.slug AS category_slug, 
                    images.image_url, images.alttext, images.caption, images.credit, images.credit_url
                    FROM articles 
                    JOIN categories ON articles.category = categories.name
                    LEFT JOIN images ON articles.image_id = images.id
                    WHERE articles.public = 1 AND articles.id != ? 
                    ORDER BY articles.published_date DESC 
                    LIMIT 3";
                $articles = new BlogPostList($conn);
                $articles->render($sql, [$article->id]);
                ?>
            </div>
        </section>
    </main>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>
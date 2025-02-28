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
    </main>
    <?php require_once FOOTER_PATH; ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once HEAD_PATH; ?>
    <title><?= htmlspecialchars($article->title); ?></title>
    <meta name="description" content="<?= htmlspecialchars($article->meta_description); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($article->meta_keywords); ?>">
    <meta property="og:title" content="<?= htmlspecialchars($article->title); ?>">
    <meta property="og:description" content="<?= htmlspecialchars($article->meta_description); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?= SITE_URL; ?>/blog/<?= $article->slug; ?>">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="canonical" href="<?= SITE_URL; ?>/blog/<?= $article->slug; ?>">

    <?php echo '<script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Article",
            "headline": "' . $article->title . '",
            "description": "' . $article->meta_description . '",
            "author": {
                "@type": "Person",
                "name": "Author Name"
            },
            "publisher": {
                "@type": "Organization",
                "name": "BlueSky Homesteading",
                "logo": {
                    "@type": "ImageObject",
                    "url": "https://www.blueskyhomesteading.com/images/logos/blueskylogoblack.svg"
                }
            },
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "https://www.blueskyhomesteading.com/blog/' . $article->slug . '"
            },
            "datePublished": "2023-01-01",
            "dateModified": "' . date('Y-m-d') . '"
        }
    </script>'; ?>
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
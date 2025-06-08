<?php
class ArticleController
{
    private Article $article;
    private Image $image;
    private Breadcrumb $breadcrumb;
    private SocialShare $socialShare;

    public function __construct($conn, $category_slug, $article_slug)
    {
        $this->article = new Article($conn);
        $this->article->fetch_article($category_slug, $article_slug);

        if (empty($this->article->title)) {
            $this->show404();
        }

        $this->image = new Image($conn);
        $this->image->fetchImage($this->article->image_id);

        $this->breadcrumb = new Breadcrumb();
        $this->breadcrumb->addCrumb('Home', '/');
        $this->breadcrumb->addCrumb('Blog', '/blog');
        $this->breadcrumb->addCrumb(ucfirst($this->article->category), '/blog/' . $category_slug);
        $this->breadcrumb->addCrumb($this->article->title);

        $postURL = SITE_URL . "/blog/" . $this->article->slug;
        $this->socialShare = new SocialShare($this->article->title, $postURL, $this->article->meta_description, $this->image);
    }

    private function show404()
    {
        http_response_code(404);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/404.php';
        exit();
    }

    public function getArticle()
    {
        return $this->article;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    public function getSocialShare()
    {
        return $this->socialShare;
    }
}

<?php
// File: article.php
// Author: Gabriel Sullivan
// Purpose: Article page template for BlueSky Homesteading
require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

$category_slug = isset($_GET['category_slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['category_slug']) : '';
$article_slug = isset($_GET['slug']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['slug']) : '';

$articleController = new ArticleController($conn, $category_slug, $article_slug);
$article = $articleController->getArticle();
$image = $articleController->getImage();
$breadcrumb = $articleController->getBreadcrumb();
$socialShare = $articleController->getSocialShare();

require_once VIEWS_PATH . 'article_view.php';

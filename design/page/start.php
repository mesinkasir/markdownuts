<?php
require_once 'functions.php';
$staticPages = getPost(null, 'page');
$config = getConfig();
$requestedSlug = isset($_GET['slug']) ? $_GET['slug'] : 'about';
$currentPage = $staticPages[$requestedSlug];
$sitemapFile = 'sitemap.xml';
?>
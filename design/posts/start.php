<?php
require_once 'functions.php';
$config = getConfig();
$slug = $_GET['slug'] ?? '';
$post = getPost($slug);
if (!$post) {
    die('Post not found');
}
$adjacentPosts = getPreviousNextPosts($slug);
?>
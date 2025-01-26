<?php
require_once 'functions.php';
$config = getConfig();
$tag = isset($_GET['tag']) ? urldecode($_GET['tag']) : null;
if (!$tag) {
    header("HTTP/1.0 404 Not Found");
    echo "Tag not specified";
    exit;
}
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 10; 
$allPosts = [];
$files = glob('posts/*.md');
foreach ($files as $file) {
    $post = getPost(basename($file, '.md'));
    if (in_array($tag, array_column($post['tags'], 'name'))) {
        $allPosts[] = $post;
    }
}
$totalPosts = count($allPosts);
$totalPages = ceil($totalPosts / $perPage);
$currentPage = min($page, $totalPages);
$start = ($currentPage - 1) * $perPage;
$posts = array_slice($allPosts, $start, $perPage);
?>
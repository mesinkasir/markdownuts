<?php
require_once 'functions.php';
$config = getConfig();
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$result = getPosts($page);
$posts = $result['posts'];
$totalPages = $result['totalPages'];
$currentPage = $result['currentPage'];
$allTags = getAllTags();
?>
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
<!DOCTYPE html>
<html lang="<?php echo $config['language'];?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'design/partials/seo.php'; ?>
<link rel="canonical" href="<?php echo $config['url'];?>">
</head>
<body>
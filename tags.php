<?php
require_once 'functions.php';
$config = getConfig();
$allTags = getAllTags();
?>
<!DOCTYPE html>
<html lang="<?php echo $config['language'];?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include 'design/partials/seo.php'; ?>
<link rel="canonical" href="<?php echo $config['url'];?>/tags">
</head>
<body>
<?php include 'design/partials/header.php'; ?>
<main><article>
<h1>Tags</h1>
<div class="media-container">
<p><?php foreach ($allTags as $tag): ?>
<a href="<?= $config['url'] ?>/tag/<?= urlencode($tag['name']) ?>">#<?= htmlspecialchars($tag['name']) ?></a> 
<?php endforeach; ?></p>
</div>
</article></main>
<?php include 'design/partials/footer.php'; ?>
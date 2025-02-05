<main><style>img,iframe{max-width:100%;}</style>
<article>
<h1><a href="<?php echo htmlspecialchars($currentPage['url'] ?? ''); ?>">
<?php echo htmlspecialchars($currentPage['title']); ?></a></h1>
<h2><?php echo htmlspecialchars($currentPage['description']); ?></h2>
<hr/>
<?php echo $currentPage['content']; ?>
</article>
</main>
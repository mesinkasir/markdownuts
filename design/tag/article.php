<main>
<header>
<h1>Posts tagged with "<?= htmlspecialchars($tag) ?>"</h1>
</header>
<?php if (empty($posts)): ?>
<p>No posts found with this tag.</p>
<?php else: ?>
<?php foreach ($posts as $post): ?>
<article>
<h2><a href="<?= $config['url'] ?>/post/<?= $post['slug'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
<p><?= htmlspecialchars($post['description']) ?></p>
<p>Date: <?= $post['dateIndo'] ?></p>
<p>Tags: <?= displayTags($post['tags']) ?></p>
</article>
<?php endforeach; ?>
<div class="pagination">
<?php if ($currentPage > 1): ?>
<a href="<?= $config['url'] ?>/tag/<?= urlencode($tag) ?>&page=<?= $currentPage - 1 ?>">Previous</a>
<?php endif; ?>
<!--
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<?php if ($i == $currentPage): ?>
<span><?= $i ?></span>
<?php else: ?>
<a href="<?= $config['url'] ?>/tag/<?= urlencode($tag) ?>&page=<?= $i ?>"><?= $i ?></a>
<?php endif; ?>
<?php endfor; ?>
-->
<?php if ($currentPage < $totalPages): ?>
<a href="<?= $config['url'] ?>/tag/<?= urlencode($tag) ?>&page=<?= $currentPage + 1 ?>">Next</a>
<?php endif; ?>
</div>
<?php endif; ?>
</main>
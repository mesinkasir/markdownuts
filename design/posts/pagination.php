<div class="navigation">
<?php if ($adjacentPosts['prev']): ?>
<a href="<?php echo $config['url'];?>/post/<?= $adjacentPosts['prev']['slug'] ?>">&laquo;  
Prev: <?= htmlspecialchars($adjacentPosts['prev']['title']) ?></a>
<?php endif; ?>
<?php if ($adjacentPosts['next']): ?>
<a href="<?php echo $config['url'];?>/post/<?= $adjacentPosts['next']['slug'] ?>">
Next: <?= htmlspecialchars($adjacentPosts['next']['title']) ?>  &raquo;</a>
<?php endif; ?>
</div>
<?php foreach ($posts as $post): ?>
<article>
<h2><a href="<?php echo $config['url'];?>/post/<?= $post['slug'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
<p><?php if (isset($config['author']['name'])): ?>Publish by <a href="<?php echo $config['author']['url'];?>"><?php echo $config['author']['name'];?></a><?php endif; ?> on <?= $post['date'] ?></p>
<p><?= htmlspecialchars($post['description']) ?></p>
<p>Tags: <?= displayTags($post['tags']) ?></p>
</article>
<?php endforeach; ?>
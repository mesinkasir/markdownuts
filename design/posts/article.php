<article>
<h1><a href="<?php echo $config['url'];?>/post/<?= $post['slug'] ?>"><?= htmlspecialchars($post['title']) ?></a></h1>
<h2><?= htmlspecialchars($post['description']) ?></h2>
 <div class="meta">
<p><span>Published: <?= $post['date'] ?></span>
<span> | </span>
<?php if (isset($config['author']['name'])): ?><span>Author: <a href="<?php echo $config['author']['url'];?>"><?php echo $config['author']['name'];?></a></span><?php endif; ?></p>
<p>Tags: <?= displayTags($post['tags']) ?></p>
</div>
<hr/>
<style>img,iframe {max-width: 100%;height: auto;}</style>
<?= $post['content'] ?>
</article>
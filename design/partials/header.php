<header>
<nav>
<ul>
<?php foreach ($config['navbar'] as $nav): ?>
<li><a href="<?php echo $nav['url'];?>"><?php echo $nav['nav'];?></a></li>
<?php endforeach; ?>
</ul>
</nav>
</header>
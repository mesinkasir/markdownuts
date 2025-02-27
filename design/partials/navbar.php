<ul>
<?php foreach ($config['navbar'] as $nav): ?>
<li><a href="<?php echo $config['url'] . $nav['url'];?>"><?php echo $nav['nav'];?></a></li>
<?php endforeach; ?>
</ul><hr/>
<p>Download Markdownuts Source Code <a href="https://creativitaz.gumroad.com/l/markdownuts-starter">Download Now</a></p>
<p>Or install with composer <pre><code><a href="https://github.com/mesinkasir/markdownuts">composer create-project creativitas/markdownuts</a></code></pre></p>
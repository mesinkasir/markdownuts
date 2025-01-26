<div class="pagination">
<?php if ($currentPage > 1): ?>
<a href="<?php echo $config['url'];?>?page=<?= $currentPage - 1 ?>">&laquo;  Prev</a>
<?php endif; ?>
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<?php if ($i == $currentPage): ?>
<a href="#"><?= $i ?></a>
<?php else: ?>
<a href="<?php echo $config['url'];?>?page=<?= $i ?>"><?= $i ?></a>
<?php endif; ?>
<?php endfor; ?>
<?php if ($currentPage < $totalPages): ?>
<a href="<?php echo $config['url'];?>?page=<?= $currentPage + 1 ?>">Next  &raquo;</a>
<?php endif; ?>
</div>
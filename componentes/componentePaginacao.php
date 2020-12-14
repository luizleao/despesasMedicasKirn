<nav aria-label="Page navigation">
	<ul class="pagination">
		<li class="<?=($_REQUEST['pag'] == 1) ? "active" : ""?>"><a href="?pag=1"><span aria-hidden="true">&laquo;&laquo;</span></a></li>
		<li class="<?=($_REQUEST['pag'] == 1) ? "active" : ""?>"><a href="?pag=<?=$_REQUEST['pag']-1?>"><span aria-hidden="true">&laquo;</span></a></li>
<?php 
for($i=$_REQUEST['pag']; $i<=$numPags; $i++){
?>
		<li class="<?=($_REQUEST['pag'] == $i) ? "active" : ""?>"><a href="?pag=<?=$i?>"><?=$i?></a></li>
<?php 
}
?>
		<li class="<?=($_REQUEST['pag'] == $numPags) ? "active" : ""?>">
            <a href="?pag=<?=$_REQUEST['pag']+1?>" aria-label="Next">
	            <span aria-hidden="true">&raquo;</span>
            </a>
		</li>
		<li class="next <?=($_REQUEST['pag'] == $numPags) ? "active" : ""?>">
			<a href="?pag=<?=$numPags?>" aria-label="Next">
	            <span aria-hidden="true">&raquo;&raquo;</span>
            </a>
		</li>
	</ul><!-- /.pagination -->
</nav>
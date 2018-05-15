<?php if ($node->more_link): ?>
<div class="node <?php print $node->type ?> row-item <?php print $node->display_position; ?>">
	<?php if ($node->pencil) {
		print $node->pencil;
	}  ?>
	<?php 
		global $base_url;
		$pos = strpos($node->more_link,'http');
		if($pos === false) {
			$node->more_link = $base_url . '/' . $node->more_link;
		}
	?>
	<h2 class="row-title"><a href="<?php print $node->more_link; ?>"><?php print $node->title; ?></a></h2>
	<div class="views-row views-row-1 views-row-odd views-row-first views-row-last link_block ">
		<a class="bucket-image" title="<?php print $node->title; ?>" href="<?php print $node->more_link; ?>">
			<?php print $node->bucket_img; ?>
		</a>
		<?php print $node->body; ?>
		<a class="bttn_slim_right" title="Read More: <?php print $node->title; ?>" href="<?php print $node->more_link; ?>"><span>More</span></a>
	</div>

</div>
<?php else: ?>
<div class="node <?php print $node->type ?> row-item <?php print $node->display_position; ?>">
	<?php if ($node->pencil) {
		print $node->pencil;
	}  ?>
	<h2 class="row-title"><?php print $node->title; ?></h2>
	<div class="views-row views-row-1 views-row-odd views-row-first views-row-last link_block ">
		<?php print $node->bucket_img; ?>
		<?php print $node->body; ?>
	</div>

</div>
<?php endif; ?>
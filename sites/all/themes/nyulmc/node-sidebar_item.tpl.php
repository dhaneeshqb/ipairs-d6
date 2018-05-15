<?php
	$link = NULL;
	if ($node->field_url[0]['url'] && $link = $node->field_url[0]) {
		$link['attributes'] = unserialize($link['attributes']);
		$title = l($title, $link['url'], $link['attributes']);
	}
	$icon = NULL;
	if ($is_front && !$image) {
		$image = ($link['url'] ? '<a href="'.$link['url'].'">' : '').'<span class="icon">&nbsp;</span>'.($link['url'] ? '</a>' : '');
	}
?>

<?php if ($is_front) { ?>
	
<div class="sidebar_top_front"></div>
    <div class="sidebar_item sidebar_item_front"<?php if ($is_front) print ' id="sidebar_item_'._nyumc_name_to_path($node->title).'"'; ?>>
		<?php print $image; ?>
		<h4><?php print $title ?></h4>
		<?php print $body ?>
	</div>
<div class="sidebar_bottom_front"></div>
	
<?php } else { ?>	
<div class="sidebar_top"></div>
	<div class="sidebar_item"<?php if ($is_front) print ' id="sidebar_item_'._nyumc_name_to_path($node->title).'"'; ?>>
		<h4><?php print $title ?></h4>
		<?php print $body ?>
		</div>
<div class="sidebar_bottom"></div>
		
<?php } ?>
	
	
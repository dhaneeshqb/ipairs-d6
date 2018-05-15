<?php

$modulePath = drupal_get_path('module', 'nyulmc_findadoc');
require_once ($modulePath . '/nyulmc_findadoc_template_cache_inc.php');
print fad_getTopCache();

?>


<div id="content">
  <div class="wrapper">
		<div id="print-logo" style="display: none;"><img border="0" height="73" src="/<?php echo(path_to_theme());?>/images_layout/nyu_logo_print.jpg" width="377" /></div>
  
    <?php $column_main_class = 'column_main_fad'; ?> 

    <div id="trails">
    
      <?php if ($breadcrumb): ?>
        <?php print $breadcrumb; ?>
      <?php endif; ?>

      <?php if ($node_links): ?>
        <?php print $node_links; ?>
      <?php endif; ?>
      
    </div>
    
    <?php if ($messages): ?>
      <?php print $messages; ?>
    <?php endif; ?>

    <?php if ($help): ?>
      <div class="help"><?php print $help; ?></div>
    <?php endif; ?>

    <?php if ($tabs): ?>
      <?php print $tabs; ?>
    <?php endif; ?>
	
	<div id="column_main" class="<?php print $column_main_class; ?>">
    <?php print $content; ?>
	</div>
  </div>
</div>

<?php
print fad_getBottomCache();
?>
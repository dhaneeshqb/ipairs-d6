<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 *
 * Note: $id starts with 1, not 0.
 *
 * Built in vars from get_defined_vars:
 * [0] => template_file [1] => variables [2] => template_files [3] => view [4] => options [5] => rows [6] => title [7] => zebra [8] => id [9] => directory [10] => is_admin [11] => is_front [12] => logged_in [13] => db_is_active [14] => user [15] => classes ) 
 *
 */
?>
<?php $css_class = (empty($css_class)) ? $variables['view']->display['default']->display_options['css_class'] : $css_class; ?>

<?php $count = $variables['view']->total_rows; ?>
<?php $index = $variables['view']->row_index; ?>
<?php 

  $tag = 'div';
  $enclose = TRUE;
  $add_class = '';
  
  $row_item_class = ($id == 1) ? ' first ' : '';
    
  switch ($css_class) { 
    case 'display-directions':
    case 'display-banners':
      $enclose = FALSE;
      break;
    case 'display-clinical':
	  // This is a dirty columner.
	  // Tracking iterations and such became more time consuming than was possible to address
	  $column = TRUE;
	  break;
    case 'display-milestones':
	  $per = 3;
	  $tag = 'li';
      $enclose = FALSE;
      $wrap = TRUE;
	  break;
  }

  switch ($css_class) { 
    case 'display-sections':
    case 'display-buckets':
      $add_class = ' link_block';
      break;
  }
  
?>
<?php if (!empty($rows)): ?>
  <?php if ($column && ($id == 10)): ?></div><?php endif; ?>
  <?php if ($column && ($id == 1 || $id == 10)): ?><div class="view-column"><?php endif; ?>
  <?php if ($enclose): ?><div class="row-item <?php print $row_item_class; ?>"><?php endif; ?>
  <?php if (!empty($title)): ?><h2 class="row-title"><?php print $title; ?></h2><?php endif; ?>
    <?php foreach ($rows as $rowid => $row): ?>
      <?php
        $bookend->css   = '';
        $bookend->open  = FALSE;
        $bookend->close = FALSE;
	    if ($per > 0):
	      $bookend->css   .= ($rowid % $per == 0) ? 'first' : '';
	      $bookend->open   = ($rowid % $per == 0) ? TRUE : FALSE;
	      $bookend->css   .= ($rowid % $per == $per - 1 || $rowid == $count - 1) ? 'last' : '';
	      $bookend->close  = ($rowid % $per == $per - 1 || $rowid == $count - 1) ? TRUE : FALSE;
	    endif;
      ?>
      <?php if ($bookend->open): ?><<?php print $tag; ?> class="group-row-item"><?php endif; ?>
      <?php if ($enclose || $wrap): ?><div class="<?php print $classes[$rowid] . $add_class; ?> <?php print $bookend->css;?>"><?php endif; ?>
      <?php print $row; ?>
      <?php if ($enclose || $wrap): ?></div><?php endif; ?>
      <?php if ($bookend->close): ?></<?php print $tag; ?>><?php endif; ?>
    <?php endforeach; ?>
  <?php if ($enclose): ?></div><?php endif; ?>
  <?php if ($column && $index == ($count - 1)): ?></div><?php endif; ?>
<?php endif; ?>
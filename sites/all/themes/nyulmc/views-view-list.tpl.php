<?php
// $Id: views-view-list.tpl.php,v 1.3 2008/09/30 19:47:11 merlinofchaos Exp $
/**
 * @file views-view-list.tpl.php
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>

<?php $css_class = (empty($css_class)) ? $variables['view']->display['default']->display_options['css_class'] : $css_class; ?>

<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
   
<<?php print $options['type']; ?> class="<?php print $css_class; ?>">
  <?php foreach ($rows as $id => $row): ?>
    <?php
      // Let's append some classes on the items we're displaying
      switch (TRUE) {
        case $id == 0:
          $classes[$id] .= ' first';
          break;
        case $id == (count($rows) - 1):
          $classes[$id] .= ' last';
          break;
      }
	  switch ($css_class) {
        case 'display-buttons':
          $classes[$id] .= (!$view->result[$id]->node_data_field_button_image_field_button_image_fid[0]['fid']) ? ' gift_link' : '';
          break;
        case 'display-people':
          $classes[$id] .= (!$view->result[$id]->node_data_field_button_image_field_button_image_fid) ? ' cover' : '';
          break;
      }
    ?>
    <li class="<?php print $classes[$id]; ?> test-12"><?php print $row; ?></li>
  <?php endforeach; ?>
</<?php print $options['type']; ?>>
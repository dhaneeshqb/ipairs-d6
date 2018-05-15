<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php $css_class = (empty($css_class)) ? $variables['view']->display['default']->display_options['css_class'] : $css_class; ?>
<?php 
  switch ($css_class) { 
    case 'display-buttons':
    case 'display-banners':
    case 'display-clinical':
    case 'display-sections':
    case 'display-buckets':
    case 'display-home-slider':
    case 'display-people':
	  $enclose = FALSE;
	  break;
	default:
	  $enclose = TRUE;
	  break;
  }
?>
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?><?php print $field->separator; ?><?php endif; ?>
  <?php if ($field->label): ?><label class="views-label-<?php print $field->class; ?>"><?php print $field->label; ?>:</label><?php endif; ?>
  <?php if ($enclose): ?>
    <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
	?>
    <?php
	  // We need some exceptions for certain fields. These will override view-sets
	  switch ($field->class) {
	    case 'field-timeline-year-value':
		  $field->element_type = 'h2';
		  break;
	    case 'field-timeline-image-fid':
		  $field->element_type = 'div';
		  break;
	  }
    ?>
    <<?php print $field->element_type; ?> class="field-content <?php print $css_class .'-'.$field->class; ?>"><?php print $field->content; ?></<?php print $field->element_type; ?>>
  <?php else: ?>
    <?php print $field->content; ?>
  <?php endif; ?>
<?php endforeach; ?>
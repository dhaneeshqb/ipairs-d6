<?php
// $Id: content-field.tpl.php,v 1.1.2.6 2009/09/11 09:20:37 markuspetrux Exp $

/**
 * @file content-field.tpl.php
 * Default theme implementation to display the value of a field.
 *
 * Available variables:
 * - $node: The node object.
 * - $field: The field array.
 * - $items: An array of values for each item in the field array.
 * - $teaser: Whether this is displayed as a teaser.
 * - $page: Whether this is displayed as a page.
 * - $field_name: The field name.
 * - $field_type: The field type.
 * - $field_name_css: The css-compatible field name.
 * - $field_type_css: The css-compatible field type.
 * - $label: The item label.
 * - $label_display: Position of label display, inline, above, or hidden.
 * - $field_empty: Whether the field has any valid value.
 *
 * Each $item in $items contains:
 * - 'view' - the themed view for that item
 *
 * @see template_preprocess_content_field()
 */
?>
<?php
  // We have to treat fields in the people content type a little specifically.
  // We isolate the fields here and set their container type.
  switch ($field_name_css) {
    case 'field-leadership-image':
  	  $tag = FALSE;
  	  break;
    case 'field-leadership-title':
  	  $tag = 'span';
  	  break;
    case 'field-department-teaser':
    case 'field-landing-teaser':
  	  $tag = 'h1';
  	  break;
		case 'field-page':
			$prefix = '<div class="field-page-group"><ul class="field-page-group">';
			$suffix = '</ul></div>';
			$row_prefix = '<li class="field-page-item">';
			$row_prefix_first = '<li class="field-page-item first">';
			$row_suffix = '</li>';
  	default:
  	  $tag = 'div';
  	  break;
  }
?>
<?php if (!$field_empty) : ?>
  <?php if ($label_display == 'above') : ?>
    <div class="field-label field-label-<?php print $field_name_css; ?>"><?php print t($label) ?>:&nbsp;</div>
  <?php endif;?>
    <?php $count = 1;
		print $prefix;
    foreach ($items as $delta => $item) :
      if (!$item['empty']) : ?>
      	<?php if ($count == 1) { print $row_prefix_first; } else { print $row_prefix; } ?>
        <?php if ($tag !== FALSE) : ?><<?php print $tag; ?> class="field-item <?php print ($count == 1 ? 'first' : '') ?> <?php print ($count % 2 ? 'odd' : 'even') ?> <?php print $field_name_css; ?>"><?php endif;?>
          <?php if ($label_display == 'inline') { ?>
            <span class="field-label-inline<?php print($delta ? '' : '-first')?>">
              <?php print t($label) ?>:&nbsp;</span>
          <?php } ?>
          <?php print $item['view'] ?>
        <?php if ($tag !== FALSE) : ?></<?php print $tag; ?>><?php endif;?>
				<?php print $row_suffix; ?>
      <?php $count++;
      endif;
    endforeach;?>
    <?php print $suffix; ?>
<?php endif; ?>
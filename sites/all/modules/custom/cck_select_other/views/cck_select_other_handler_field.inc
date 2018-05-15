<?php
//$Id: cck_select_other_handler_field.inc,v 1.1.2.1 2010/11/05 20:01:34 mradcliffe Exp $
/**
 * @file
 */


/**
 * Extension to the Content Field Handler class for CCK Select Other
 */
class cck_select_other_handler_field extends content_handler_field {

  function render($values) {
    $values = parent::render($values);
    $field = content_fields($this->content_field['field_name'], $values->{$this->aliases['type']});
    $options = cck_select_other_options($field);

    return isset($options[$values]) ? $options[$values] : $values;
  }
}

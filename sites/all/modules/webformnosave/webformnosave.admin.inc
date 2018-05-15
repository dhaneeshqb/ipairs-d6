<?php
// $Id$

/**
 * Admin settings
 */
function webformnosave_admin_settings($form_state) {
  $form = array();

  $form['webformnosave'] = array(
    '#type' => 'checkbox',
    '#title' => t('Disable the storage of webforms in database'),
    '#default_value' => variable_get('webformnosave', false),
  );

  $form['webformnosave_excluded'] = array(
    '#type' => 'textarea',
    '#title' => t('Excluded node ids from data storage'),
    '#description' => t('Comma seperated list without spaces, eg 1,2,3,5,8'),
    '#default_value' => variable_get('webformnosave_excluded', ''),
  );

  return system_settings_form($form);
}
<?php
// $Id: markup.inc,v 1.13.2.5 2010/10/18 07:20:54 quicksketch Exp $

/**
 * @file
 * Loisform module markup component.
 */

/**
 * Implementation of _loisform_defaults_component().
 */
function _loisform_defaults_markup() {
  return array(
    'name' => '',
    'form_key' => NULL,
    'pid' => 0,
    'weight' => 0,
    'value' => '',
    'extra' => array(
      'format' => FILTER_FORMAT_DEFAULT,
    ),
  );
}

/**
 * Implementation of _loisform_edit_component().
 */
function _loisform_edit_markup($component) {
  $form = array();
  $form['markup']['value'] = array(
    '#type' => 'textarea',
    '#title' => t('Value'),
    '#default_value' => $component['value'],
    '#description' => t('Markup allows you to enter custom HTML or PHP logic into your form.') . theme('loisform_token_help'),
    '#weight' => -1,
    '#parents' => array('value'),
  );
  // Add the filter form.
  $form['markup']['format'] = filter_form($component['extra']['format'], 0, array('extra', 'format'));

  $form['extra']['description'] = array(); // No description for markup.
  $form['display'] = array('#type' => 'markup'); // Hide the display options.
  $form['display']['title_display'] = array();

  return $form;
}

/**
 * Implementation of _loisform_render_component().
 */
function _loisform_render_markup($component, $value = NULL, $filter = TRUE) {
  $element = array(
    '#type' => 'markup',
    '#title' => $filter ? NULL : $component['name'],
    '#weight' => $component['weight'],
    '#markup' => $filter ? _loisform_filter_values(check_markup($component['value'], $component['extra']['format'], FALSE), NULL, NULL, NULL, FALSE) : $component['value'],
    '#input_format' => $component['extra']['format'],
    '#theme_wrappers' => array('loisform_element_wrapper'),
    '#post_render' => array('loisform_element_wrapper'),
    '#loisform_component' => $component,
  );

  // TODO: Remove when #markup becomes available in D7.
  $element['#value'] = $element['#markup'];

  return $element;
}

/**
 * Implementation of _loisform_display_component().
 */
function _loisform_display_markup($component, $value, $format = 'html') {
  return array();
}

<?php

/**
 * @file
 * Webform module layout_box component.
 */

/**
 * Implements _webform_defaults_component().
 */
function _webform_defaults_layout_box() {
  return array(
    'name' => '',
    'form_key' => NULL,
    'pid' => 0,
    'weight' => 0,
    'extra' => array(
      'private' => FALSE,
      'align' => 'horiz',
    ),
  );
}

/**
 * Implements _webform_edit_component().
 */
function _webform_edit_layout_box($component) {
  $form = array();
  $form['display']['align'] = array(
    '#type' => 'select',
    '#title' => t('Alignment'),
    '#default_value' => $component['extra']['align'],
    '#description' => t('Controls how elements are arranged in this container. Choose "horizontal" to create a row, or "equal width" to create a row with equal column widths. The "vertical" option can be used to make columns within a horizontal box.'),
    '#parents' => array('extra', 'align'),
    '#options' => array(
      'horiz' => t('Horizontal'),
      'equal' => t('Equal Width'),
      'vert' => t('Vertical'),
    ),
  );
  $form['extra']['description'] = array(); // Hide the description box.
  return $form;
}

/**
 * Implements _webform_render_component().
 */
function _webform_render_layout_box($component, $value = NULL, $filter = TRUE) {
  $element = array(
    '#weight' => $component['weight'],
    '#pre_render' => array('webform_layout_box_prerender'),
    '#webform_component' => $component,
    '#prefix' => '<div>',
    '#suffix' => '</div>',
  );
  drupal_add_css(drupal_get_path('module', 'webform_layout') . '/layout_box.css');
  return $element;
}

/**
 * Pre-render function to set a layout_box ID and classes.
 */
function webform_layout_box_prerender($element) {
  $classes = array('webform-layout-box', $element['#webform_component']['extra']['align']);
  if ($element['#webform_component']['extra']['align'] == 'equal'
  && ($n = count($element['#webform_component']['children'])) > 1) {
    $classes[] = 'child-width-' . $n;
  }
  $id = 'webform-component-' . str_replace('_', '-', implode('--', array_slice($element['#parents'], 1)));
  $element['#prefix'] = '<div id="' . $id . '" class="' . implode(' ', $classes) . '">';
  return $element;
}

/**
 * Implements _webform_display_component().
 */
function _webform_display_layout_box($component, $value, $format = 'html') {
  if ($format == 'text') {
    $element = array(
      '#title' => $component['name'],
      '#weight' => $component['weight'],
      '#theme_wrappers' => array('webform_element_text'),
    );
  }
  else {
    $element = _webform_render_layout_box($component, $value);
  }

  $element['#webform_component'] = $component;
  $element['#format'] = $format;

  return $element;
}

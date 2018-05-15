<?php
// $Id: pagebreak.inc,v 1.9.2.1 2010/09/28 22:43:56 quicksketch Exp $

/**
 * @file
 * Loisform module page break component.
 */

/**
 * Implementation of _loisform_defaults_component().
 */
function _loisform_defaults_pagebreak() {
  return array(
    'name' => '',
    'form_key' => NULL,
    'pid' => 0,
    'weight' => 0,
    'extra' => array(),
  );
}

/**
 * Implementation of _loisform_theme_component().
 */
function _loisform_theme_pagebreak() {
  return array(
    'loisform_display_pagebreak' => array(
      'arguments' => array('element' => NULL),
    ),
  );
}

/**
 * Implementation of _loisform_edit_component().
 */
function _loisform_edit_pagebreak($component) {
  $form = array();
  // Force the parent to always be root.
  $form['position']['pid'] = array(
    '#type' => 'hidden',
    '#value' => '0',
  );

  $form['extra']['description'] = array();  // No description.
  $form['display'] = array('#type' => 'markup'); // Hide the display options.
  $form['display']['title_display'] = array();

  return $form;
}

/**
 * Implementation of _loisform_render_component().
 */
function _loisform_render_pagebreak($component, $value = NULL, $filter = TRUE) {
  $element = array(
    '#type' => 'hidden',
    '#value' => $component['name'],
    '#weight' => $component['weight'],
  );
  return $element;
}

/**
 * Implementation of _loisform_render_component().
 */
function _loisform_display_pagebreak($component, $value = NULL, $format = 'html') {
  $element = array(
    '#theme' => 'loisform_display_pagebreak',
    '#title' => $component['name'],
    '#weight' => $component['weight'],
    '#format' => $format,
    '#loisform_component' => $component,
  );
  return $element;
}

/**
 * Format the text output data for this component.
 */
function theme_loisform_display_pagebreak($element) {
  return $element['#format'] == 'html' ? '<h2 class="loisform-page">' . check_plain($element['#title']) . '</h2>' : "--" . $element['#title'] . "--\n";
}

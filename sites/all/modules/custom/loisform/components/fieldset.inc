<?php
// $Id: fieldset.inc,v 1.11.2.6 2010/10/19 04:53:38 quicksketch Exp $

/**
 * @file
 * Loisform module fieldset component.
 */

/**
 * Implementation of _loisform_defaults_component().
 */
function _loisform_defaults_fieldset() {
  return array(
    'name' => '',
    'form_key' => NULL,
    'pid' => 0,
    'weight' => 0,
    'extra' => array(
      'title_display' => 0,
      'collapsible' => 0,
      'collapsed' => 0,
      'description' => '',
    ),
  );
}

/**
 * Implementation of _loisform_edit_component().
 */
function _loisform_edit_fieldset($component) {
  $form = array();
  $form['display']['collapsible'] = array(
    '#type' => 'checkbox',
    '#title' => t('Collapsible'),
    '#default_value' => $component['extra']['collapsible'],
    '#description' => t('If this fieldset is collapsible, the user may open or close the fieldset.'),
    '#weight' => 0,
    '#parents' => array('extra', 'collapsible'),
  );
  $form['display']['collapsed'] = array(
    '#type' => 'checkbox',
    '#title' => t('Collapsed by Default'),
    '#default_value' => $component['extra']['collapsed'],
    '#description' => t('Collapsible fieldsets are "open" by default. Select this option to default the fieldset to "closed."'),
    '#weight' => 3,
    '#parents' => array('extra', 'collapsed'),
  );
  return $form;
}

/**
 * Implementation of _loisform_render_component().
 */
function _loisform_render_fieldset($component, $value = NULL, $filter = TRUE) {
  $element = array(
    '#type' => $component['type'],
    '#title' => $filter ? _loisform_filter_xss($component['name']) : $component['name'],
    '#title_display' => $component['extra']['title_display'] ? $component['extra']['title_display'] : NULL,
    '#weight' => $component['weight'],
    '#description' => $filter ? _loisform_filter_descriptions($component['extra']['description']) : $component['extra']['description'],
    '#collapsible' => $component['extra']['collapsible'],
    '#collapsed' => $component['extra']['collapsed'],
    '#attributes' => array('class' => 'loisform-component-' . $component['type']),
    '#pre_render' => array('loisform_fieldset_prerender', 'loisform_element_title_display'),
    '#loisform_component' => $component,
  );

  return $element;
}

/**
 * Pre-render function to set a fieldset ID.
 */
function loisform_fieldset_prerender($element) {
  $element['#attributes']['id'] = 'loisform-component-' . str_replace('_', '-', implode('--', array_slice($element['#parents'], 1)));
  return $element;
}

/**
 * Implementation of _loisform_display_component().
 */
function _loisform_display_fieldset($component, $value, $format = 'html') {
  if ($format == 'text') {
    $element = array(
      '#title' => $component['name'],
      '#weight' => $component['weight'],
      '#post_render' => array('loisform_element_wrapper'),
      '#theme_wrappers' => array('loisform_element_text'),
    );
  }
  else {
    $element = _loisform_render_fieldset($component, $value);
  }

  $element['#loisform_component'] = $component;
  $element['#format'] = $format;

  return $element;
}

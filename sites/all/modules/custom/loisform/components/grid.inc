<?php
// $Id: grid.inc,v 1.14.2.14 2010/10/18 07:20:54 quicksketch Exp $

/**
 * @file
 * Loisform module grid component.
 */

// Grid depends on functions provided by select.
loisform_component_include('select');

/**
 * Implementation of _loisform_defaults_component().
 */
function _loisform_defaults_grid() {
  return array(
    'name' => '',
    'form_key' => NULL,
    'mandatory' => 0,
    'pid' => 0,
    'weight' => 0,
    'extra' => array(
      'options' => '',
      'questions' => '',
      'optrand' => 0,
      'qrand' => 0,
      'title_display' => 0,
      'custom_option_keys' => 0,
      'custom_question_keys' => 0,
      'description' => '',
    ),
  );
}


/**
 * Implementation of _loisform_theme_component().
 */
function _loisform_theme_grid() {
  return array(
    'loisform_grid' => array(
      'arguments' => array('grid_element' => NULL),
    ),
    'loisform_display_grid' => array(
      'arguments' => array('element' => NULL),
    ),
  );
}

/**
 * Implementation of _loisform_edit_component().
 */
function _loisform_edit_grid($component) {
  $form = array();

  if (module_exists('options_element')) {
    $form['options'] = array(
      '#type' => 'fieldset',
      '#title' => t('Options'),
      '#collapsible' => TRUE,
      '#description' => t('Options to select across the top. Usually these are ratings such as "poor" through "excellent" or "strongly disagree" through "strongly agree".'),
      '#attributes' => array('class' => 'loisform-options-element'),
      '#element_validate' => array('_loisform_edit_validate_options'),
    );
    $form['options']['options'] = array(
      '#type' => 'options',
      '#options' => _loisform_select_options_from_text($component['extra']['options'], TRUE),
      '#optgroups' => FALSE,
      '#default_value' => FALSE,
      '#optgroups' => FALSE,
      '#key_type' => 'mixed',
      '#key_type_toggle' => t('Customize option keys (Advanced)'),
      '#key_type_toggled' => $component['extra']['custom_option_keys'],
    );

    $form['questions'] = array(
      '#type' => 'fieldset',
      '#title' => t('Questions'),
      '#collapsible' => TRUE,
      '#description' => t('Questions list down the side of the grid.'),
      '#attributes' => array('class' => 'loisform-options-element'),
      '#element_validate' => array('_loisform_edit_validate_options'),
    );
    $form['questions']['options'] = array(
      '#type' => 'options',
      '#options' => _loisform_select_options_from_text($component['extra']['questions'], TRUE),
      '#optgroups' => FALSE,
      '#default_value' => FALSE,
      '#optgroups' => FALSE,
      '#key_type' => 'mixed',
      '#key_type_toggle' => t('Customize question keys (Advanced)'),
      '#key_type_toggled' => $component['extra']['custom_question_keys'],
    );
  }
  else {
    $form['extra']['options'] = array(
      '#type' => 'textarea',
      '#title' => t('Options'),
      '#default_value' => $component['extra']['options'],
      '#description' => t('Options to select across the top. One option per line. Key-value pairs must be entered separated by pipes. i.e. safe_key|Some readable option') . theme('loisform_token_help'),
      '#cols' => 60,
      '#rows' => 5,
      '#weight' => -3,
      '#required' => TRUE,
      '#wysiwyg' => FALSE,
      '#element_validate' => array('_loisform_edit_validate_select'),
    );
    $form['extra']['questions'] = array(
      '#type' => 'textarea',
      '#title' => t('Questions'),
      '#default_value' => $component['extra']['questions'],
      '#description' => t('Questions list down the side of the grid. One question per line. Key-value pairs must be entered separated by pipes. i.e safe_key|Some readable option') . theme('loisform_token_help'),
      '#cols' => 60,
      '#rows' => 5,
      '#weight' => -2,
      '#required' => TRUE,
      '#wysiwyg' => FALSE,
      '#element_validate' => array('_loisform_edit_validate_select'),
    );
  }

  $form['display']['optrand'] = array(
    '#type' => 'checkbox',
    '#title' => t('Randomize Options'),
    '#default_value' => $component['extra']['optrand'],
    '#description' => t('Randomizes the order of options on the top when they are displayed in the form.'),
    '#parents' => array('extra', 'optrand')
  );
  $form['display']['qrand'] = array(
    '#type' => 'checkbox',
    '#title' => t('Randomize Questions'),
    '#default_value' => $component['extra']['qrand'],
    '#description' => t('Randomize the order of the questions on the side when they are displayed in the form.'),
    '#parents' => array('extra', 'qrand')
  );
  return $form;
}

/**
 * Implementation of _loisform_render_component().
 */
function _loisform_render_grid($component, $value = NULL, $filter = TRUE) {
  $element = array(
    '#title' => $filter ? _loisform_filter_xss($component['name']) : $component['name'],
    '#title_display' => $component['extra']['title_display'] ? $component['extra']['title_display'] : 'before',
    '#required' => $component['mandatory'],
    '#weight' => $component['weight'],
    '#description' => $filter ? _loisform_filter_descriptions($component['extra']['description']) : $component['extra']['description'],
    '#theme' => 'loisform_grid',
    '#theme_wrappers' => array('loisform_element_wrapper'),
    '#pre_render' => array('loisform_element_title_display'),
    '#post_render' => array('loisform_element_wrapper'),
    '#loisform_component' => $component,
  );

  $questions = _loisform_select_options_from_text($component['extra']['questions'], TRUE);
  $options = _loisform_select_options_from_text($component['extra']['options'], TRUE);

  if ($component['extra']['optrand']) {
    _loisform_shuffle_options($options);
  }

  if ($component['extra']['qrand']) {
    _loisform_shuffle_options($questions);
  }

  foreach ($questions as $key => $question) {
    if ($question != '') {
      $element[$key] = array(
        '#title' => $question,
        '#required' => $component['mandatory'],
        '#options' => $options,
        '#type' => 'radios',
        '#process' => array('expand_radios', 'loisform_expand_select_ids'),

        // Loisform handles validation manually.
        '#validated' => TRUE,
        '#loisform_validated' => FALSE,
      );
    }
  }

  if (isset($value)) {
    foreach (element_children($element) as $key) {
      $element[$key]['#default_value'] = isset($value[$key]) ? $value[$key] : NULL;
    }
  }

  return $element;
}

/**
 * Implementation of _loisform_display_component().
 */
function _loisform_display_grid($component, $value, $format = 'html') {
  $questions = _loisform_select_options_from_text($component['extra']['questions'], TRUE);
  $options = _loisform_select_options_from_text($component['extra']['options'], TRUE);

  $element = array(
    '#title' => $component['name'],
    '#weight' => $component['weight'],
    '#format' => $format,
    '#questions' => $questions,
    '#options' => $options,
    '#theme' => 'loisform_display_grid',
    '#theme_wrappers' => $format == 'html' ? array('loisform_element', 'loisform_element_wrapper') : array('loisform_element_text'),
    '#post_render' => array('loisform_element_wrapper'),
    '#sorted' => TRUE,
    '#loisform_component' => $component,
  );

  foreach ($questions as $key => $question) {
    if ($question !== '') {
      $element[$question] = array(
        '#title' => $question,
        '#value' => isset($value[$key]) ? $value[$key] : NULL,
      );
    }
  }

  return $element;
}

/**
 * Format the text output for this component.
 */
function theme_loisform_display_grid($element) {
  $component = $element['#loisform_component'];
  $format = $element['#format'];

  if ($format == 'html') {
    $rows = array();
    $header = array(array('data' => '', 'class' => 'loisform-grid-question'));
    foreach ($element['#options'] as $option) {
      $header[] = array('data' => _loisform_filter_xss($option), 'class' => 'checkbox loisform-grid-option');
    }
    foreach (element_children($element) as $key) {
      $row = array();
      $row[] = array('data' => _loisform_filter_xss($element[$key]['#title']), 'class' => 'loisform-grid-question');
      foreach ($element['#options'] as $option_value => $option_label) {
        if (strcmp($option_value, $element[$key]['#value']) == 0) {
          $row[] = array('data' => '<strong>X</strong>', 'class' => 'checkbox loisform-grid-option');
        }
        else {
          $row[] = array('data' => '&nbsp', 'class' => 'checkbox loisform-grid-option');
        }
      }
      $rows[] = $row;
    }

    $option_count = count($header) - 1;
    $output = theme('table', $header, $rows, array('class' => 'loisform-grid loisform-grid-' . $option_count));
  }
  else {
    $items = array();
    foreach (element_children($element) as $key) {
      $items[] = ' - ' . $element[$key]['#title'] . ': ' . (isset($element['#options'][$element[$key]['#value']]) ? $element['#options'][$element[$key]['#value']] : '');
    }
    $output = implode("\n", $items);
  }

  return $output;
}

/**
 * Implementation of _loisform_analysis_component().
 */
function _loisform_analysis_grid($component, $sids = array()) {
  // Generate the list of options and questions.
  $options = _loisform_select_options_from_text($component['extra']['options'], TRUE);
  $questions = _loisform_select_options_from_text($component['extra']['questions'], TRUE);

  // Generate a lookup table of results.
  $placeholders = count($sids) ? array_fill(0, count($sids), "'%s'") : array();
  $sidfilter = count($sids) ? " AND sid in (" . implode(",", $placeholders) . ")" : "";
  $query = 'SELECT no, data, count(data) as datacount ' .
    ' FROM {loisform_submitted_data} ' .
    ' WHERE nid = %d ' .
    ' AND cid = %d ' .
    " AND data != '' " . $sidfilter .
    ' GROUP BY no, data';
  $result = db_query($query, array_merge(array($component['nid'], $component['cid']), $sids));
  $counts = array();
  while ($data = db_fetch_object($result)) {
    $counts[$data->no][$data->data] = $data->datacount;
  }

  // Create an entire table to be put into the returned row.
  $rows = array();
  $header = array('');

  // Add options as a header row.
  foreach ($options as $option) {
    $header[] = _loisform_filter_xss($option);
  }

  // Add questions as each row.
  foreach ($questions as $qkey => $question) {
    $row = array(_loisform_filter_xss($question));
    foreach ($options as $okey => $option) {
      $row[] = !empty($counts[$qkey][$okey]) ? $counts[$qkey][$okey] : 0;
    }
    $rows[] = $row;
  }
  $output = theme('table', $header, $rows, array('class' => 'loisform-grid'));


  return array(array(array('data' => $output, 'colspan' => 2)));
}

/**
 * Implementation of _loisform_table_component().
 */
function _loisform_table_grid($component, $value) {
  $questions = _loisform_select_options_from_text($component['extra']['questions'], TRUE);
  $options = _loisform_select_options_from_text($component['extra']['options'], TRUE);

  $output = '';
  // Set the value as a single string.
  foreach ($questions as $key => $label) {
    if (isset($value[$key]) && isset($options[$value[$key]])) {
      $output .= _loisform_filter_xss($label) . ': ' . _loisform_filter_xss($options[$value[$key]]) . '<br />';
    }
  }

  return $output;
}

/**
 * Implementation of _loisform_csv_headers_component().
 */
function _loisform_csv_headers_grid($component, $export_options) {
  $header = array();
  $header[0] = array('');
  $header[1] = array($component['name']);
  $items = _loisform_select_options_from_text($component['extra']['questions'], TRUE);
  $count = 0;
  foreach ($items as $key => $item) {
    // Empty column per sub-field in main header.
    if ($count != 0) {
      $header[0][] = '';
      $header[1][] = '';
    }
    // The value for this option.
    $header[2][] = $item;
    $count++;
  }

  return $header;
}

/**
 * Implementation of _loisform_csv_data_component().
 */
function _loisform_csv_data_grid($component, $export_options, $value) {
  $questions = _loisform_select_options_from_text($component['extra']['questions'], TRUE);
  $options = _loisform_select_options_from_text($component['extra']['options'], TRUE);
  $return = array();
  foreach ($questions as $key => $question) {
    if (isset($value[$key]) && isset($options[$value[$key]])) {
      $return[] = $export_options['select_keys'] ? $value[$key] : $options[$value[$key]];
    }
  }
  return $return;
}

function theme_loisform_grid($element) {
  $rows = array();
  $header = array(array('data' => '', 'class' => 'loisform-grid-question'));
  $first = TRUE;
  foreach (element_children($element) as $key) {
    $question_element = $element[$key];

    // Set the header for the table.
    if ($first) {
      foreach ($question_element['#options'] as $option) {
        $header[] = array('data' => _loisform_filter_xss($option), 'class' => 'checkbox loisform-grid-option');
      }
      $first = FALSE;
    }

    // Create a row with the question title.
    $row = array(array('data' => _loisform_filter_xss($question_element['#title']), 'class' => 'loisform-grid-question'));

    // Render each radio button in the row.
    $radios = expand_radios($question_element);
    foreach (element_children($radios) as $key) {
      unset($radios[$key]['#title']);
      $row[] = array('data' => drupal_render($radios[$key]), 'class' => 'checkbox loisform-grid-option');
    }
    $rows[] = $row;
  }

  $option_count = count($header) - 1;
  return theme('form_element', $element, theme('table', $header, $rows, array('class' => 'loisform-grid loisform-grid-' . $option_count)));
}

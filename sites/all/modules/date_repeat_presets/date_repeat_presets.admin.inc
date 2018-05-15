<?php
// $Id: date_repeat_presets.admin.inc,v 1.1 2010/11/13 23:17:10 chaps2 Exp $
/**
 * @file
 * Administration of repeat rule presets.
 */

/**
 * Alter the date field admin form to allow configurable presets.
 */
function _date_repeat_presets_admin_form_alter(&$form, &$form_state, $form_id) {
  ahah_helper_register($form, $form_state);

  module_load_include('inc', 'date_repeat_presets', 'date_repeat_presets');
  $settings = _date_repeat_presets_get_settings($form['#field']);

  // handle ahah callback form state - display options for multiple preset selection or single preset
  if (isset($form_state['storage']['repeat_presets']['type'])) {
    $preset_type = $form_state['storage']['repeat_presets']['type'];
  }
  else {
    $preset_type = $settings['type'];
  }

  $form['field']['repeat_presets'] = array(
    '#tree' => TRUE,
    '#prefix' => '<div id="repeat-presets-wrapper">', // This is our wrapper div.
    '#suffix' => '</div>',
    '#weight' => $form['field']['repeat_collapsed']['#weight'] + 1,
    );

  $form['field']['repeat_presets']['type'] = array(
    '#type' => 'radios',
    '#title' => t('Preset type'),
    '#description' => t('Select the type of repeat date entry form that is displayed on the node add/edit form.'),
    '#options' => array(
      'standard' => t('Standard repeat rule form'),
      'selection' => t('Selection of rules (optionally including custom)'),
      'single' => t('Single rule (automatic or optional)')),
    '#ahah'        => array(
        'path'    => ahah_helper_path(array('field', 'repeat_presets')),
        'wrapper' => 'repeat-presets-wrapper',
        'event'      => 'change'
    ),
    '#default_value' => $preset_type,
  );

  // setthis explicitly as the discovery in ahah_helper doesn't always work with newly added fields.
  $form_state['storage']['#ahah_helper']['file'] = drupal_get_path('module', 'content') . '/includes/content.admin.inc';

  // AHAH helper - provide this for non-js form update
  $form['field']['repeat_presets']['update_type'] = array(
    '#type'  => 'submit',
    '#value' => t('Update type'),
    '#submit' => array('ahah_helper_generic_submit'),
    '#attributes' => array('class' => 'no-js'),
  );

  // using storage as per ahah_helper instructions.
  $repeat_presets_storage = $form_state['storage']['repeat_presets'];

  // hide this as we spoof this in the presets ahah bit.
  $form['field']['repeat_collapsed']['#type'] = 'hidden';

  if ($preset_type == 'selection') {
    // Allow up to 5 presets
    $presets = $settings['preset'];

    $preset = current($presets);


    $form['field']['repeat_presets']['preset'] = array(
      '#tree' => TRUE,
      '#theme' => 'date_repeat_presets_presets',
      '#title' => t('Repeat date rule presets'),
    );


    for ($i = 0; $i < 5; $i++) {
      $key = 'preset' . $i;
      $preset_storage = $repeat_presets_storage['preset'][$key];
      if (!isset($preset)) {
        $preset = array('title' => '', 'rrule' => '');
      }
      $form['field']['repeat_presets']['preset'][$key] = array(
        '#type' => 'fieldset',
        '#tree' => TRUE,
      );
      $form['field']['repeat_presets']['preset'][$key]['enabled'] = array(
        '#type' => 'checkbox',
        '#default_value' => isset($preset_storage['enabled']) ? $preset_storage['enabled'] : $preset['enabled'],
        '#title' => t('Enabled'),
      );
      $form['field']['repeat_presets']['preset'][$key]['title'] = array(
        '#type' => 'textfield',
        '#default_value' => isset($preset_storage['title']) ? $preset_storage['title'] : $preset['title'],
        '#title' => t('Title'),
      );
      $form['field']['repeat_presets']['preset'][$key]['rrule'] = array(
        '#type' => 'textfield',
        '#default_value' => isset($preset_storage['rrule']) ? $preset_storage['rrule'] : $preset['rrule'],
        '#title' => t('Rrule'),
        '#description' => t('Enter valid RRULES to offer as preset repeat rules on the repeating date field. Include an X-ID in the RRULE to allow updated RRULEs to match to previous versions.'),
      );
      $preset = next($presets);
    }

    $form['field']['repeat_presets']['allow_custom'] = array(
      '#type' => 'checkbox',
      '#title' => t('Allow custom repeat rule entry'),
      '#default_value' => isset($repeat_presets_storage['allow_custom']) ? $repeat_presets_storage['allow_custom'] : $settings['allow_custom'],
      '#description' => t('Checking this option will add a "Custom" repeat date option. If the user selects this option the full repeating date option form will be presented to the user.'),
    );

    $form['field']['repeat_presets']['preset_ui'] = array(
      '#type' => 'radios',
      '#options' => array('radios' => t('Radios'), 'select' => t('Select')),
      '#title' => t('Presets display setting'),
      '#default_value' => isset($repeat_presets_storage['preset_ui']) ? $repeat_presets_storage['preset_ui'] : $settings['preset_ui'],
      '#description' => t('Display the preset rule options as radios or as a drop-down selection.'),
    );
  }
  elseif ($preset_type == 'single') {

    $auto_storage = $repeat_presets_storage['auto'];
    // optional single rule - different UI for different requirements
    // if not optional then the repeat rule is always applied.
    $form['field']['repeat_presets']['auto'] = array(
      '#title' => t('Auto repeat'),
      '#tree' => TRUE,
    );
    $form['field']['repeat_presets']['auto']['rrule'] = array(
      '#type' => 'textfield',
      '#title' => t('Rule to apply'),
      '#default_value' => isset($auto_storage['rrule']) ? $auto_storage['rrule'] : $settings['auto']['rrule'],
    );
    $form['field']['repeat_presets']['auto']['optional'] = array(
      '#type' => 'checkbox',
      '#title' => t('Repeat rule is optional'),
      '#description' => t('If optional a checkbox will be shown with the prompt text below.'),
      '#default_value' => isset($auto_storage['optional']) ? $auto_storage['optional'] : $settings['auto']['optional'],
    );
    $form['field']['repeat_presets']['auto']['text'] = array(
      '#type' => 'textfield',
      '#title' => t('Text to display'),
      '#default_value' => isset($auto_storage['text']) ? $auto_storage['text'] : $settings['auto']['text'],
    );
  }
  else {
    // display the repeat collapsed setting here
    $form['field']['repeat_presets']['repeat_collapsed'] = array(
      '#type' => 'radios',
      '#default_value' => isset($repeat_presets_storage['repeat_collapsed']) ? $repeat_presets_storage['repeat_collapsed'] : $form['field']['repeat_collapsed']['#default_value'],
      '#options' => array(0 => t('Expanded'), 1 => t('Collapsed')),
      '#title' => t('Repeat display'),
      '#description' => t("Should the repeat options form start out expanded or collapsed? Set to 'Collapsed' to make those options less obtrusive."),
      '#after_build' => array('date_repeat_presets_admin_repeat_collapsed_after_build'),
      );

  }
  $form['#submit'][] = 'date_repeat_presets_admin_form_submit';
}

/**
 * #after_build callback for our spoofed repeat_collapsed element. Sets the
 * element validation callback as it doesn't seem to stick in form_alter.
 */
function _date_repeat_presets_admin_repeat_collapsed_after_build($form, &$form_state) {
  $form['#element_validate'] = array('_date_repeat_presets_admin_repeat_collapsed_validate');
  return $form;
}

/**
 * #element_validate callback for spoofed repeat_collapsed element. Move value
 * into the proper widget form element and remove spoofed value so it doesn't
 * end up in the date_repeat_presets settings.
 */
function _date_repeat_presets_admin_repeat_collapsed_validate($form, &$form_state) {
  if (isset($form_state['values']['repeat_presets']['repeat_collapsed'])) {
    $form_state['values']['repeat_collapsed'] = $form_state['values']['repeat_presets']['repeat_collapsed'];
    unset($form_state['values']['repeat_presets']['repeat_collapsed']);
  }
}

/**
 * Submit callback which stores the extra preset settings in the variable table.
 */
function _date_repeat_presets_admin_form_submit($form, &$form_state) {
  variable_set('date_repeat_presets_'. $form['#field']['field_name'], $form_state['values']['repeat_presets']);
}

/**
 * Theme function for presets form element - display in table.
 */
function theme_date_repeat_presets_presets($form) {
  $rows = array();
  $elements = element_children($form);
  $first = $form[reset($form)];
  $headers = array(t('Title'), t('RRULE'), t('Enabled'));
  $notes = NULL;

  foreach ($elements as $key) {
    if (!$notes) {
      // get field descriptions for table notes
      $notes = array();
      if (!empty($form[$key]['title']['#description'])) {
        $notes[] = $form[$key]['title']['#description'];
      }
      if (!empty($form[$key]['rrule']['#description'])) {
        $notes[] = $form[$key]['rrule']['#description'];
      }
      if (!empty($form[$key]['enabled']['#description'])) {
        $notes[] = $form[$key]['enabled']['#description'];
      }
    }
    // Build the table row.
    unset($form[$key]['title']['#title']);
    unset($form[$key]['rrule']['#title']);
    unset($form[$key]['enabled']['#title']);

    unset($form[$key]['title']['#description']);
    unset($form[$key]['rrule']['#description']);
    unset($form[$key]['enabled']['#description']);

    // Add class for js tabledrag
    $form[$key]['attributes'] = array('class' => 'date-repeat-presets-admin-preset-weight');

    $form[$key]['title']['#size'] = 20;

    $row = array(
      'data' => array(
        array('data' => drupal_render($form[$key]['title'])),
        array('data' => drupal_render($form[$key]['rrule'])),
        array('data' => drupal_render($form[$key]['enabled'])),
      ),
    );

    $rows[] = $row;
  }


  $output = '<div class="form-item"><label>'. $form['#title'] .':<label>';
  $output .= theme('table', $headers, $rows, array('id' => 'date-repeat-presets-admin-presets-table'));


  // add notes pulled from form elements to the end of the table
  if (!empty($notes)) {
    $output .= theme('item_list', $notes, NULL, 'ul', array('class' => 'description'));
  }
  // end of form-item div.
  $output .= '</div>';


  return $output;
}
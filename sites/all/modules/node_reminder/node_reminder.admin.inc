<?php
/**
 * @file
 * Administration page callbacks for the Node Remminder module
 */

/**
 * Form builder. Configure Node Reminders.
 *
 * @ingroup forms
 * @see system_settings_form().
 */
function node_reminder_admin_settings() {
  $form['node_reminder_node_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Users may set reminders for these content types'),
    '#options' => node_get_types('names'),
    '#default_value' => variable_get('node_reminder_node_types', array()),
  );

  $form['node_reminder_message_subject'] = array(
    '#type' => 'textfield',
    '#title' => t('Subject of Node Reminder messages'),
    '#required' => TRUE,
    '#default_value' => node_reminder_subject(),
    '#description' => t('Token replacements for node types are supported'),
  );

  $form['node_reminder_message_body'] = array(
    '#type' => 'textarea',
    '#title' => t('Body of Node Reminder messages'),
    '#required' => TRUE,
    '#default_value' => node_reminder_body(),
    '#description' => t('Token replacements for node types are supported'),
  );

  $form['view']['token_help'] = array(
    '#title' => t('Replacement patterns'),
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['view']['token_help']['help'] = array(
    '#value' => theme('token_help', array('global', 'node')),
  );

  return system_settings_form($form);
}

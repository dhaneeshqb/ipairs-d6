<?php
// $Id: loisform.admin.inc,v 1.4.2.4 2010/08/30 20:22:15 quicksketch Exp $

/**
 * @file
 * Administration pages provided by Loisform module.
 */

/**
 * Menu callback for admin/settings/loisform.
 */
function loisform_admin_settings() {
  module_load_include('inc', 'loisform', 'includes/loisform.export');

  $node_types = node_get_types('names');
  $form['node_types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Loisform-enabled content types'),
    '#description' => t('Loisform allows you to enable the loisform components for any content type.  Choose the types on which you would like to associate loisform components.'),
    '#options' => $node_types,
    '#default_value' => loisform_variable_get('loisform_node_types'),
  );

  $form['components'] = array(
    '#type' => 'fieldset',
    '#title' => t('Available components'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#description' => t('These are the available field types for your installation of Loisform. You may disable any of these components by unchecking its corresponding box. Only checked components will be available in existing or new loisforms.'),
  );

  // Add each component to the form:
  $form['components'] = array('#tree' => TRUE);
  $component_types = loisform_components(TRUE);
  foreach ($component_types as $key => $component) {
    $form['components'][$key] = array(
      '#title' => $component['label'],
      '#description' => $component['description'],
      '#type' => 'checkbox',
      '#return_value' => 1,
      '#default_value' => $component['enabled'],
    );
  }

  $form['email'] = array(
    '#type' => 'fieldset',
    '#title' => t('Default e-mail values'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['email']['loisform_default_from_address']  = array(
    '#type' => 'textfield',
    '#title' => t('From address'),
    '#default_value' => variable_get('loisform_default_from_address', variable_get('site_mail', ini_get('sendmail_from'))),
    '#description' => t('The default sender address for emailed loisform results; often the e-mail address of the maintainer of your forms.'),
  );

  $form['email']['loisform_default_from_name']  = array(
    '#type' => 'textfield',
    '#title' => t('From name'),
    '#default_value' => variable_get('loisform_default_from_name', variable_get('site_name', '')),
    '#description' => t('The default sender name which is used along with the default from address.'),
  );

  $form['email']['loisform_default_subject']  = array(
    '#type' => 'textfield',
    '#title' => t('Default subject'),
    '#default_value' => variable_get('loisform_default_subject', t('Form submission from: %title')),
    '#description' => t('The default subject line of any e-mailed results.'),
  );

  $form['email']['loisform_default_format']  = array(
    '#type' => 'radios',
    '#title' => t('Format'),
    '#options' => array(
      0 => t('Plain text'),
      1 => t('HTML'),
    ),
    '#default_value' => variable_get('loisform_default_format', 0),
    '#description' => t('The default format for new e-mail settings. Loisform e-mail options take precedence over the settings for system-wide e-mails configured in MIME mail.'),
  );

  $form['email']['loisform_format_override']  = array(
    '#type' => 'radios',
    '#title' => t('Format override'),
    '#options' => array(
      0 => t('Per-loisform configuration of e-mail format'),
      1 => t('Send all e-mails in the default format'),
    ),
    '#default_value' => variable_get('loisform_format_override', 0),
    '#description' => t('Force all loisform e-mails to be sent in the default format.'),
  );

  $form['advanced'] = array(
    '#type' => 'fieldset',
    '#title' => t('Advanced options'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['advanced']['loisform_use_cookies']  = array(
    '#type' => 'checkbox',
    '#checked_value' => 1,
    '#title' => t('Allow cookies for tracking submissions'),
    '#default_value' => variable_get('loisform_use_cookies', 0),
    '#description' => t('<a href="http://www.wikipedia.org/wiki/HTTP_cookie">Cookies</a> can be used to help prevent the same user from repeatedly submitting a loisform. This feature is not needed for limiting submissions per user, though it can increase accuracy in some situations. Besides cookies, Loisform also uses IP addresses and site usernames to prevent repeated submissions.'),
  );

  $form['advanced']['loisform_email_address_format'] = array(
    '#type' => 'radios',
    '#title' => t('E-mail address format'),
    '#options' => array(
      'long' => t('Long format: "Example Name" &lt;name@example.com&gt;'),
      'short' => t('Short format: name@example.com'),
    ),
    '#default_value' => variable_get('loisform_email_address_format', 'long'),
    '#description' => t('Most servers support the "long" format which will allow for more friendly From addresses in e-mails sent. However many Windows-based servers are unable to send in the long format. Change this option if experiencing problems sending e-mails with Loisform.'),
  );

  $form['advanced']['loisform_export_format'] = array(
    '#type' => 'radios',
    '#title' => t('Default export format'),
    '#options' => loisform_export_list(),
    '#default_value' => variable_get('loisform_export_format', 'delimited'),
  );

  $form['advanced']['loisform_csv_delimiter']  = array(
    '#type' => 'select',
    '#title' => t('Default export delimiter'),
    '#description' => t('This is the delimiter used in the CSV/TSV file when downloading Loisform results. Using tabs in the export is the most reliable method for preserving non-latin characters. You may want to change this to another character depending on the program with which you anticipate importing results.'),
    '#default_value' => variable_get('loisform_csv_delimiter', '\t'),
    '#options' => array(
      ','  => t('Comma (,)'),
      '\t' => t('Tab (\t)'),
      ';'  => t('Semicolon (;)'),
      ':'  => t('Colon (:)'),
      '|'  => t('Pipe (|)'),
      '.'  => t('Period (.)'),
      ' '  => t('Space ( )'),
    ),
  );

  $form['advanced']['loisform_submission_access_control']  = array(
    '#type' => 'radios',
    '#title' => t('Submission access control'),
    '#options' => array(
      '1' => t('Select the user roles that may submit each individual loisform'),
      '0' => t('Disable Loisform submission access control'),
    ),
    '#default_value' => variable_get('loisform_submission_access_control', 1),
    '#description' => t('By default, the configuration form for each loisform allows the administrator to choose which roles may submit the form. You may want to allow users to always submit the form if you are using a separate node access module to control access to loisform nodes themselves.'),
  );

  $form = system_settings_form($form);
  $form['#theme'] = 'loisform_admin_settings';
  $form['#submit'][] = 'loisform_admin_settings_submit';

  return $form;
}

function loisform_admin_settings_submit($form, &$form_state) {
  $disabled_components = array();
  foreach ($form_state['values']['components'] as $name => $enabled) {
    if (!$enabled) {
      $disabled_components[] = $name;
    }
  }
  variable_set('loisform_disabled_components', $disabled_components);

  $loisform_types = array();
  foreach ($form_state['values']['node_types'] as $type) {
    if ($type) {
      $loisform_types[] = $type;
    }
  }
  variable_set('loisform_node_types', $loisform_types);
}

function theme_loisform_admin_settings($form) {
  // Format the components into a table.
  foreach (element_children($form['components']) as $key) {
    $row = array();
    $row[] = $form['components'][$key]['#title'];
    $row[] = $form['components'][$key]['#description'];
    $form['components'][$key]['#title'] = NULL;
    $form['components'][$key]['#description'] = NULL;
    $row[] = array('data' => drupal_render($form['components'][$key]), 'align' => 'center');
    $rows[] = $row;
  }
  $header = array(t('Name'), t('Description'), array('data' => t('Enabled'), 'class' => 'checkbox'));

  // Create the table inside the form.
  $form['components']['table'] = array(
    '#value' => theme('table', $header, $rows)
  );

  return drupal_render($form);
}

/**
 * Menu callback for admin/content/loisform. Displays all loisforms on the site.
 */
function loisform_admin_content() {
  $loisform_types = loisform_variable_get('loisform_node_types');

  $nodes = array();
  if ($loisform_types) {
    $placeholders = implode(', ', array_fill(0, count($loisform_types), "'%s'"));
    $result = db_query(db_rewrite_sql("SELECT n.*, r.* FROM {node} n INNER JOIN {node_revisions} r ON n.vid = r.vid WHERE n.type IN ($placeholders)", 'n', 'nid', $loisform_types), $loisform_types);
    while ($node = db_fetch_object($result)) {
      $nodes[] = $node;
    }
  }

  return theme('loisform_admin_content', $nodes);
}

/**
 * Create a comma-separate list of content types that are loisform enabled.
 */
function loisform_admin_type_list() {
  $loisform_types = loisform_variable_get('loisform_node_types');
  $loisform_type_list = '';
  $loisform_type_count = count($loisform_types);
  foreach ($loisform_types as $n => $type) {
    $loisform_type_list .= l(node_get_types('name', $type), 'node/add/' . $type);
    if ($n + 1 < $loisform_type_count) {
      $loisform_type_list .= $loisform_type_count == 2 ? ' ' : ', ';
    }
    if ($n + 2 == $loisform_type_count) {
      $loisform_type_list .= t('or') . ' ';
    }
  }

  return $loisform_type_list;
}

/**
 * Generate a list of all loisforms avaliable on this site.
 */
function theme_loisform_admin_content($nodes) {
  $header = array(
    t('Title'),
    array('data' => t('View'), 'colspan' => '4'),
    array('data' => t('Operations'), 'colspan' => '2')
  );

  $rows = array();
  foreach ($nodes as $node) {
    $rows[] = array(
      l($node->title, 'node/' . $node->nid),
      l(t('Submissions'), 'node/' . $node->nid . '/loisform-results'),
      l(t('Analysis'), 'node/' . $node->nid . '/loisform-results/analysis'),
      l(t('Table'), 'node/' . $node->nid . '/loisform-results/table'),
      l(t('Download'), 'node/' . $node->nid . '/loisform-results/download'),
      node_access('update', $node) ? l(t('Edit'), 'node/' . $node->nid . '/edit') : '',
      user_access('delete all loisform submissions') ? l(t('Clear'), 'node/' . $node->nid . '/loisform-results/clear') : '',
    );
  }

  if (empty($rows)) {
    $loisform_types = loisform_variable_get('loisform_node_types');
    if (empty($loisform_types)) {
      $message = t('Loisform is currently not enabled on any content types.') . ' ' . t('Visit the <a href="!url">Loisform settings</a> page and enable Loisform on at least one content type.', array('!url' => url('admin/settings/loisform')));
    }
    else {
      $loisform_type_list = loisform_admin_type_list();
      $message = t('There are currently no loisforms on your site. Create a !types piece of content.', array('!types' => $loisform_type_list));
    }

    $rows[] = array(
      array('data' => $message, 'colspan' => 7),
    );
  }

  return theme('table', $header, $rows);
}

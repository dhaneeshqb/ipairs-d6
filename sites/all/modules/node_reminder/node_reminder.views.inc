<?php

/**
 * @file
 *  views integration
 */

/**
 * Implementation of hook_views_data()
 */
function node_reminder_views_data() {
  // Define the base group of this table. Fields that don't
  // have a group defined will go into this field by default.
  $data['node_reminder']['table']['group']  = t('Node Reminder');

  $data['node_reminder']['table']['base'] = array(
    'field' => 'nid',
    'title' => t('Node Reminder'),
    'help' => t("Time Reminder to node content."),
  );

  //joins
  $data['node_reminder']['table']['join'] = array(
    //...to the node table
    'node' => array(
      'left_field' => 'nid',
      'field' => 'nid',
    ),
  );

  // ----------------------------------------------------------------
  // Fields

  // notify_on - When notification will be sent
  $data['node_reminder']['notify_on'] = array(
    'title' => t('Send Date'),
    'help' => t('Date and time of the reminder will be sent.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'sort' => array(
      'handler' => 'views_handler_sort_date',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_date',
    ),
  );

  // nid
  $data['node_reminder']['nid'] = array(
    'title' => t('Node'),
    'help' => t('The node the reminder is set for.'),
    'relationship' => array(
      'base' => 'node',
      'field' => 'nid',
      'handler' => 'views_handler_relationship',
      'label' => t('Node'),
    ),
  );

  // Active @TODO Get Has Reminder Filter Working
  $data['node_reminder']['active'] = array(
    'title' => t('Active Reminder'),
    'help' => t('The Reminder is Active'),
    'filter' => array(
      'handler' => 'views_handler_filter_boolean_operator',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort_date',
    ),
  );

  // Reminder email address
  $data['node_reminder']['email'] = array(
    'title' => t("Email Address"),
    'help' => t("Email Address the Reminder is sent to"),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
  );

  return $data;
}

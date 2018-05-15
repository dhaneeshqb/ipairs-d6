<?php
// $Id: loisform.views.inc,v 1.2.2.1 2010/09/11 02:18:53 quicksketch Exp $

/**
* @file
* Views hooks implemented for the Loisform module.
*/

function loisform_views_data() {
  /**
   * Submissions table definitions.
   */
  $data['loisform_submissions']['table']['group'] = t('Loisform submissions');
  $data['loisform_submissions']['table']['base'] = array(
    'field' => 'sid',
    'title' => t('Loisform submissions'),
    'help' => t('Submissions grenerated from Loisform forms.'),
  );

  // sid
  $data['loisform_submissions']['sid'] = array(
    'title' => t('Sid'),
    'help' => t('The submission ID of the submission.'),
    'field' => array(
      'handler' => 'views_handler_field_numeric',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'title' => t('Sid'),
      'handler' => 'views_handler_filter_numeric',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  // nid
  $data['loisform_submissions']['nid'] = array(
    'title' => t('Node'),
    'help' => t('The node these submissions were generated from.'),
    'relationship' => array(
      'base' => 'node',
      'handler' => 'views_handler_relationship',
      'label' => t('Node'),
      'skip base' => array('node', 'node_revisions'),
    ),
  );

  // uid
  $data['loisform_submissions']['uid'] = array(
    'title' => t('User'),
    'help' => t('The users who submitted these submissions.'),
    'relationship' => array(
      'base' => 'users',
      'handler' => 'views_handler_relationship',
      'label' => t('User'),
      'skip base' => array('users', 'node', 'node_revisions'),
    ),
  );

  // is_draft
  $data['loisform_submissions']['is_draft'] = array(
    'title' => t('Draft'),
    'help' => t('Whether or not the submission is a draft.'),
    'field' => array(
      'handler' => 'loisform_handler_field_is_draft',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'handler' => 'loisform_handler_filter_is_draft',
    ),
    'sort' => array(
       'handler' => 'views_handler_sort',
    ),
  );

  // submitted
  $data['loisform_submissions']['submitted'] = array(
    'title' => t('Submitted'),
    'help' => t('The date this submission was submitted.'),
    'field' => array(
      'handler' => 'views_handler_field_date',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'title' => t('Submitted'),
      'handler' => 'views_handler_filter_date',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort_date',
    ),
  );

  // remote_addr
  $data['loisform_submissions']['remote_addr'] = array(
    'title' => t('Remote address'),
    'help' => t('The remote IP address of the user that submitted this submission.'),
    'field' => array(
      'handler' => 'views_handler_field',
      'click sortable' => TRUE,
    ),
    'filter' => array(
      'title' => t('Remote address'),
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  // view link
  $data['loisform_submissions']['view_submission'] = array(
    'field' => array(
      'title' => t('View link'),
      'help' => t('Provide a simple link to view the submission.'),
      'handler' => 'loisform_handler_field_submission_link',
      'link_type' => 'view',
    ),
  );

  // edit link
  $data['loisform_submissions']['edit_submission'] = array(
    'field' => array(
      'title' => t('Edit link'),
      'help' => t('Provide a simple link to edit the submission.'),
      'handler' => 'loisform_handler_field_submission_link',
      'link_type' => 'edit',
    ),
  );

  // delete link
  $data['loisform_submissions']['delete_submission'] = array(
    'field' => array(
      'title' => t('Delete link'),
      'help' => t('Provide a simple link to delete the submission.'),
      'handler' => 'loisform_handler_field_submission_link',
      'link_type' => 'delete',
    ),
  );

  return $data;
}

/**
 * Implementation of hook_views_data_alter().
 */
function loisform_views_data_alter(&$data) {
  // Submission count (node).
  $data['node']['loisform_submission_count_node'] = array(
    'field' => array(
      'title' => t('Loisform submission count'),
      'help' => t('The number of loisform submissions on this node.'),
      'handler' => 'loisform_handler_field_submission_count',
      'count_type' => 'node',
    ),
  );

  // Submission count (user).
  $data['users']['loisform_submission_count_user'] = array(
    'field' => array(
      'title' => t('Loisform submission count'),
      'help' => t('The number of loisform submissions for this user.'),
      'handler' => 'loisform_handler_field_submission_count',
      'count_type' => 'users',
    ),
  );

  // Link for editing the loisform.
  $data['node']['loisform_edit'] = array(
    'field' => array(
      'title' => t('Loisform edit link'),
      'help' => t('Provide a simple link to edit the loisform components and configuration.'),
      'handler' => 'loisform_handler_field_node_link_edit',
    ),
  );

  // Link for viewing loisform results.
  $data['node']['loisform_results'] = array(
    'field' => array(
      'title' => t('Loisform results link'),
      'help' => t('Provide a simple link to view the results of a loisform.'),
      'handler' => 'loisform_handler_field_node_link_results',
    ),
  );

  // Loisform form content.
  $data['node']['loisform_form_body'] = array(
    'field' => array(
      'title' => t('Loisform form body'),
      'help' => t('The Loisform form body display for this node.'),
      'handler' => 'loisform_handler_field_form_body',
    ),
  );
}

/**
 * Implementation of hook_views_handlers().
 */
function loisform_views_handlers() {
  return array(
    'info' => array(
      'path' => drupal_get_path('module', 'loisform') . '/views',
    ),
    'handlers' => array(
      'loisform_handler_field_submission_link' => array(
        'parent' => 'views_handler_field',
        'file' => 'loisform_handler_field_submission_link.inc',
      ),
      'loisform_handler_field_submission_count' => array(
        'parent' => 'views_handler_field',
        'file' => 'loisform_handler_field_submission_count.inc',
      ),
      'loisform_handler_field_node_link_edit' => array(
        'parent' => 'views_handler_field_node_link',
      ),
      'loisform_handler_field_node_link_results' => array(
        'parent' => 'views_handler_field_node_link',
      ),
      'loisform_handler_field_form_body' => array(
        'parent' => 'views_handler_field',
        'file' => 'loisform_handler_field_form_body.inc',
      ),
      'loisform_handler_field_is_draft' => array(
        'parent' => 'views_handler_field',
        'file' => 'loisform_handler_field_is_draft.inc',
      ),
      'loisform_handler_filter_is_draft' => array(
        'parent' => 'views_handler_filter_in_operator',
        'file' => 'loisform_handler_filter_is_draft.inc',
      ),
    ),
  );
}
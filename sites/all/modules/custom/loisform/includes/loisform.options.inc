<?php
// $Id: loisform.options.inc,v 1.1.2.2 2010/03/29 03:19:49 quicksketch Exp $

/**
 * @file
 * A collection of built-in select list options for Loisform.
 */

/**
 * Private implementation of hook_loisform_select_options_info().
 *
 * @see loisform_loisform_select_options_info().
 */
function _loisform_options_info() {
  $items = array();

  $items['days'] = array(
    'title' => t('Days of the week'),
    'options callback' => 'loisform_options_days',
    'file' => 'includes/loisform.options.inc',
  );

  if (function_exists('countries_api_get_array')) {
    $items['countries'] = array(
      'title' => t('Countries'),
      'options callback' => 'loisform_options_countries',
      'file' => 'includes/loisform.options.inc',
    );
  }

  $items['united_states'] = array(
    'title' => t('US states'),
    'options callback' => 'loisform_options_united_states',
    'file' => 'includes/loisform.options.inc',
  );

  return $items;
}

/**
 * Option list containing the days of the week.
 */
function loisform_options_days() {
  $days = array(
    'sunday' => t('Sunday'),
    'monday' => t('Monday'),
    'tuesday' => t('Tuesday'),
    'wednesday' => t('Wednesday'),
    'thursday' => t('Thursday'),
    'friday' => t('Friday'),
    'saturday' => t('Saturday'),
  );

  // Order according to site settings for first day.
  if ($first_day = variable_get('date_first_day', 0)) {
    $week = array_splice($days, $first_day);
    $days = array_merge($week, $days);
  }

  return $days;
}

/**
 * Options list containing country names.
 */
function loisform_options_countries() {
  return countries_api_get_array();
}

/**
 * Options list containing United States states and territories.
 */
function loisform_options_united_states() {
  return array(
    'AL' => t('Alabama'),
    'AK' => t('Alaska'),
    'AS' => t('American Samoa'),
    'AZ' => t('Arizona'),
    'AR' => t('Arkansas'),
    'CA' => t('California'),
    'CO' => t('Colorado'),
    'CT' => t('Connecticut'),
    'DE' => t('Delaware'),
    'DC' => t('District of Columbia'),
    'FL' => t('Florida'),
    'GA' => t('Georgia'),
    'GU' => t('Guam'),
    'HI' => t('Hawaii'),
    'ID' => t('Idaho'),
    'IL' => t('Illinois'),
    'IN' => t('Indiana'),
    'IA' => t('Iowa'),
    'KS' => t('Kansas'),
    'KY' => t('Kentucky'),
    'LA' => t('Louisiana'),
    'ME' => t('Maine'),
    'MH' => t('Marshall Islands'),
    'MD' => t('Maryland'),
    'MA' => t('Massachusetts'),
    'MI' => t('Michigan'),
    'MN' => t('Minnesota'),
    'MS' => t('Mississippi'),
    'MO' => t('Missouri'),
    'MT' => t('Montana'),
    'NE' => t('Nebraska'),
    'NV' => t('Nevada'),
    'NH' => t('New Hampshire'),
    'NJ' => t('New Jersey'),
    'NM' => t('New Mexico'),
    'NY' => t('New York'),
    'NC' => t('North Carolina'),
    'ND' => t('North Dakota'),
    'MP' => t('Northern Marianas Islands'),
    'OH' => t('Ohio'),
    'OK' => t('Oklahoma'),
    'OR' => t('Oregon'),
    'PW' => t('Palau'),
    'PA' => t('Pennsylvania'),
    'PR' => t('Puerto Rico'),
    'RI' => t('Rhode Island'),
    'SC' => t('South Carolina'),
    'SD' => t('South Dakota'),
    'TN' => t('Tennessee'),
    'TX' => t('Texas'),
    'UT' => t('Utah'),
    'VT' => t('Vermont'),
    'VI' => t('Virgin Islands'),
    'VA' => t('Virginia'),
    'WA' => t('Washington'),
    'WV' => t('West Virginia'),
    'WI' => t('Wisconsin'),
    'WY' => t('Wyoming'),
  );
}
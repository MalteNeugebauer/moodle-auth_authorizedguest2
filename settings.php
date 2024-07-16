<?php
/**
 * Admin settings and defaults.
 *
 * @package   auth_authorizedguest
 * @copyright Malte Neugebauer
 * @license   MIT License
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
  // Introductory explanation.
  $settings->add(
    new admin_setting_heading(
      'auth_authorizedguest/pluginname',
      '',
      new lang_string('auth_authorizedguestdescription', 'auth_authorizedguest')
    )
  );

  $settings->add(
    new admin_setting_configtextarea(
      'auth_authorizedguest/guestcredentialstext',
      get_string('auth_authorizedguestcredentialstext_key', 'auth_authorizedguest'),
    get_string('auth_authorizedguestcredentialstext', 'auth_authorizedguest'),
    null, PARAM_RAW)
  );

  $settings->add(
    new admin_setting_configtext(
      'auth_authorizedguest/authparam',
      get_string('auth_authorizedguestauthparam_key', 'auth_authorizedguest'),
    get_string('auth_authorizedguestauthparam', 'auth_authorizedguest'),
    'authorizedguest', PARAM_RAW)
  );

  $settings->add(
    new admin_setting_configtext(
      'auth_authorizedguest/counter',
      get_string('auth_authorizedguestcounter_key', 'auth_authorizedguest'),
    get_string('auth_authorizedguestcounter', 'auth_authorizedguest'),
    '0', PARAM_RAW)
  );
}


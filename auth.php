<?php
/**
 * Users that are not logged in will be logged in automatically
 * with preset credentials when a specific parameter is set in
 * the URL.
 *
 * @package   auth_authorizedguest
 * @copyright Malte Neugebauer
 * @license   MIT License
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');

/**
 * Plugin for automatic authentication with predefined credentials triggered by an URL paramter.
 *
 * @package   auth_authorizedguest
 * @copyright Malte Neugebauer
 * @license   MIT License
 */
class auth_plugin_authorizedguest extends auth_plugin_base {

  /** @var array This variable contains the guest user credentials. */
  protected $authguestuserdata;

  /** @var string The URL parameter that triggers the guest authorization. */
  protected $authparam;

  /** @var bool Determines, whether the guest authentication is desired*/
  protected $guestauth_desired;

  /** @var bool Determins, whether an error occured during initialization. */
  protected $error;

  /**
   * Constructor.
   */
  public function __construct() {
    $this->authtype = 'authorizedguest';
    $this->config = get_config('auth_authorizedguest');
    $this->error = false;
    $this->authparam = $this->config->authparam;
    if(empty($this->authparam)) {
      $this->error = true;
      return;
    }
    $this->guestauth_desired = (bool)(optional_param($this->authparam, null, PARAM_TEXT) === "");
    // Process guest credentials as array from the textarea field from the settings.
    // Assume, that semicolons ';' are not allowed in usernames, but in passwords. So split username and password from each other at first occurence of ';'.
    $column_sep = ";";
    $line_sep_regex = '/\r\n|\r|\n/';
    if(empty($this->config->guestcredentialstext)) {
      $error = true;
      if($this->guestauth_desired) {
        error_log("User could not be authorized with guest credentials due to missing credentials in the authorized guest plugin settings.");
      }
      return;
    }

    $rows = preg_split($line_sep_regex, $this->config->guestcredentialstext);

    foreach($rows as &$row) {
      $row = explode($column_sep, $row, 2);
    }

    // Expect the first column to be the username and the second column to be the password.
    $this->authguestuserdata = array();
    foreach($rows as $row) {
      if(empty($row[0]) || empty($row[1])) {
        continue;
      }
      $this->authguestuserdata[] = array("name" => $row[0], "pwd" => $row[1]);
    }
  }

  /**
   * As in this authentication method the user is logged in previoulsy
   * with the help of the pre_loginpage_hook, the user_login function
   * is overwritten, always giving false.
   *
   * @param string $username The username (necessary for overwriting)
   * @param string $password The password (necessary for overwriting)
   * @return bool Always false
   */
  function user_login($username, $password) {
    return false;
  }

  /**
   * This function logs in the user with the guest credentials
   * defined in the plugin's settings, if a given parameter is
   * set in the URL.
   *
   * @return bool True on successful guest authentication, false otherwise.
   */
  function pre_loginpage_hook() {
    if(!$this->guestauth_desired || isloggedin() || isguestuser() || $this->error) {
      // No guest authorization necessary if no guest authorization desired or user is already any sort of logged in.
      return false;
    }
    $authguestcredentials = $this->get_authguest_credentials();
    $logintoken = \core\session\manager::get_login_token();
    $user = authenticate_user_login($authguestcredentials["name"], $authguestcredentials["pwd"], false, $errorcode, $logintoken, false);
    if(!$user) {
      error_log("Guest user could not be authorized with the auth_authorizedguest method as authentication with authenticate_user_login failed. Probably there is an error in the credentials formulation. Please check the settings.");
      return false;
    }
    complete_user_login($user);
    return true;
  }

  /**
   * As in this authentication method, the user is logged in previously
   * with the help of the pre_loginpage_hook, the u function is overwritten,
   * always giving false.
   *
   * @param bool $increment If true, the counter pointing on the user credentials will
   * be incremented.
   * @return array The next user credentials that are ready to be provided to a guest user.
   */
  protected function get_authguest_credentials($increment=true) {
    if(empty($this->config) || !isset($this->config->counter) || empty($this->authguestuserdata)) {
      error_log("Credentials for guest authorization could not be processed as the necessary data to do so is missing. Please check the plugin settings.");
      return false;
    }
    $curr_counter = (int)$this->config->counter;
    $next_counter = $curr_counter;
    if($increment == true) {
      $next_counter = $curr_counter+1;
      if($next_counter >= sizeof($this->authguestuserdata)) {
        $next_counter = 0;
      }
      set_config("counter", $next_counter, 'auth_authorizedguest');
    }
    if(empty($this->authguestuserdata[$next_counter])) {
      error_log("Credentials for guest autorization are not present at the current position of the array. Please check the plugin settings.");
      return false;
    }
    $curr_userdata = $this->authguestuserdata[$next_counter];
    return $curr_userdata;
  }
}

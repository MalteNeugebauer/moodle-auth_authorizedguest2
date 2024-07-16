<?php
/**
 * Version information
 *
 * @package   auth_authorizedguest
 * @copyright Malte Neugebauer
 * @license   MIT
 */

$string['auth_authorizedguestdescription'] = 'This plugin allows users, that are not logged in, to be logged in with previously created guest accounts.';
$string['auth_authorizedguestcounter_key'] = 'Counter';
$string['auth_authorizedguestcounter'] = 'The counter starts with 0 and increments each time, a user is provided with guest credentials. It resets to 0, if all user credentials were provided. It can be set manually here.';
$string['pluginname'] = 'Authorized Guest';
$string['auth_authorizedguestcredentialstext_key'] = 'Credentials';
$string['auth_authorizedguestcredentialstext'] = 'A list of already existing user credentials wich are used for logging in guest users. Each line represents an username and a password. Username and password in each row are separated by a semicolon (;) without spaces. E.g.: guestuser1;password1212[\newline]guestuser2;password23232[\newline]...';
$string['auth_authorizedguestauthparam_key'] = 'Activating URL Parameter';
$string['auth_authorizedguestauthparam'] = 'URLs with this parameter trigger the guest authentication. E.g.: If the parameter is \'authorizedguest\', when non-logged in users visit the URL https://mymoodle.org/mod/quiz/view.php?id=[quizid]<strong>&authorizedguest</strong>, they will automatically be logged in with the guest credentials and - provided that the assigned guest account is enrolled in the course - can directly view the quiz.';

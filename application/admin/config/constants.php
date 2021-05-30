<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('API_URL', 'http://localhost/kohima/api/');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_kohima');

define('DB_DATETIME_FORMAT', 'Y-m-d H:i:s');
define('DB_DATE_FORMAT', 'Y-m-d');

define('DISPLAY_TIME_FORMAT_12', 'h:i:s A');
define('DISPLAY_TIME_FORMAT_24', 'H:i:s');

define('DTPICKER_TIME_FORMAT_12', 'hh:mm A');
define('DTPICKER_TIME_FORMAT_24', 'HH:mm');

define('TBL_PREFIX', 'tbl_');
define('TBL_ADMIN', TBL_PREFIX.'admin');
define('TBL_ROLE', TBL_PREFIX.'role');
define('TBL_ERROR_CODE', TBL_PREFIX.'error_code');
define('TBL_SETTINGS', TBL_PREFIX.'settings');
define('TBL_LANGUAGE', TBL_PREFIX.'language');
define('TBL_LANGUAGE_TRANSLATION', TBL_PREFIX.'language_translation');

define('TBL_TERMINAL', TBL_PREFIX.'terminal');
define('TBL_CLIENT', TBL_PREFIX.'client');
define('TBL_USER', TBL_PREFIX.'user');
define('TBL_TTERMINAL', TBL_PREFIX.'tterminal');
define('TBL_GROUP_TERMINAL', TBL_PREFIX.'group_terminal');

define('TBL_PLAYLIST', TBL_PREFIX.'playlist');
define('TBL_LAYOUT', TBL_PREFIX.'layout');
define('TBL_SCHEDULE', TBL_PREFIX.'schedule');
define('TBL_SCHEDULE_L', TBL_PREFIX.'schedule_l');


//Admin Log
define('TBL_ADMIN_LOG', TBL_PREFIX.'admin_log');
define('TBL_TERMINAL_LOG', TBL_PREFIX.'terminal_log');
define('TBL_ADMIN_SCHEDULE_LOG', TBL_PREFIX.'admin_schedule_log');
define('TBL_ADMIN_PLAYLIST_LOG', TBL_PREFIX.'admin_playlist_log');
define('TBL_ADMIN_LAYOUT_LOG', TBL_PREFIX.'admin_layout_log');
define('TBL_CLIENT_LOG', TBL_PREFIX.'client_log');

//User Log
define('TBL_LOG', TBL_PREFIX.'log');
define('TBL_PLAYLIST_LOG', TBL_PREFIX.'playlist_log');
define('TBL_SCHEDULE_LOG', TBL_PREFIX.'schedule_log');
define('TBL_LAYOUT_LOG', TBL_PREFIX.'layout_log');
define('TBL_ALARM_LOG', TBL_PREFIX.'alarm_log');
define('TBL_BILLING_LOG', TBL_PREFIX.'billing_log');





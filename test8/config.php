<?php
// ============================================================
// RTNTS Global — Food Safety Culture Portal — configuration
// ============================================================
// On cPanel / Just Host the database and user are created in the MySQL
// Database Wizard and are PREFIXED with your account name, e.g.:
//   DB_NAME = 'youracct_fscportal'   DB_USER = 'youracct_fscuser'
define('DB_HOST', 'localhost');
define('DB_NAME', 'fssc');    // e.g. 'youracct_fscportal' on cPanel
define('DB_USER', 'root');          // e.g. 'youracct_fscuser' on cPanel
define('DB_PASS', '');              // the password you set in the wizard
define('APP_NAME', 'Food Safety Culture Portal');
define('APP_COMPANY', 'RTNTS Global');
define('MIN_GROUP_SIZE', 5);        // anonymity: suppress result groups smaller than this
define('SESSION_TIMEOUT', 1800);    // seconds

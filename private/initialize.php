<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");


ob_start(); // output buffering is turned on
session_start(); // turn on session

// Assign file paths to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the parent directory
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("SHARED_PATH", PRIVATE_PATH . '/shared');
define("PRIVATE_HEADER", SHARED_PATH . '/admin_header.php');
define("PRIVATE_FOOTER", SHARED_PATH . '/admin_footer.php');
define("PAGE_TABLE", 'pages');
define("PAGE_TABLE_TYPE_DEFINITION", 'siis'); // id is the last one
define("USER_TABLE", 'users');
define("USER_TABLE_TYPE_DEFINITION", 'ssssi');
define("ADMIN_TABLE", 'admins');
define("ADMIN_TABLE_TYPE_DEFINITION", 'ssssi');
define("COMMENT_TABLE", 'comments');
define("COMMENT_TABLE_TYPE_DEFINITION", 'siss');

// Assign the root URL to a PHP constant
// * Do not need to include the domain
// * Use same document root as webserver
// * Can set a hardcoded value:
// define("WWW_ROOT", '');
// * Can dynamically find everything in URL up to "/public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');
require_once('validation_functions.php');
require_once('auth_functions.php');
require_once('renderer.php');

$db = db_connect();
insert_admin();
$errors = [];

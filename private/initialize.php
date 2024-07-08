<?php
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
// CREATE TABLE `pages` (
//     `id` INT(2) PRIMARY KEY AUTO_INCREMENT,
//     `page_name` varchar(255) DEFAULT NULL,
//     `position` INT(2) DEFAULT NULL,
//     `visible` TINYINT(1) DEFAULT NULL,
//     `content` TEXT,
//     KEY `index_page_name` (`page_name`)
//   );
define("PAGE_TABLE", 'pages');
define("PAGE_TABLE_TYPE_DEFINITION", 'siisi'); // id is the last one
// CREATE TABLE `users` (
//     `id` INT PRIMARY KEY AUTO_INCREMENT,
//     `username` VARCHAR(20) UNIQUE NOT NULL,
//     `post_content` TEXT NOT NULL,
//     `post_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     `user_uuid` CHAR(36) UNIQUE NOT NULL, 
//     `is_posted` TINYINT(1) DEFAULT 1,
//     KEY `index_username` (`username`)
// );
define("ADMIN_TABLE", 'admins');
define("ADMIN_TABLE_TYPE_DEFINITION", 'ssssii');


// Assign the root URL to a PHP constant
// * Do not need to include the domain
// * Use same document root as webserver
// * Can set a hardcoded value:
// define("WWW_ROOT", '/~kevinskoglund/globe_bank/public');
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
require_once('classes.php');

$db = db_connect();
$errors = [];

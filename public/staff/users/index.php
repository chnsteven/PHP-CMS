<?php require_once('../../../private/initialize.php');
// echo $_SESSION['debug'] ?? '';

$table = find_all(USER_TABLE);

$renderer = new IndexRenderer('users', $table);

$page_title = 'Users';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

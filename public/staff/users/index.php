<?php require_once('../../../private/initialize.php');
$table = find_all(USER_TABLE);

$renderer = new IndexRenderer('users', $table);

$page_title = 'Users';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

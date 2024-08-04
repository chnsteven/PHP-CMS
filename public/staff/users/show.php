<?php
require_once('../../../private/initialize.php');

require_login();
$id = $_GET['id'] ?? '1';
$renderer = new ShowRenderer(USER_TABLE, $id);

$page_title = 'Show User';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

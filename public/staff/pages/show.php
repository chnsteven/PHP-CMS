<?php

require_once('../../../private/initialize.php');

$id = $_GET['id'] ?? '1';
$renderer = new ShowRenderer(PAGE_TABLE, $id);

$page_title = 'Show Page';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

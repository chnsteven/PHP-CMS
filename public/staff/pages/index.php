<?php require_once('../../../private/initialize.php');
$table = find_all(PAGE_TABLE);
$renderer = new IndexRenderer('pages', $table);

$page_title = 'Pages';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

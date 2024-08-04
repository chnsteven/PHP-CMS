<?php
require_once('../../../private/initialize.php');

require_login();
if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/pages/index.php'));
}

$id = $_GET['id'];
$renderer = new DeleteRenderer(PAGE_TABLE, $id);
$renderer->handle_post_request();

$page_title = 'Delete Page';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

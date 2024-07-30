<?php

require_once('../../../private/initialize.php');

if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/users/index.php'));
}

$id = $_GET['id'];
$renderer = new DeleteRenderer(USER_TABLE, $id);
$renderer->handle_post_request();

$page_title = 'Delete Page';
include(PRIVATE_HEADER);

echo $renderer->render();

include(PRIVATE_FOOTER);

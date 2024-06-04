<?php require_once('../../../private/initialize.php'); ?>
<?php include(PRIVATE_HEADER); ?>
<?php
$page_set = find_all_pages() ?? false;
if (!$page_set) {
    die("Reading user information failed.");
}

$page_title = 'Pages';
$headers = ['id', 'page_name', 'position', 'visible', 'content'];

$page_renderer = new PageRenderer($page_set, $headers, $page_title);
$page_renderer->render();


mysqli_free_result($page_set);
?>
<?php include(PRIVATE_FOOTER); ?>
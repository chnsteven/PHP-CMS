<?php require_once('../../../private/initialize.php'); ?>
<?php include(PRIVATE_HEADER); ?>
<?php
$user_set = find_all_users() ?? false;
if (!$user_set) {
    die("Reading user information failed.");
}

$page_title = 'Users';
$headers = ['id', 'username', 'post_content', 'post_date', 'user_uuid', 'is_posted'];

$user_page_renderer = new PageRenderer($user_set, $headers, $page_title);
$user_page_renderer->render();


mysqli_free_result($user_set);
?>
<?php include(PRIVATE_FOOTER); ?>
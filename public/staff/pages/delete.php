<?php

require_once('../../../private/initialize.php');
if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id'];
$page = find_by_id(PAGE_TABLE, $id);
if (is_post_request()) {
  $result = delete(PAGE_TABLE, $id);
  $_SESSION['message'] = "The page was deleted successfully.";
  redirect_to(url_for('/staff/pages/index.php'));
} else {
}

?>

<?php $page_title = 'Delete Page'; ?>
<?php include(PRIVATE_HEADER); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php') ?>">&laquo; Back</a>

  <div class="page delete">
    <h1>Delete Page</h1>
    <p>Are you sure you want to delete this page?</p>
    <p class="item"><?php echo h($page['page_name']); ?></p>

    <form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Page" />
      </div>
    </form>
  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
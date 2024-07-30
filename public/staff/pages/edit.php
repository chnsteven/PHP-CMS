<?php

require_once('../../../private/initialize.php');
if (!isset($_GET['id'])) {
  $_SESSION['message'] = "The page was updated successfully.";
  redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id'];
// Handle form values sent by new.php
$page = [
  'page_name' => '',
  'position' => '1',
  'visible' => '0',
  'content' => '',
  'id' => $id
];
$page = replace_with_post_values($page);
if (is_post_request()) {
  $result = update_table(PAGE_TABLE, PAGE_TABLE_TYPE_DEFINITION, $page);
  redirect_to(url_for('/staff/pages/index.php'));
} else {
  $page = find_by_id(PAGE_TABLE, $id);
}


?>

<?php $page_title = 'Edit Page'; ?>
<?php include(PRIVATE_HEADER); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back</a>

  <div class="page edit">
    <h1>Edit Page</h1>

    <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Page Name</dt>
        <dd><input type="text" name="page_name" value="<?php echo h($page['page_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" <?php if ($page['visible'] == "1") {
                                                            echo " checked";
                                                          } ?> />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>

  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
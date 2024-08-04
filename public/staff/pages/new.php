<?php
require_once('../../../private/initialize.php');

require_login();
if (is_post_request()) {
  $page = array(
    'page_name' => 'New Title',
    'position' => '1',
    'visible' => '1',
    'content' => ''
  );
  $page = replace_with_post_values($page);

  $result = insert_values(PAGE_TABLE, PAGE_TABLE_TYPE_DEFINITION, $page);
  if ($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = "The page was created successfully.";
    redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }
}

?>

<?php $page_title = 'Create Page'; ?>
<?php include(PRIVATE_HEADER); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back</a>

  <div class="page new">
    <h1>Create Page</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/pages/new.php'); ?>" method="post">
      <?php echo create_text_input_field("page_name"); ?>
      <?php echo create_text_input_field("position"); ?>
      <?php echo create_checkbox_field("visible"); ?>
      <?php echo create_multi_line_text_input_field("content"); ?>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
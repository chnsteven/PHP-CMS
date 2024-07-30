<?php

require_once('../../../private/initialize.php');
if (!isset($_GET['id'])) {
  $_SESSION['message'] = "The page was updated successfully.";
  redirect_to(url_for('/staff/users/index.php'));
}
$id = $_GET['id'];
// Handle form values sent by new.php
$user = array(
  'username' => '',
  'post_content' => '',
  'post_date' => '',
  'user_uuid' => '',
  'is_posted' => '0',
  'id' => $id
);
$user = replace_with_post_values($user);
if (is_post_request()) {
  $result = update_table(USER_TABLE, USER_TABLE_TYPE_DEFINITION, $user);
  redirect_to(url_for('/staff/users/index.php'));
} else {
  $user = find_by_id(USER_TABLE, $id);
}


?>

<?php $title = 'Edit User'; ?>
<?php include(PRIVATE_HEADER); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back</a>

  <div class="user edit">
    <h1>Edit User</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/users/edit.php?id=' . h(u($id))); ?>" method="post">
      <?php echo create_text_input_field("username", $user['username']); ?>
      <?php echo create_multi_line_text_input_field("post_content", $user['post_content']); ?>
      <?php echo create_datepicker_input_field("post_date", $user['post_date']); ?>
      <?php echo create_text_input_field("user_uuid", $user['user_uuid']); ?>
      <?php echo create_checkbox_field("is_posted", $user['is_posted']); ?>
      <div id="operations">
        <input type="submit" value="Edit user" />
      </div>
    </form>

  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
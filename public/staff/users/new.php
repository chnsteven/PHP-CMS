<?php
require_once('../../../private/initialize.php');

require_login();
if (is_post_request()) {
  $user = array(
    'username' => '',
    'post_content' => '',
    'post_date' => '',
    'user_uuid' => '',
    'is_posted' => 1,
  );
  $user = replace_with_post_values($user);

  $result = insert_values(USER_TABLE, USER_TABLE_TYPE_DEFINITION, $user);
  if ($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = "The user was created successfully.";
    redirect_to(url_for('/staff/users/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }
}

?>

<?php $user_title = 'Create user'; ?>
<?php include(PRIVATE_HEADER); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/users/index.php'); ?>">&laquo; Back</a>

  <div class="user new">
    <h1>Create user</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/users/new.php'); ?>" method="post">
      <?php echo create_text_input_field("username"); ?>
      <?php echo create_multi_line_text_input_field("post_content"); ?>
      <?php echo create_datepicker_input_field("post_date"); ?>
      <?php echo create_text_input_field("user_uuid"); ?>
      <?php echo create_checkbox_field("is_posted"); ?>
      <div id="operations">
        <input type="submit" value="Create user" />
      </div>
    </form>

  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
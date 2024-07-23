<?php
require_once('../../../private/initialize.php');
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
      <dl>
        <dt>Page Name</dt>
        <dd><input type="text" name="page_name" value="" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php
            for ($i = 1; $i <= $page_count; $i++) {
              echo "<option value=\"{$i}\"";
              if ($page["position"] == $i) {
                echo " selected";
              }
              echo ">{$i}</option>";
            }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
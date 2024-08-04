<?php
require_once('../../private/initialize.php');

require_login();
include(PRIVATE_HEADER);
?>

<div id="content">
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li><a href="<?php echo url_for('/staff/pages/index.php'); ?>">Pages</a></li>
      <li><a href="<?php echo url_for('/staff/users/index.php'); ?>">Users</a></li>
    </ul>
  </div>

</div>

<?php include(PRIVATE_FOOTER); ?>
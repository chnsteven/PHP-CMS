<?php
if (!isset($page_title)) {
  $page_title = 'Admin Panel';
}
?>

<!doctype html>

<html lang="en">

<head>
  <title>Portfolio - <?php echo h($page_title); ?></title>
  <meta charset="utf-8">
  <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/admin.css'); ?>" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>

<body>
  <header>
    <h1><?php echo h($page_title) ?></h1>
  </header>

  <navigation>
    <ul>
      <li>TODO: Admin login portal</li>
      <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
    </ul>
  </navigation>

  <?php echo display_session_message(); ?>
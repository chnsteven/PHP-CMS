<?php

function url_for($script_path)
{
  // add the leading '/' if not present
  if ($script_path[0] != '/') {
    $script_path = "/" . $script_path;
  }
  return WWW_ROOT . $script_path;
}

function u($string = "")
{
  return urlencode($string);
}

function raw_u($string = "")
{
  return rawurlencode($string);
}

function h($string = "")
{
  return htmlspecialchars($string);
}

function error_404()
{
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
  exit();
}

function error_500()
{
  header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
  exit();
}

function redirect_to($location)
{
  header("Location: " . $location);
  exit;
}

function is_post_request()
{
  return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_get_request()
{
  return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function is_put_request()
{
  return $_SERVER['REQUEST_METHOD'] === 'PUT';
}

function is_patch_request()
{
  return $_SERVER['REQUEST_METHOD'] === 'PATCH';
}

function display_errors($errors = array())
{
  $output = '';
  if (!empty($errors)) {
    $output .= "<div class=\"errors\">";
    $output .= "Please fix the following errors:";
    $output .= "<ul>";
    foreach ($errors as $error) {
      $output .= "<li>" . h($error) . "</li>";
    }
    $output .= "</ul>";
    $output .= "</div>";
  }
  return $output;
}

function get_and_clear_session_message()
{
  if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
    $msg = $_SESSION['message'];
    unset($_SESSION['message']);
    return $msg;
  }
}

function display_session_message()
{
  $msg = get_and_clear_session_message();
  if (!is_blank($msg)) {
    return '<div id="message">' . h($msg) . "</div>";
  }
}

function create_table($set, $headers)
{
  // Start building the table
  $output = '<table class="list">';
  $output .= '<thead>';
  $output .= '<tr>';

  // Add the headers with formatting
  foreach ($headers as $header) {
    $formatted_header = ucwords(str_replace('_', ' ', $header));
    $output .= '<th>' . h($formatted_header) . '</th>';
  }

  $output .= '<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>';
  $output .= '</tr>';
  $output .= '</thead>';
  $output .= '<tbody>';

  // Add the data rows
  while ($row = mysqli_fetch_assoc($set)) {
    $output .= '<tr>';
    foreach ($headers as $key) {
      $output .= '<td>' . h($row[$key]) . '</td>';
    }
    $output .= '<td><a class="action" href="' . url_for('/staff/subjects/show.php?id=' . h(u($row['id']))) . '">View</a></td>';
    $output .= '<td><a class="action" href="' . url_for('/staff/subjects/edit.php?id=' . h(u($row['id']))) . '">Edit</a></td>';
    $output .= '<td><a class="action" href="' . url_for('/staff/subjects/delete.php?id=' . h(u($row['id']))) . '">Delete</a></td>';
    $output .= '</tr>';
  }
  $output .= '</tbody>';
  $output .= '</table>';

  // Return the table HTML
  return $output;
}

function replace_with_post_values($default_values)
{
  $result = [];
  foreach ($default_values as $key => $default) {
    $result[$key] = $_POST[$key] ?? $default;
  }
  return $result;
}

function replace_with_data($data, $default_values)
{
  $result = [];
  foreach ($default_values as $key => $default) {
    $result[$key] = $data[$key] ?? $default;
  }
  return $result;
}

function create_text_input_field($field, $value = "")
{
  $element = '';
  $element .= '<dl><dt>' . ucfirst(str_replace('_', ' ', $field)) . '</dt><dd>';
  $element .= '<input type="text" name="' . $field . '" value="' . $value . '" autocomplete="off" /></dd></dl>';
  return $element;
}

function create_datepicker_input_field($field)
{
  // Set the default timezone to ensure the correct date is retrieved
  date_default_timezone_set('Canada/Pacific'); // Replace with your local time zone
  $today = date('Y-m-d');

  $element = '<dl>';
  $element .= '<dt>' . ucfirst(str_replace('_', ' ', $field)) . '</dt>';
  $element .= '<dd>';
  $element .= '<input type="text" id="' . $field . '" name="' . $field . '" value="' . $today . '" />';
  $element .= '</dd>';
  $element .= '</dl>';

  return $element;
}

function create_multi_line_text_input_field($field, $value = "", $cols = 60, $rows = 10)
{
  $element = '';
  $element .= '<dl>
  <dt>' . ucfirst(str_replace('_', ' ', $field)) . '</dt>
  <dd>';
  $element .= '<textarea name="' . $field . '" ';
  $element .= 'cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea></dd></dl>';
  return $element;
}

function create_checkbox_field($field, $value = 0)
{
  $isChecked = $value == '1' ? 'checked' : '';

  $element = '';
  $element .= '<dl>
  <dt>' . ucfirst(str_replace('_', ' ', $field)) . '</dt>
  <dd>';
  $element .= '<input type="hidden" name="' . $field . '" value="0" />';
  $element .= '<input type="checkbox" name="' . $field . '" value="1" ' . $isChecked . ' /></dd></dl>';
  return $element;
}

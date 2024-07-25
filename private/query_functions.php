<?php
require_once("initialize.php");

function find_all($table)
{
  global $db;

  $query = "SELECT * FROM " . $table . " ";
  $query .= "ORDER BY id ASC";

  $stmt = $db->prepare($query);
  $stmt->execute();

  $result = $stmt->get_result();

  confirm_result_set($result);
  return $result;
}


function find_by_id($table, $id, $options = [])
{
  global $db;

  $visible = $options['visible'] ?? false;

  $query = "SELECT * FROM " . $table . " ";
  $query .= "WHERE id = ? ";
  if ($visible) {
    $query .= " AND visible = true";
  }

  $stmt = $db->prepare($query);

  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();

  confirm_result_set($result);
  $result = $result->fetch_assoc();
  $stmt->close();
  return $result; // returns an assoc. array
}

function validate_page($page)
{
  $errors = [];

  // subject_id
  if (is_blank($page['subject_id'])) {
    $errors[] = "Subject cannot be blank.";
  }

  // menu_name
  if (is_blank($page['menu_name'])) {
    $errors[] = "Name cannot be blank.";
  } elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
    $errors[] = "Name must be between 2 and 255 characters.";
  }
  $current_id = $page['id'] ?? '0';
  if (!has_unique_page_menu_name($page['menu_name'], $current_id)) {
    $errors[] = "Menu name must be unique.";
  }


  // position
  // Make sure we are working with an integer
  $postion_int = (int) $page['position'];
  if ($postion_int <= 0) {
    $errors[] = "Position must be greater than zero.";
  }
  if ($postion_int > 999) {
    $errors[] = "Position must be less than 999.";
  }

  // visible
  // Make sure we are working with a string
  $visible_str = (string) $page['visible'];
  if (!has_inclusion_of($visible_str, ["0", "1"])) {
    $errors[] = "Visible must be true or false.";
  }

  // content
  if (is_blank($page['content'])) {
    $errors[] = "Content cannot be blank.";
  }

  return $errors;
}

function insert_values($table, $type_definition, $values_array)
{
  global $db;
  $table = $db->real_escape_string($table);

  $columns = array_keys($values_array);
  foreach ($columns as &$column) {
    $column = $db->real_escape_string($column);
  }

  $query = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . str_repeat("?, ", count($columns) - 1) . "?)";
  $stmt = $db->prepare($query);
  if ($stmt === false) {
    die('mysqli prepare failed: ' . h($db->error));
  }
  $params = array_values($values_array);
  $stmt->bind_param($type_definition, ...$params);
  $result = $stmt->execute();
  if ($result === false) {
    die('mysqli prepare failed: ' . h($db->error));
  }
  $stmt->close();
  return $result;
}
function update_page($page)
{
  global $db;

  $errors = validate_page($page);
  if (!empty($errors)) {
    return $errors;
  }

  // $old_page = find_page_by_id($page['id']);
  // $old_position = $old_page['position'];
  // shift_page_positions($old_position, $page['position'], $page['subject_id'], $page['id']);

  $sql = "UPDATE pages SET ";
  $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
  $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
  $sql .= "position='" . db_escape($db, $page['position']) . "', ";
  $sql .= "visible='" . db_escape($db, $page['visible']) . "', ";
  $sql .= "content='" . db_escape($db, $page['content']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  // For UPDATE statements, $result is true/false
  if ($result) {
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function update_table($table, $type_definition, $values)
{
  global $db;

  // TODO: robust validate function
  // $errors = validate_page($page);
  // if (!empty($errors)) {
  //   return $errors;
  // }
  $query = "UPDATE " . db_escape($db, $table) . " SET ";

  foreach ($values as $column => $value) {
    if ($column !== 'id') {
      $query .= db_escape($db, $column) . " = ?, ";
      $params[] = db_escape($db, $value);
    }
  }

  $query = rtrim($query, ", ");
  $query .= " WHERE id = ? LIMIT 1";
  $params[] = db_escape($db, $values['id']);
  $type_definition .= "i";

  // echo $query;

  $stmt = $db->prepare($query);
  if ($stmt === false) {
    die('mysqli prepare failed: ' . h($db->error));
  }

  $stmt->bind_param($type_definition, ...$params);

  $result = $stmt->execute();
  $stmt->close();
  return $result; // returns an assoc. array
}

function delete($table, $id)
{
  global $db;

  $query = "DELETE FROM " . $table . " ";
  $query .= "WHERE id=? ";
  $query .= "LIMIT 1";

  $stmt = $db->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  $result = $stmt->get_result();
  $stmt->close();

  return $result; // returns an assoc. array
}

// Admins

// Find all admins, ordered last_name, first_name
function find_admin_by_username($username)
{
  global $db;

  $sql = "SELECT * FROM admins ";
  $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $admin = mysqli_fetch_assoc($result); // find first
  mysqli_free_result($result);
  return $admin; // returns an assoc. array
}

function validate_admin($admin, $options = [])
{

  $password_required = $options['password_required'] ?? true;

  if (is_blank($admin['first_name'])) {
    $errors[] = "First name cannot be blank.";
  } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
    $errors[] = "First name must be between 2 and 255 characters.";
  }

  if (is_blank($admin['last_name'])) {
    $errors[] = "Last name cannot be blank.";
  } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
    $errors[] = "Last name must be between 2 and 255 characters.";
  }

  if (is_blank($admin['email'])) {
    $errors[] = "Email cannot be blank.";
  } elseif (!has_length($admin['email'], array('max' => 255))) {
    $errors[] = "Last name must be less than 255 characters.";
  } elseif (!has_valid_email_format($admin['email'])) {
    $errors[] = "Email must be a valid format.";
  }

  if (is_blank($admin['username'])) {
    $errors[] = "Username cannot be blank.";
  } elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
    $errors[] = "Username must be between 8 and 255 characters.";
  } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
    $errors[] = "Username not allowed. Try another.";
  }

  if ($password_required) {
    if (is_blank($admin['password'])) {
      $errors[] = "Password cannot be blank.";
    } elseif (!has_length($admin['password'], array('min' => 12))) {
      $errors[] = "Password must contain 12 or more characters";
    } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 uppercase letter";
    } elseif (!preg_match('/[a-z]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif (!preg_match('/[0-9]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 number";
    } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
      $errors[] = "Password must contain at least 1 symbol";
    }

    if (is_blank($admin['confirm_password'])) {
      $errors[] = "Confirm password cannot be blank.";
    } elseif ($admin['password'] !== $admin['confirm_password']) {
      $errors[] = "Password and confirm password must match.";
    }
  }

  return $errors;
}

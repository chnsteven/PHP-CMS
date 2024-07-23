<?php
require_once('../../../private/initialize.php');

$table = "users2";
$type_definition = "sss"; // three strings
$values = array(
    "username" => "dabeer",
    "email" => "dabeer@example.com",
    "password" => "secure_password"
);

insert_values($table, $type_definition, $values);

$table = "products";
$type_definition = "sdi"; // one string, one double, and one integer
$values = array(
    "name" => "Product ABC",
    "price" => 19.99,
    "quantity" => 10
);
insert_values($table, $type_definition, $values);

<?php
require_once('../../private/initialize.php');

if (is_post_request()) {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
        foreach ($data as $key => $value) {
            $_POST[$key] = $data[$key];
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit; // Ensure to exit after sending a response
    }

    // Check for existing user UUID cookie
    $cookie_name = "user_uuid";
    $uuid = $_COOKIE[$cookie_name] ?? null;

    // If no UUID is found, create a new one and set a cookie
    if (!$uuid) {
        $uuid = uniqid('', true);
        setcookie(
            $cookie_name,
            $uuid,
            [
                'expires' => time() + (86400 * 14),
                'path' => '/',
                'domain' => '',
                'secure' => false,
                'httponly' => true,
                'SameSite' => 'Strict'
            ]
        );
    }

    // Prepare the user data for insertion
    $user = array(
        'uuid' => $uuid, // Use the UUID here
        'anonymous' => false,
        'nickname' => '',
        'content' => '',
    );

    $user = replace_with_post_values($user);

    // Debug: Check UUID before inserting
    error_log("Inserting comment with UUID: " . $user['uuid']);

    $result = insert_values(COMMENT_TABLE, COMMENT_TABLE_TYPE_DEFINITION, $user);
    if ($result === true) {
        echo json_encode(["success" => true, "message" => "The comment was added successfully."]);
    } else {
        echo json_encode(["success" => false, "errors" => $result]);
    }
}
?>

<?php include(PRIVATE_FOOTER); ?>

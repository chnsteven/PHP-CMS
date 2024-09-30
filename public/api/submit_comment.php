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
        exit;
    }


    $user = array(
        'uuid' => $data['uuid'] ?? '',
        'anonymous' => false,
        'nickname' => '',
        'content' => '',
    );

    $user = replace_with_post_values($user);

    $result = insert_values(COMMENT_TABLE, COMMENT_TABLE_TYPE_DEFINITION, $user);
    if ($result === true) {
        $new_id = mysqli_insert_id($db);
        // Return the UUID and a success message
        echo json_encode([
            'message' => "The comment was added successfully.\n",
            'uuid' => $uuid . '\n'
        ]);
    } else {
        $errors = $result;
    }
}
?>

<?php include(PRIVATE_FOOTER); ?>

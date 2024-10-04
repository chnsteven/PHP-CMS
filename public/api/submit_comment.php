<?php
require_once('../../private/initialize.php');

if (is_post_request()) {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    $uuid = $_GET['uuid'] ?? '';

    if (!$uuid) {
        echo json_encode(["error" => "UUID not provided"]);
        exit;
    }

    // Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
        $user = array(
            'uuid' => $uuid,
            'anonymous' => false,
            'nickname' => '',
            'content' => '',
        );

        $user = replace_with_data($data, $user);

        $result = insert_values(COMMENT_TABLE, COMMENT_TABLE_TYPE_DEFINITION, $user);
        if ($result === true) {
            // $new_id = mysqli_insert_id($db);
            echo json_encode([
                'message' => "The comment was added successfully.\n",
                'uuid' => $uuid . '\n'
            ]);
        } else {
            echo json_encode([
                'message' => "The comment wasn't added.\n",
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }
}
?>

<?php include(PRIVATE_FOOTER); ?>

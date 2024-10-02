<?php
require_once('../../private/initialize.php');

if (is_patch_request()) {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    $id = $data['id'] ?? '';

    if (!$id) echo json_encode(['error' => 'Invalid ID']);
    // Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
        $old_comment = find_by_id(COMMENT_TABLE, $id);

        if (!$old_comment) {
            http_response_code(404);
            echo json_encode(['error' => 'Comment not found']);
            exit;
        }

        $user = [];
        foreach ($old_comment as $key => $value) {
            // if ($key === 'id') continue;
            $user[$key] = $data[$key] ?? $value;
        }


        $result = update_table(COMMENT_TABLE, COMMENT_TABLE_TYPE_DEFINITION, $user);

        if ($result === true) {
            // Return the UUID and a success message
            // var_dump($data);
            echo json_encode([
                'message' => "The comment was updated successfully.\n",
            ]);
        } else {
            $errors = $result;
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
    }
}
?>

<?php include(PRIVATE_FOOTER); ?>

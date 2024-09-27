<?php
require_once('../../private/initialize.php');

if (is_post_request()) {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    // Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
        $_POST['anonymous'] = $data['anonymous'];
        $_POST['nickname'] = $data['nickname'];
        $_POST['content'] = $data['content'];
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON']);
    }


    $user = array(
        'anonymous' => false,
        'nickname' => '',
        'content' => '',
    );
    $user = replace_with_post_values($user);

    foreach ($user as $key => $value) {
        echo $key . ": " . $value;
    }
    $result = insert_values(COMMENT_TABLE, COMMENT_TABLE_TYPE_DEFINITION, $user);
    if ($result === true) {
        $new_id = mysqli_insert_id($db);
        echo "The comment was added successfully.";
    } else {
        $errors = $result;
    }
}

?>

<?php include(PRIVATE_FOOTER); ?>
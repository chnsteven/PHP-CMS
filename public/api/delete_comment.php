<?php
require_once('../../private/initialize.php');

if (is_delete_request()) {
    // $jsonData = file_get_contents('php://input');
    // $data = json_decode($jsonData, true);


    $id = $_GET['id'] ?? '';

    $result = delete(COMMENT_TABLE, $id);

    var_dump($result);
    if ($result === true) {
        echo json_encode([
            'message' => "The comment was deleted successfully.\n",
        ]);
    } else {
        echo json_encode([
            'error' => "The comment does not exist.\n",
            'debug' => $id,
        ]);
    }
}
?>

<?php include(PRIVATE_FOOTER); ?>

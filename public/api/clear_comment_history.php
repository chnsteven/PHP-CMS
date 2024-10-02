<?php
require_once('../../private/initialize.php');

if (is_delete_request()) {
    // $jsonData = file_get_contents('php://input');
    // $data = json_decode($jsonData, true);

    $result = reset_comment_table();

    if ($result === true) {
        echo json_encode([
            'message' => "The comment table was reset.\n",
        ]);
    }
}
?>

<?php include(PRIVATE_FOOTER); ?>

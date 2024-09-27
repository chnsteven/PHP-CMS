<?php
require_once('../../private/initialize.php');

if (is_get_request()) {
    $comments = find_all(COMMENT_TABLE);

    if ($comments) {
        header('Content-Type: application/json');
        $res = [];
        while ($row = $comments->fetch_assoc()) {
            $res[] = [
                'id' => $row['id'],
                'anonymous' => (int)$row['anonymous'], // Cast to int for JSON consistency
                'nickname' => $row['nickname'] ?? '', // Fallback to empty string if not set
                'content' => $row['content'] ?? '' // Fallback to empty string if not set
            ];
        }
        // Return the comments as JSON
        echo json_encode($res);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["error" => "Method not allowed"]);
}

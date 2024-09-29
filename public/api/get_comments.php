<?php
require_once('../../private/initialize.php');

if (is_get_request()) {
    $comments = find_all(COMMENT_TABLE);

    if ($comments) {
        header('Content-Type: application/json');
        $res = [];

        $uuid = $_COOKIE['user_uuid'] ?? '';
        error_log("UUID from cookie: " . $uuid);

        while ($user = $comments->fetch_assoc()) {
            $comment = [];
            foreach ($user as $key => $value) {
                if ($key === "uuid") {
                    // Ensure both values are strings for comparison
                    $comment['is_user_comment'] = (string)$value === (string)$uuid;
                } elseif (gettype($value) === "integer") {
                    $comment[$key] = (int)$value;
                } elseif ($key === "nickname" && $comment["anonymous"]) {
                    $comment["nickname"] = "?????";
                } else {
                    $comment[$key] = $value;
                }
            }
            $res[] = $comment;
        }
        // Return the comments as JSON
        echo json_encode($res);
    } else {
        echo json_encode(["error" => "No comments found."]);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["error" => "Method not allowed"]);
}

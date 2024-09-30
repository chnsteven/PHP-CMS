<?php
require_once('../../private/initialize.php');

if (is_get_request()) {
    $comments = find_all(COMMENT_TABLE);

    if ($comments) {
        header('Content-Type: application/json');
        $res = [];

        $uuid = $_GET['uuid'] ?? "";

        while ($user = $comments->fetch_assoc()) {
            $comment = [];
            foreach ($user as $key => $value) {
                if ($key === "uuid") {
                    $comment['is_user_comment'] = $value === $uuid; // Check against the UUID from session storage
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
        echo json_encode(["uuid" => $uuid, "comments" => $res]);
    } else {
        echo json_encode(["error" => "No comments found."]);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["error" => "Method not allowed"]);
}

<?php
require_once('../../private/initialize.php');

if (is_get_request()) {
    $limit = $_GET['limit'] ?? "";
    $uuid = $_GET['uuid'] ?? "";

    if ($limit) {
        $data = find_all(COMMENT_TABLE, ["limit" => $limit]);
    } else {
        $data = find_all(COMMENT_TABLE);
    }

    $num_of_rows = $data['total_rows'];
    $comments = $data['result'];


    if ($comments) {
        header('Content-Type: application/json');
        $res = [];

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
        echo json_encode([
            "uuid" => $uuid,
            "num_of_rows" => $num_of_rows,
            "comments" => $res
        ]);
    } else {
        echo json_encode(["error" => "No comments found."]);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["error" => "Method not allowed"]);
}

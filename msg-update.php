<?php

$filename = "admin-setup/config.php";
if (file_exists($filename)) {
    include_once $filename;
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    $message_query = "SELECT * FROM message";
    $stmt = $dbh->prepare($message_query);
    $result = $stmt->execute();
    if ($result) {
        while ($row_message_obj = $stmt->fetchObject()) {
            $user_id = $row_message_obj->user_id;
            $user_query = "SELECT username FROM users WHERE id = :id LIMIT 1";
            $users_stmt = $dbh->prepare($user_query);
            $users_stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
            $result = $users_stmt->execute();
            if ($result) {
                $row_user_obj = $users_stmt->fetchObject();
                $username = $row_user_obj->username;
                $message_text = $row_message_obj->message_text;
                echo "<p>{$username} say: </p>";
                echo "<span class='user-msg'>{$message_text}</span>";
                echo '<br><br>';
            } else {
                echo "Error With Retrieve user data";
                return;
            }
        }
    } else {
        echo "Error With Retrieve message data";
        return;
    }
} else {
    echo "Database Configuration Not Set";
}
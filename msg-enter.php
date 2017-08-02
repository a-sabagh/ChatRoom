<?php

$filename = "admin-setup/config.php";
if (file_exists($filename)) {
    include_once 'admin-setup/config.php';
    $username = $_POST['username'];
    $message_text = $_POST['message'];
    $message_time = time();
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    $user_query = "SELECT id FROM users WHERE username = :username LIMIT 1";
    $stmt = $dbh->prepare($user_query);
    $stmt->bindParam(":username", $username);
    $result = $stmt->execute();
    $user_row_obj = $stmt->fetchObject();
    $user_id = $user_row_obj->id;
    $msg_query = "INSERT INTO message ( "
            . "user_id , message_text , message_time "
            . ")VALUES("
            . ":user_id , :message_text , FROM_UNIXTIME(:message_time)"
            . ")";
    $stmt = $dbh->prepare($msg_query);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->bindParam(":message_text", $message_text, PDO::PARAM_STR);
    $stmt->bindParam(":message_time", $message_time, PDO::PARAM_STR);
    $result = $stmt->execute();
    if ($result) {
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
        echo "ERROR";
    }
} else {
    echo "Database Configuration Not Set";
}
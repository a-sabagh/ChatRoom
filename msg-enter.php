<?php

$filename = "admin-setup/config.php";
if (file_exists($filename)) {
    include_once 'admin-setup/config.php';
    $username = $_POST['username'];
    $message_text = $_POST['message'];
    $message_time = time();
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    $dbh->exec("set names utf8");
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
} else {
    echo "Database Configuration Not Set";
}
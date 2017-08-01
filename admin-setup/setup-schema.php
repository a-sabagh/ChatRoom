<?php
$filename = "config.php";
if(file_exists($filename)){
    include_once 'config.php';
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB , USER , PASSWORD);
    $user_query = "CREATE TABLE IF NOT EXISTS users("
            . "id INT(3) NOT NULL AUTO_INCREMENT,"
            . "username VARCHAR(128) NOT NULL,"
            . "password VARCHAR(256) NOT NULL,"
            . "identifier VARCHAR(256),"
            . "ip VARCHAR(32) ,"
            . "last_login DATETIME,"
            . "PRIMARY KEY(id)"
            . ")";
    $dbh->query($user_query);
    $message_query = "CREATE TABLE IF NOT EXISTS message("
            . "id INT(9) NOT NULL AUTO_INCREMENT,"
            . "user_id INT(3) NOT NULL,"
            . "message_text TEXT NOT NULL,"
            . "message_time DATETIME,"
            . "PRIMARY KEY(id),"
            . "FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE"
            . ")";
    $dbh->query($message_query);
    header("Location: setup-user.php");
}else{
    echo 'configuration is not successfully';
    header("Location: index.php");
}
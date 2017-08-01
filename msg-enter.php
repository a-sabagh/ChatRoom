<?php
$filename = "admin-setup/config.php";
if (file_exists($filename)) {
    include_once 'admin-setup/config.php';
    $username = $_POST['username'];
    $user_id = 1;
    $message_text = $_POST['message'];
    $message_time = time();
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    $msg_query = "INSERT INTO message ( "
            . "user_id , message_text , message_time "
            . ")VALUES("
            . ":user_id , :message_text , FROM_UNIXTIME(:message_time)"
            . ")";
    $stmt = $dbh->prepare($msg_query);
    $stmt->bindParam(":user_id", $user_id , PDO::PARAM_INT);
    $stmt->bindParam(":message_text", $message_text , PDO::PARAM_STR);
    $stmt->bindParam(":message_time", $message_time , PDO::PARAM_STR);
    $result = $stmt->execute();
    if($result){
        echo "<p>{$username} say: </p>";
        echo "<span class='user-msg'>{$message_text}</span>";
        echo '<br><br>';
    }else{
        echo "ERROR";
    }
    
} else {
    echo "Database Configuration Not Set";
}
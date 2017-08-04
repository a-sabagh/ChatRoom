<?php
session_start();
$filename = "admin-setup/config.php";
if (file_exists($filename)) {
    include_once $filename;
    $i = 20;
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    while ($i > 0) :
        $last_message_time = (isset($_SESSION['chatroom_message_time'])) ? $_SESSION['chatroom_message_time'] : 0;
        $message_query = "SELECT * FROM message WHERE message_time > FROM_UNIXTIME(:time)";
        $stmt = $dbh->prepare($message_query);
        $stmt->bindParam(":time", $last_message_time, PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result) {
            if ($stmt->rowCount() > 0) {
                while ($row_message_obj = $stmt->fetchObject()) :
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
                endwhile;
                $_SESSION['chatroom_message_time'] = time();
                break;
            } else {
                $i--;
                sleep(1);
            }
        } else {
            echo "Error With Retrieve message data";
            return;
        }
    endwhile;
} else {
    echo "Database Configuration Not Set";
}
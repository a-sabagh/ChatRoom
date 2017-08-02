<?php

session_start();
include_once "admin-setup/config.php";

if (isset($_POST['login'])) {
    $username = strip_tags(htmlspecialchars($_POST['username']));
    $password = strip_tags(htmlspecialchars($_POST['password']));
    $remember = (isset($_POST['remember']))? $_POST['remember'] : "";
    do_login($username, $password, $remember);
}

if (isset($_GET['logged_out']) && $_GET['logged_out'] == 'true') {
    do_logout();
}

function is_user_login() {
    if (isset($_SESSION['chatroom_login'])) {
        return TRUE;
    } else {
        if (isset($_COOKIE['chatroom_identifier'])) {
            $statement = "SELECT * FROM users WHERE username=:username";
            $stat = $dbh->prepare($statement);
            $stat->bindParam(":username", $username);
            $result = $stat->execute();
            if ($result) {
                $row_obj = $stat->fetchObject();
                $identifier = $row_obj->identifier;
                if ($identifier == $_COOKIE['chatroom_identifier']) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
}

function do_login($username, $password, $remember) {
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    $statement = "SELECT * FROM users WHERE username=:username";
    $stat = $dbh->prepare($statement);
    $stat->bindParam(":username", $username);
    $result = $stat->execute();
    if ($result) {
        $row_obj = $stat->fetchObject();
        $check_password = (md5($password) == $row_obj->password) ? TRUE : FALSE;
        if ($check_password) {
            if (isset($remember)) {
                $_SESSION['chatroom_login'] = 'true';
                $_SESSION['chatroom_username'] = $username;
                $ip = $_SERVER['REMOTE_ADDR'];
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
                $salt = rng_random_string();
                $identifier = md5($ip . $salt . $user_agent);
                $statement = "UPDATE users SET identifier=:identifier WHERE username=:username";
                $stat = $dbh->prepare($statement);
                $stat->bindParam(":identifier", $identifier);
                $stat->bindParam(":username", $username);
                $result = $stat->execute();
                if ($result) {
                    setcookie('chatroom_identifier', $identifier, time() + 3600);
                    setcookie('chatroom_username', $username, time() + 3600);
                    header("Location: index.php");
                }
            } else {
                $_SESSION['chatroom_login'] = 'true';
                $_SESSION['chatroom_username'] = $username;
                header("Location: index.php");
            }
        }
    } else {
        return FALSE;
    }
}

function rng_random_string() {
    $characters = "QWERTYUIOPQASDFGHJKLZXCVBNM";
    $characters .= "qwertyuiopasdfghjklzxcvbnm";
    $characters .= "1234567890";
    $characters_length = strlen($characters);
    $random_string = '';
    for ($i = 0; $i < 7; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    return $random_string;
}

function do_logout() {
    if (isset($_COOKIE['chatroom_username'])) {
        $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
        $username = $_COOKIE['chatroom_username'];
        $statement = "UPDATE users SET identifier='' WHERE username=:username";
        $stat = $dbh->prepare($statement);
        $stat->bindParam(":username", $username);
        $stat->execute();
    }
    unset($_SESSION['chatroom_login'], $_SESSION['chatroom_username']);
    unset($_COOKIE['chatroom_identifier']);
    unset($_COOKIE['chatroom_username']);
    session_destroy();
    setcookie("chatroom_identifier", "", -1);
    setcookie("chatroom_username", "", -1);
    header("Location: index.php");
}

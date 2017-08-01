<?php
if (isset($_POST['setup_user']) && file_exists("config.php")) {
    include_once 'config.php';
    $dbh = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USER, PASSWORD);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $statement = "INSERT INTO users(username , password , ip ) VALUES( :username , :password , :ip )";
    $stmt = $dbh->prepare($statement);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", md5($password));
    $stmt->bindParam(":ip", $ip);
    $result = $stmt->execute();
    if ($result) {
        session_destroy();
        if (isset($_SESSION['login']))
            unset($_SESSION['login']);
        if (isset($_SESSION['username']))
            unset($_SESSION['username']);
        if (isset($_COOKIE['identifier'])) {
            unset($_COOKIE['user_identifier']);
            setcookie('user_identifier', '', -1);
        }
        if(isset($_COOKIE['username'])){
            unset($_COOKIE['username']);
            setcookie('username', '', -1);
        }
        header("Location: ../index.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SetupConfig</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" >
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" >
        <style>
            br{
                margin: 15px 0;
                display: block;
                width: 100%;
            }
            @media screen and (min-width: 980px){
                .jumbotron{
                    min-height: 350px;
                }
            }

        </style>
    </head>
    <body>
        <div class="container">
            <br><br><br>
            <h2 class="text-center">Create User</h2><br>
            <div class="jumbotron">
                <br><br>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3"><b>Username :</b></div>
                        <div class="col-md-7">
                            <input id="fname" name="username" class="form-control" type="text">
                        </div><br>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3"><b>Password :</b></div>
                        <div class="col-md-7">
                            <input id="fname" name="password" class="form-control" type="text">
                        </div><br>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-11">
                            <br><br> 
                            <input type="submit" name="setup_user" class="btn btn-default" value="Create User" >
                        </div>
                    </div>
                </form>
            </div><!--.jumbotron-->
        </div><!--.container-->
    </body>
</html>

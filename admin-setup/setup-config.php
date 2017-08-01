<?php 
if(isset($_POST['setup_config'])){
    $dbname = $_POST['dbname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $host = $_POST['host'];
    $file_mode = "w";
    $file_name = "config.php";
    $handle = fopen($file_name, $file_mode);
    $file_content = "<?php\n"
            . "define('HOST', '{$host}');\n"
            . "define('USER' , '{$username}');\n"
            . "define('PASSWORD' , '{$password}');\n"
            . "define('DB' , '{$dbname}');\n";
    fwrite($handle, $file_content);
    fclose($handle);
    header("Location: setup-schema.php");
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
                    min-height: 500px;
                }
            }

        </style>
    </head>
    <body>
        <div class="container">
            <br><br><br>
            <h2 class="text-center">DataBase Details</h2><br>
            <div class="jumbotron">
                <span>below you must enter your database details.if you not sure about this,contact your host:</span><br>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3"><b>Database Name :</b></div>
                        <div class="col-md-7">
                            <input id="fname" name="dbname" class="form-control" value="chatroom" type="text">
                        </div><br>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3"><b>Username :</b></div>
                        <div class="col-md-7">
                            <input id="fname" name="username" value="username" class="form-control" type="text">
                        </div><br>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3"><b>Password :</b></div>
                        <div class="col-md-7">
                            <input id="fname" name="password" value="password" class="form-control" type="text">
                        </div><br>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3"><b>Database Host :</b></div>
                        <div class="col-md-7">
                            <input id="fname" name="host" value="localhost" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-11">
                            <br><br> 
                            <input type="submit" name="setup_config" class="btn btn-default" value="Setup Config" >
                        </div>
                    </div>
                </form>
            </div><!--.jumbotron-->
        </div><!--.container-->
    </body>
</html>

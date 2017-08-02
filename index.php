<?php require_once 'admin-setup/setup.php'; ?>
<?php include_once 'login.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ChatRoom</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="assets/css/reset.css" >
        <link rel="stylesheet" href="assets/css/bootstrap.css" >
        <link rel="stylesheet" href="assets/css/bootstrap-theme.css" >
        <link rel="stylesheet" href="assets/css/style.css" >
        <script src="assets/js/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <?php if (is_user_login()) { ?>
            <script>
                $(document).ready(function () {
                    var username = "<?php echo $_SESSION["chatroom_username"]; ?>";
                    $(".chat-input").keydown(function (e) {
                        if (e.which == '13') {
                            var message = $(".chat-input").val();
                            var jqxhr = $.ajax({
                                url: "msg-enter.php",
                                type: "POST",
                                data: {
                                    username: username,
                                    message: message
                                },
                                success: function (data) {
                                    $(".chat-body").html(data);
                                }
                            });
                            jqxhr.always(function () {
                                $(".chat-input").val("");
                                $(".chat-body").scrollTop($(".chat-body").prop("scrollHeight"));
                            });
                        }
                    });
                    function update_chatroom() {
                        var jqxhr = $.ajax({
                            url: "msg-update.php",
                            method: "POST",
                            success: function (data) {
                                $(".chat-body").html(data);
                            }
                        });
                    }
                    setInterval(update_chatroom, 1000);
                    update_chatroom();
                });
            </script>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <span class="navbar-brand">Welcome <?php echo $_SESSION['chatroom_username']; ?><a href="login.php?logged_out=true" > (logout) </a></span>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class="vertical-space"></div>
                <div class="col-md-4 hidden-sm hidden-xs"></div>
                <div class="chatbox col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3>CHATROOM</h3></div><!--.panel-heading-->
                        <div class="chat-body panel-body"></div><!--.chat-body-->
                        <div class="panel-footer">
                            <textarea class="chat-input"></textarea>
                        </div><!--.panel-footer-->
                    </div><!--.chat-box-->
                </div><!--.chatbox-->
                <div class="col-md-4 hidden-sm hidden-xs"></div>
            </div>
        <?php } else { ?>
            <div class="vertical-space"><br></div>
            <div class="row login">
                <div class="col-md-4 hidden-sm"></div>
                <div class="col-md-4">
                    <form action="login.php" method="post">
                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Login</b><span class="login-msg"></span></div><!--.panel-header-->
                            <div class="panel-body">
                                <div class="form-group"><input type="text" name="username" class="form-control" placeholder="username"></div>
                                <div class="form-group"><input type="password" name="password" class="form-control" placeholder="password"></div>
                                <label><input type="checkbox" name="remember" class="remember" > Remember me</label>
                            </div><!--.panel-body-->
                            <div class="panel-footer clearfix">
                                <input class="btn btn-default pull-right" type="submit" name="login" value="Login">
                            </div><!--.panel-footer-->
                        </div><!--.panel-default-->
                    </form>
                </div>
                <div class="col-mx-4 hidden-sm"></div>
            </div><!--.login-->
        <?php } ?>
    </body>
</html>

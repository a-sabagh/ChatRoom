<?php require_once 'admin-setup/setup.php'; ?>
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
        <script>
            $(document).ready(function(){
                var username = "abolfazl";
                $(".chat-input").keydown(function(e){
                    if(e.which == '13'){
                        var message = $(".chat-input").val();
                        var jqxhr = $.ajax({
                            url: "msg-enter.php",
                            type: "POST",
                            data: {
                                username: username,
                                message: message
                            },
                            success: function(data){
                                $(".chat-body").html(data);
                            }
                        });
                        jqxhr.always(function(){
                            $(".chat-input").val("");
                        });
                    }
                });
            });
        </script>
    </head>
    <body>
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
    </body>
</html>

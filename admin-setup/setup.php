<?php
$filename = "admin-setup/config.php";
if(file_exists($filename)){
    return TRUE;
}else{
    header("Location: admin-setup/setup-config.php");
}
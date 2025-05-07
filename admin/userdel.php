<?php
include("adminsession.php");
    if(!isset($_GET["email"])) {
        header("location: /admin/user.php");
        exit;
    }

    $email = $_GET["email"];
    
    include("../DATABASE.php");
    $con->query("DELETE FROM users WHERE email='$email' LIMIT 1");
    header("location: /admin/user.php");
    echo $email;
?>
<?php
include("adminsession.php");
    if(!isset($_GET["id"])) {
        header("location: /admin");
        exit;
    }

    $id = $_GET["id"];
    $table  = "products";
    if(isset($_GET["category"])) {
        $table = "categories";
    }
    include("../DATABASE.php");
    $con->query("DELETE FROM $table WHERE id=$id  LIMIT 1");
    header("location: /admin");
    echo $id;
?>
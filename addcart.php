<?php
include "./utils.php";
include "./session.php";
if(isset($_GET["productId"]) && $isLogged) {
    addToCart($_GET["productId"],$email);
} 
header(("location: index.php"));
<?php
session_start();
$isLogged = false;
$isAdmin = false;

if (isset($_SESSION["email"])) {
    $isLogged = true;
    $email = $_SESSION["email"];
}
if(isset($_SESSION["authlevel"]) && $_SESSION["authlevel"] == "1") {
    $isAdmin = true;
}
?>
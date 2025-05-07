<?php
include("session.php");
include("./DATABASE.php");
if(!$isLogged) {
    exit;
}
    mail("sitesahibi@gmail.com","Yeni sipariş","Yeni sipariş geldi: adres bu, telefon bu. toplam bu, ürünler bu");
    $con->query("DELETE FROM cart WHERE email='$email'");
    header("location: /index.php?status=done");
?>
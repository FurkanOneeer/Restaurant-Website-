<?php
include ("../session.php");
if (!$isAdmin) {
    header("location: /index.php?admin=false");
    exit;
}

?>
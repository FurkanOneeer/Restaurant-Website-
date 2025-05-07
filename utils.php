<?php
function getCateById($id,$categories)
{
    foreach ($categories as $category) {
        if ($category[0] == $id) {
            return $category[1];
        }
    }
    return "";
}

function addToCart($productId, $email) {
    include "./DATABASE.php";
    $count = checkCart($productId, $email);
    if($count == 0) {
        $con->query("INSERT INTO cart (`email`, `productId`) VALUES('$email', $productId)");
    } else {
        $con->query("UPDATE cart SET quantity=quantity+1 WHERE email='$email' AND productId=$productId LIMIT 1");
    }
}
function removeToCart($productId, $email) {
    include "./DATABASE.php";
    $con->query("UPDATE cart SET quantity=quantity-1 WHERE email='$email' AND productId=$productId LIMIT 1");
    $count = checkCart($productId, $email);
    if($count == 0) {
        $con->query("DELETE FROM cart  WHERE email='$email' AND productId=$productId LIMIT 1");
    }
}
function checkCart($productId, $email) {
    include "./DATABASE.php";
    $rows = $con->query("SELECT * FROM cart WHERE email='$email' AND productId=$productId");
    $count = 0;
    if($rows->num_rows > 0) {
        $row = $rows->fetch_assoc();
        $count = $row["quantity"];
    }
    return $count;
}

function getTotalCart($email) {
    include "./DATABASE.php";
    $rows = $con->query("SELECT id FROM cart WHERE email='$email'");
    return $rows->num_rows;
}
?>
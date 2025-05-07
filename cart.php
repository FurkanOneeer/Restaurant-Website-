<?php
include ("./session.php");
if (!$isLogged) {
    header("location: /signup/");
    exit;
}
$total = 0;
$products = array();
include "./DATABASE.php";
$rows = $con->query("SELECT * FROM cart WHERE email='$email'");
while ($row = $rows->fetch_assoc()) {
    $productId = $row["productId"];
    $query = $con->query("SELECT * FROM products WHERE id=$productId");
    $product = $query->fetch_assoc();
    $product["quantity"] = $row["quantity"];
    array_push($products, $product);
    $total += $product["price"] * $row["quantity"];
}
function getFormatted($number)
{
    return number_format((float) $number, 2, ',', '') . " TL";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/cart.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <div class="cart">
            <div class="cart-item">
                <div class="item-details products">
                    <div class="product-card header">
                        <div class="">PRD</div>
                        <div class="quantity">AMT</div>
                        <div class="price">PRC</div>
                    </div>
                    <?php
                    foreach ($products as $product) {
                        echo '<div class="product-card border-bottom">
                        <div class="name">' . $product["name"] . '</div>
                        <div class="quantity">' . $product["quantity"] . '</div>
                        <div class="price">' . getFormatted($product["price"]) . '</div>

                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="cart-total">
            <div class="total"><span>Total Price</span> <span class="total-price"><?= getFormatted($total) ?></span>
            </div>
            <div class="button-container">
                <a href="./index.php"><button class="btn secondary-btn">Main Page</button></a>
                <form action="./order.php" method="POST">
                    <button action="./order.php" method="POST" class="btn main-btn btn-large">Buy now</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
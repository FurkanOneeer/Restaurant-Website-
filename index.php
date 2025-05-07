<?php
include "./DATABASE.php";
include "./utils.php";
$categories = array();
$q = $con->query("SELECT * FROM categories");
while ($row = $q->fetch_assoc()) {
    array_push($categories, [$row["id"], $row["name"]]);
}


$title = "All Products";
$selected = "";
if (isset($_GET["katid"])) {
    $selected = $_GET["katid"];

}

$orderBy = "id";
$orderFlow = "DESC";
if (isset($_GET["order"])) {
    $orderBy = $_GET["order"];
}
if (isset($_GET["flow"])) {
    $orderFlow = $_GET["flow"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <?php include ("header.php"); ?>

    <form action="" method="GET">
        <input type="hidden" name="flow" value="asc">
        <div class="content-header flex">
            <div class="content-title">
                <?= $title ?>
            </div>
            <div class="filters flex">
                <div class="filter">
                    <select name="katid">
                        <option value="">Filter Products</option>
                        <?php
                        for ($i = 0; $i < count($categories); $i++) {
                            $kat = $categories[$i];
                            $s = "";
                            if ($selected == $kat[0]) {
                                $s = "selected";
                            }
                            echo "<option value='" . $kat[0] . "' $s>" . $kat[1] . "</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="filter">
                    <select name="order" id="">
                        <option value="id">Default</option>
                        <option value="name">By Name</option>
                        <option value="price">By Price</option>
                    </select>
                </div>
                <button>Apply Filter</button>
            </div>
        </div>
    </form>
    <div class="product-container">
        <?php
        $where = "";
        if(strlen($selected)>0) {
            $where = "WHERE catid=$selected";
        }
        $query = "SELECT * FROM products $where ORDER BY $orderBy $orderFlow";
        $products = $con->query($query);
        while ($row = $products->fetch_assoc()) {
            $resimURL = "/assets/products/" . $row["id"] . ".jpg";
            $name = $row["name"];
            $price = $row["price"];
            $releaseDate = $row["releaseDate"];
            $formatted = date("d-m-Y", strtotime($releaseDate));
            $description = $row["description"];
            $catid = $row["catid"];
            $catname = getCateById($catid, $categories);
            $adet = 0;
            if($isLogged) {
                $adet = checkCart($row["id"],$email);
            }
            echo '<div class="product-card">
        <img src="' . $resimURL . '" width="100px"/>
        <div class="product-name">' . $name . '</div>
        <div class="product-price">' . $price . ' TL</div>
        <div class="product-releaseDate">Release Date: ' . $formatted . ' UTC</div>
        <div style="margin:0.4rem 0; font-weight:light; font-size: 1.1rem">' . $catname . '</div>
        <div class="product-description">' . $description . '</div>
        <div class="add-to-cart-button">
       ';

       if($adet > 0) {
        echo '<div class="flex" style="gap:20px; justify-content:center; width:100%"><a style="width:auto !important;" href="/removecart.php?productId=' . $row["id"] . '"><button>-</button></a>'
        .$adet.'<a style="width:auto !important;" href="/addcart.php?productId=' . $row["id"] . '"><button>+</button></a></div>';
       } else {
        echo ' <a href="/addcart.php?productId=' . $row["id"] . '"><button>Add To Cart</button></a>';
       }

       echo' </div>
    </div>';
        }
        ?>
    </div>
    <div class="footer flex">
        <div class="site">
            <p>&copy; 2024 YourCompany. All rights reserved.</p>
            <p>Fresh product shopping - as good as it gets!</p>
        </div>
        <div class="flex socials">

            <div>
                <a href="https://www.facebook.com/" target="_blank" class="social">
                    <img src="/assets/images/facebook.png" alt="Facebook" style="width: 25px; height: 25px;" />
                    Facebook</a>

            </div>

            <div>
                <a class="social" href="https://www.twitter.com/" target="_blank">
                    <img src="/assets/images/x.png" alt="Twitter" style="width: 25px; height: 25px;" /> X</a>

            </div>

            <div>
                <a class="social" href="https://www.instagram.com/" target="_blank"><img
                        src="/assets/images/instagram.png" alt="Instagram" style="width: 25px; height: 25px;">
                    Instagram</a>

            </div>

        </div>
    </div>
    <?php
    if (isset($_GET["admin"])) {
        ?>
        <script>alert("You don't have permission to reach to this site");</script>
        <?php
    }

    if (isset($_GET["status"])) {
        ?>
        <script>alert("Your order has been taken!");</script>
        <?php
    }
    ?>
</body>

</html>
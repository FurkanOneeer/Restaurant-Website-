<?php
include ("adminsession.php");
include "../DATABASE.php";
include "../utils.php";
$error = "";
$q = $con->query("SELECT * from categories");
$categories = array();

while ($row = $q->fetch_assoc()) {
    array_push($categories, [$row["id"], $row["name"]]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="" style="background-color:black; padding:5px; border-radius:0.3rem margin-bottom: 1rem;">
        <a href="/admin/add.php"><button>add new product</button></a>
        <a href="/admin/catadd.php"><button>add new category</button></a>
        <a href="/admin/user.php"><button>User Table</button></a>
        <a href="../index.php"><button>Main Page</button></a>
    </div>
    <h1>Categories</h1>
    <div class="" style="margin-top:1em; display:flex; gap:1rem; flex-wrap:wrap;">
        <?php

        foreach ($categories as $category) {
            $id = $category[0];
            $name = $category[1];
            echo '<div style="border:1px solid rgba(0,0,0,0.1); border-radius:0.3rem; padding:0.3rem">
        <div style="margin:0.4rem 0; font-size: 1.1rem">' . $name . '</div>
        <div style="display:flex; justify-content:flex-end; gap:1rem; border-top:1px solid rgba(0,0,0,0.1); padding-top:0.4rem; ">
        <a href="/admin/catedit.php?id=' . $id . '"><button>edit</button></a>
        <a href="/admin/del.php?id=' . $id . '&category=1"><button>delete</button></a>
        </div>
    </div>';
        }
        ?>
    </div>

    <h1>Products</h1>
    <div class="" style="margin-top:1em; display:flex; gap:1rem; flex-wrap:wrap;">
        <?php
        $products = $con->query("SELECT * FROM products ORDER BY id DESC");
        while ($row = $products->fetch_assoc()) {
            $resimURL = "/assets/products/" . $row["id"] . ".jpg";
            $name = $row["name"];
            $price = $row["price"];
            $releaseDate = $row["releaseDate"];
            $formatted = date("d-m-Y", strtotime($releaseDate));
            $description = $row["description"];
            $catid = $row["catid"];
            $catname = getCateById($catid, $categories);

            echo '<div style="border:1px solid rgba(0,0,0,0.1); border-radius:0.3rem; padding:0.3rem">
        <img src="' . $resimURL . '" width="100px"/>
        <div style="margin:0.4rem 0; font-size: 1.1rem">' . $name . '</div>
        <div style="margin:0.4rem 0; font-weight:bold; font-size: 1.1rem">' . $price . ' TL</div>
        <div style="margin:0.4rem 0; font-weight:light; font-size: 1.1rem">' . $catname . '</div>
        <div style="margin:0.4rem 0; font-size: 0.8rem">' . $formatted . '</div>
        <div style="margin:0.4rem 0; font-size: 0.8rem">' . $description . '</div>
        <div style="display:flex; justify-content:flex-end; gap:1rem; border-top:1px solid rgba(0,0,0,0.1); padding-top:0.4rem; ">
        <a href="/admin/edit.php?id=' . $row["id"] . '"><button>edit</button></a>
        <a href="/admin/del.php?id=' . $row["id"] . '"><button>delete</button></a>
        </div>
    </div>';
        }
        ?>
    </div>
</body>

</html>
<?php
include ("adminsession.php");
include "../DATABASE.php";
include "../utils.php";
$error = "";
$q = $con->query("SELECT * from users");
$categories = array();

while ($row = $q->fetch_assoc()) {
    array_push($categories, [$row["email"], $row["name"]]);
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
        <a href="/admin/index.php"><button>Admin Page</button></a>     
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
        <div style="margin:0.4rem 0; font-size: 1.1rem">' . $email . '</div>
        <div style="display:flex; justify-content:flex-end; gap:1rem; border-top:1px solid rgba(0,0,0,0.1); padding-top:0.4rem; ">
        <a href="/admin/userdel.php?email=' . $id . '&category=1"><button>delete</button></a>
        </div>
    </div>';
        }
        ?>
    </div>
</body>

</html>
<?php
include ("session.php");
$cartCount = 0;
if($isLogged) {
    $cartCount = getTotalCart($email);
}
?>
<div class="header flex">
    <a href="/">
        <img src="./assets/images/1111.png" alt="site name">
    </a>
    <ul>

        <li><a href="/">Homepage</a></li>
        <li class="cartlink"><a href="/cart.php">Cart(<span class="count"><?=$cartCount?></span>)</a></li>
        <li><a href="./aboutus.php">About Us</a></li>
        <li><a href="#">Contact</a></li>
        <?php
        if ($isLogged) {
            echo '<li><a href="/signout.php">Sign Out</a></li>';
        } else {
            echo '<li><a href="/login/index.php">Sign Up</a></li>';
        }
        if ($isAdmin) {
            echo '<li><a href="/admin">Admin</a></li>';
        }
        ?>
    </ul>
</div>
<?php
include ("../session.php");
$error = "";

if (isset($_POST["email"]) && isset($_POST["pass"])) { // Check if email and pass are set
    $email = $_POST["email"];
    $password = $_POST["pass"];
    include ("../DATABASE.php");
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $con = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("conntection error");
    $q = $con->query("SELECT * FROM users WHERE email='$email' LIMIT 1");
    $sonuc = $q->num_rows;
    if ($sonuc > 0) {
        $hashed = $q->fetch_assoc()["password"];
        if ($hashed == md5($password)) {
            $userinfo = $con->query("SELECT * FROM users WHERE email ='$email' LIMIT 1");
            $userArray = $userinfo->fetch_array();
            $_SESSION["authlevel"] = $userArray["authlevel"];
            $isLogged = true;
            $_SESSION["email"] = $email;
            //yönlendirme
            header("location: /index.php");
        } else {
            $error = "Invalid username or password";
        }


    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/login/style.css">
</head>

<body>
    <?php
    if (!$isLogged) {
        ?>
        <div class="content">
            <!-- Logo buraya gelecek -->
            <img src="/assets/images/1111.png" alt="Logo" class="logo">
            <!-- Logo buraya gelecek -->
            <div class="text">
                Login
            </div>
            <form action="/login/index.php" method="post">
                <div class="field">
                    <input type="text" required placeholder="email" name="email">
                    <span class="fas fa-user"></span>
                </div>
                <div class="field">
                    <input type="password" required placeholder="pass" name="pass">
                    <span class="fas fa-lock"></span>
                </div>
                <div class="forgot-pass">
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit">Sign in</button>
                <div class="sign-up">
                    Not a member?
                    <a href="/signup/index.php">signup now</a>
                </div>
            </form>
        </div>
        <?php
    } else {
        echo "$email logged in. <a href='/signout.php'>Sign out</a>";
    }
    ?>


</body>

</html>
<?php
$error = "";
   if(isset($_POST["email"])) {
      $email = $_POST["email"];
      $password = $_POST["password"];
      $repassword = $_POST["repassword"];
      $name = $_POST["name"];

      $canRegister = true;
      //şifre farklılığı kontrol
      if($password != $repassword) { 
         $error = "Password does not match";
         $canRegister = false;
      } 
      //email zaten kayıtlı mı kontrol
      include "../DATABASE.php";
      $q = $con->query("SELECT email FROM users WHERE email='$email'");
      $kac = $q->num_rows;
      if($kac > 0) {
         $error = "This email already used";
         $canRegister = false;
      } 
      //şifre 4 haneden az mı kontrol
      if(strlen($password) < 4) {
         $canRegister = false;
         $error = "Password must be at least 4 character";
      }

      //kontroller tamamen doğruysa
      if($canRegister) {
         //kayıt işlemine devam et
         $hashed = md5($password);
         $con->query("INSERT INTO users (`email`,`password`,`name`) VALUES('$email','$hashed','$name')");
         header("location: /login");
      }
      
   }
?>
<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
   <!-- <title>Neumorphism Login Form UI | CodingNepal</title> -->
   <link rel="stylesheet" href="style.css">
</head>

<body>
   <?php
   $con = new mysqli("localhost:3307", "root","010203","restaurant");
   ?>
   <div class="content">
      <img src="/assets/images/1111.png" alt="Logo" class="logo">
      <div class="text">
         Sign Up
      </div>
      <form action="index.php" method="POST">
         <div class="field">
            <input type="text" id="fullname" required name="name">
            <span class="fas fa-user"></span>
            <label>Full Name</label>
         </div>
         <div class="field">
            <input type="email" id="email" required name="email" placeholder="E-mail">
            <span class="fas fa-user"></span>
         </div>
         <div class="field">
            <input type="password" id="password" required name="password">
            <span class="fas fa-lock"></span>
            <label>Password</label>
         </div>
         <div class="field">
            <input type="password" id="repassword" required name="repassword">
            <span class="fas fa-lock"></span>
            <label>Re-Enter Password</label>
         </div>
         
         <div class="button-container">
            <button class="signup-button" type="submit">Sign Up</button>
            <button class="clear-button" type="button" onclick="clearBoxes()">Clear</button>
         </div>
         <span style="color:red"><?=$error?></span>
         </form>
         <script>
            function clearBoxes() {
               document.getElementById("fullname").value = "";
               document.getElementById("email").value = "";
               document.getElementById("password").value = "";
               document.getElementById("repassword").value = "";
            }
         </script>

</body>

</html>
<?php
include ("adminsession.php");
$error = "";
if (isset($_POST["name"])) {
    $name = $_POST["name"];

    $canRegister = true;

    if (strlen($name) < 4) {
        $canRegister = false;
        $error = "cat name must be more than 4 character.";
    }

    if ($canRegister) {
        include "../DATABASE.php";
        $q = $con->query("INSERT INTO categories (`name`) VALUES('$name')");
        header("location: /admin/index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/admin/style.css">
    <title>Admin Panel</title>
</head>

<body>
    <h1>Insert Category</h1>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" required><br>

        <div class="button-container">
            <button class="upload-button" type="submit">Upload</button>
            <a href="./index.php"><button class="cancel-button" type="button" value="Cancel">Cancel</button></a>
        </div>
    </form>

</body>

</html>
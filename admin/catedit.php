<?php
include ("adminsession.php");
$error = "";
if (!isset($_GET["id"])) {
    header("location: /admin");
    exit;
}

$id = $_GET["id"];
include ("../DATABASE.php");
$categories = $con->query("SELECT * FROM categories WHERE id=$id");
if ($categories->num_rows < 1) {
    header("location: /admin");
}
$row = $categories->fetch_assoc();

$name = $row["name"];
$id = $row["id"];

if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $upd = $con->query("UPDATE categories SET name='$name' WHERE id=$id");
    header("location: /admin");
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
    <h1>Insert Products</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Category Name:</label>
        <input type="text" id="name" name="name" value="<?= $name; ?>" required><br>

        <div class="button-container">
            <button class="upload-button" type="submit">Update</button>
            <button class="cancel-button" type="button" value="Cancel" onclick="window.history.back()">Cancel</button>
        </div>
    </form>

</body>

</html>
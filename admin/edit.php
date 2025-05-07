<?php
include ("adminsession.php");
$error = "";
if (!isset($_GET["id"])) {
    header("location: /admin");
    exit;
}

$id = $_GET["id"];
include ("../DATABASE.php");
$product = $con->query("SELECT * FROM products WHERE id=$id  LIMIT 1");
if ($product->num_rows < 1) {
    header("location: /admin");
}
$row = $product->fetch_assoc();

$name = $row["name"];
$price = $row["price"];
$catid = $row["catid"];

$releaseDate = $row["releaseDate"];
$formatted = date("Y-m-d", strtotime($releaseDate));
$description = $row["description"];
$id = $row["id"];

if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $releaseDate = $_POST["release_date"];
    $description = $_POST["description"];
    $catid = $_POST["catid"];
    $q = "UPDATE products SET `catid`=$catid, `name`='$name', `price`='$price',  `releaseDate`='$releaseDate', `description`='$description' WHERE id=$id";
    $con->query($q);
    $path = "../assets/products/" . $id . ".jpg";
    if($_FILES["image"]) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $path);
    }
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
    <h1>Edit Products</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?= $name; ?>" required><br>

        <label for="name">Categories</label>
        <select name="catid" style="margin-bottom:20px; width:100%; padding:5px; border-radius:5px;">
            <?php
            $query = $con->query("SELECT * from categories");
            while ($row = $query->fetch_assoc()) {
                echo '<option value="'.$row["id"].'">' . $row["name"] .'</option>';
            }
            ?>
        </select>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?= $price; ?>" required><br>

        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" value="<?= $formatted; ?>" required><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" maxlength="18" value="<?= $description; ?>" required><br>
        <p id="charCount">0/18 characters</p>

        <label for="image">Upload Picture:</label>
        <input type="file" id="image" name="image" value="$image" accept="image/*"><br>

        <div class="button-container">
            <button class="upload-button" type="submit">Update</button>
            <a href="./index.php"><button class="cancel-button" type="button" value="Cancel">Cancel</button></a>
        </div>
    </form>

    <script>
        const descriptionInput = document.getElementById('description');
        const charCountElement = document.getElementById('charCount');

        descriptionInput.addEventListener('input', updateCharCount);

        function updateCharCount() {
            const currentLength = descriptionInput.value.length;
            charCountElement.textContent = `${currentLength} / 18 characters`;
        }
    </script>
    
</body>

</html>
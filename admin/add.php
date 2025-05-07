<?php
include ("adminsession.php");
include "../DATABASE.php";
$error = "";
if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $release_date = $_POST["release_date"];
    $description = $_POST["description"];
    $catid = $_POST["catid"];

    $canRegister = true;

    if (strlen($name) < 4) {
        $canRegister = false;
        $error = "Product name must be more than 4 character.";
    }

    if ($canRegister) {
        $q = $con->query("INSERT INTO products (`name`,`price`,`releaseDate`,`description`, `catid`) VALUES('$name','$price','$release_date','$description', $catid)");
        $productId = $con->insert_id;
        $path = "../assets/products/" . $productId . ".jpg";
        move_uploaded_file($_FILES["image"]["tmp_name"], $path);
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
    <h1>Insert Products</h1>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br>

        <select name="catid" style="margin-bottom:20px; width:100%; padding:5px; border-radius:5px;">
            <?php
            $query = $con->query("SELECT * from categories");
            while ($row = $query->fetch_assoc()) {
                echo '<option value="'.$row["id"].'">' . $row["name"] .'</option>';
            }
            ?>
        </select>
        
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br>

        <label for="release_date">Release Date:</label>
        <input type="date" id="release_date" name="release_date" required><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" maxlength="18" required><br>
        <p id="charCount">0/18 characters</p>

        <label for="image">Upload Picture:</label>
        <input type="file" id="image" name="image" accept="image/*"><br>

        <div class="button-container">
            <button class="upload-button" type="submit">Upload</button>
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
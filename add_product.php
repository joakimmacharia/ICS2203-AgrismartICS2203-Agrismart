<?php
session_start();//start session



error_reporting(E_ALL);// to show errors
ini_set('display_errors',1);

/* ---------- PROTECT PAGE ---------- */

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();

}
//farmers only check
if($_SESSION['role'] != 'farmer'){ 

    header("Location: dashboard.php");
    exit();

}

include("db.php");//database connection

$message = ""; //default empty message

/* ---------- FORM SUBMISSION ---------- */

if(isset($_POST['add_product'])){

    $product_name = trim($_POST['product_name']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $description = trim($_POST['description']);

    $farmer_id = $_SESSION['user_id'];

    /* ---------- IMAGE UPLOAD ---------- */

    $imageName = "";

    if(
        isset($_FILES['image']) &&
        $_FILES['image']['error'] == 0
    ){

        $imageName =
        time() . "_" .
        basename($_FILES['image']['name']);

        $tmpName =
        $_FILES['image']['tmp_name'];

        $uploadPath =
        "uploads/" . $imageName;

        move_uploaded_file(
            $tmpName,
            $uploadPath
        );

    }

    /* ---------- PREPARED SQL ---------- */

    $sql = "INSERT INTO products
    (
        farmer_id,
        product_name,
        category,
        price,
        quantity,
        description,
        image
    )
    VALUES (?,?,?,?,?,?,?)";

    $stmt =
    mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param(

        $stmt,

        "issdiss",

        $farmer_id,
        $product_name,
        $category,
        $price,
        $quantity,
        $description,
        $imageName

    );

    /* ---------- EXECUTE ---------- */

    if(mysqli_stmt_execute($stmt)){

        $message =
        "<div class='success-box'>
        ✅ Product added successfully!
        </div>";

    }else{

        $message =
        "<div class='error-box'>
        ❌ Error:
        ".mysqli_stmt_error($stmt)."
        </div>";

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Add Product</title>

<link rel="stylesheet"
href="css/style.css">

</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->

    <div class="sidebar">

        <h2>AgriSmart</h2>

        <a href="dashboard.php">
        Dashboard
        </a>
        <a href="view_products.php">
My Products
</a>

        <a href="add_product.php">
        Add Product
        </a>

        <a href="logout.php">
        Logout
        </a>

    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content">

        <h1 class="page-title">

        Add Product

        </h1>

        <!-- DYNAMIC MESSAGE -->

        <?php

        if(!empty($message)){

            echo $message;

        }

        ?>

        <!-- FORM CARD -->

        <div class="form-card">

            <form
            method="POST"
            enctype="multipart/form-data">

                <input
                type="text"
                name="product_name"
                placeholder="Product Name"
                required>

                <br><br>

                <input
                type="text"
                name="category"
                placeholder="Category"
                required>

                <br><br>

                <input
                type="number"
                step="0.01"
                name="price"
                placeholder="Price"
                required>

                <br><br>

                <input
                type="number"
                name="quantity"
                placeholder="Quantity"
                required>

                <br><br>

                <textarea
                name="description"
                rows="5"
                placeholder="Description"
                style="width:100%;padding:12px;">
                </textarea>

                <br><br>

                <label>

                Upload Product Image

                </label>

                <br><br>

                <input
                type="file"
                name="image"
                accept="image/*">

                <br><br>

                <button
                class="btn"
                name="add_product">

                Add Product

                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>
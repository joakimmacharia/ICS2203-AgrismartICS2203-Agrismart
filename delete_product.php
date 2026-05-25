<?php

/* ---------- SESSION ---------- */

session_start();

/* ---------- SECURITY ---------- */

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}
if($_SESSION['role']!='farmer'){

    header("Location: dashboard.php");
    exit();
}
/* ---------- DATABASE ---------- */
include("db.php");

/* ---------- CHECK ID ---------- */

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $farmer_id =
    $_SESSION['user_id'];
    /* ---------- GET IMAGE ---------- */
    $sql =
    "SELECT image
    FROM products
    WHERE id=? AND farmer_id=?";

    $stmt =
    mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $id,
        $farmer_id
    );

    mysqli_stmt_execute($stmt);

    $result =
    mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result)==1){

        $product =
        mysqli_fetch_assoc($result);

        /* ---------- DELETE IMAGE FILE ---------- */

        if(!empty($product['image'])){

            $imagePath =
            "uploads/" .
            $product['image'];

            if(file_exists($imagePath)){

                unlink($imagePath);

            }

        }

        /* ---------- DELETE PRODUCT ---------- */

        $deleteSQL =
        "DELETE FROM products
        WHERE id=? AND farmer_id=?";
        $deleteStmt =
        mysqli_prepare(
            $conn,
            $deleteSQL
        );
        mysqli_stmt_bind_param(
            $deleteStmt,
            "ii",
            $id,
            $farmer_id
        );
        mysqli_stmt_execute(
            $deleteStmt
        );
    }
}
/* ---------- RETURN ---------- */
header(
"Location:view_products.php"
);
exit();
?>
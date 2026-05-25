<?php

/* ---------- SESSION ---------- */

session_start();

if(!isset($_SESSION['user_id'])){

header("Location: login.php");
exit();

}

if($_SESSION['role']!='farmer'){

header("Location: dashboard.php");
exit();

}

/* ---------- DB ---------- */

include("db.php");

$farmer_id =
$_SESSION['user_id'];

$message="";

/* ---------- GET PRODUCT ---------- */

if(!isset($_GET['id'])){

header("Location:view_products.php");
exit();

}

$id =
$_GET['id'];

$sql =
"SELECT *
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

if(mysqli_num_rows($result)!=1){

header("Location:view_products.php");
exit();

}

$product =
mysqli_fetch_assoc($result);

/* ---------- UPDATE ---------- */

if(isset($_POST['update_product'])){

$product_name =
trim($_POST['product_name']);

$category =
trim($_POST['category']);

$price =
trim($_POST['price']);

$quantity =
trim($_POST['quantity']);

$description =
trim($_POST['description']);

$imageName =
$product['image'];

/* ---------- NEW IMAGE ---------- */

if(
isset($_FILES['image'])
&&
$_FILES['image']['error']==0
){

$imageName =
time() . "_" .
basename(
$_FILES['image']['name']
);

move_uploaded_file(

$_FILES['image']['tmp_name'],

"uploads/" .
$imageName

);

}

/* ---------- UPDATE QUERY ---------- */

$updateSQL =
"UPDATE products

SET

product_name=?,
category=?,
price=?,
quantity=?,
description=?,
image=?

WHERE id=?
AND farmer_id=?";

$updateStmt =
mysqli_prepare(
$conn,
$updateSQL
);

mysqli_stmt_bind_param(

$updateStmt,
"ssdissii",
$product_name,
$category,
$price,
$quantity,
$description,
$imageName,
$id,
$farmer_id

);
if(
mysqli_stmt_execute(
$updateStmt
)
){
$message =
"<div class='success-box'>
✅ Product updated successfully.
</div>";

}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Product</title>
<link rel="stylesheet"
href="css/style.css">
</head>
<body>
<div class="dashboard">
        <div class="sidebar">
<h2>AgriSmart</h2>

<a href="dashboard.php">

Dashboard
</a>
<a href="add_product.php">
Add Product</a>

<a href="view_products.php">My Products</a>
<a href="logout.php">Logout</a>
</div>
<div class="main-content">
<h1 class="page-title">Edit Product</h1>
<?php echo $message; ?>
<div class="form-card">
<form
method="POST"
enctype="multipart/form-data">

<input
type="text"
name="product_name"

value="<?php
echo $product['product_name'];
?>"
required>
<br><br>
<input
type="text"
name="category"

value="<?php
echo $product['category'];
?>"
required>
<br><br>

<input
type="number"
step="0.01"
name="price"

value="<?php
echo $product['price'];
?>"
required>
<br><br>
<input
type="number"
name="quantity"

value="<?php
echo $product['quantity'];
?>"

required>
<br><br>
<textarea
name="description"
rows="5"
style="width:100%;padding:12px;">

<?php
echo $product['description'];
?>

</textarea>
<br><br><p>Current Image:</p><br>

<img
src="uploads/<?php
echo $product['image'];
?>"

class="product-image">

<br><br>

<input
type="file"
name="image"
accept="image/*">

<br><br>

<button
class="btn"
name="update_product">

Update Product
</button>
        </form>
            </div>
                </div>
        </div>
</body>
</html>
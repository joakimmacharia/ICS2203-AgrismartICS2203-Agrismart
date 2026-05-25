<?php

session_start();

if(!isset($_SESSION['user_id'])){

header("Location: login.php");
exit();

}

if($_SESSION['role']!='farmer'){

header("Location: dashboard.php");
exit();

}

include("db.php");

/* ---------- GET FARMER PRODUCTS ---------- */

$farmer_id =
$_SESSION['user_id'];

$sql =
"SELECT * FROM products
WHERE farmer_id=?";

$stmt =
mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$farmer_id
);

mysqli_stmt_execute($stmt);

$result =
mysqli_stmt_get_result($stmt);

?>
<!DOCTYPE html>
<html>
<head>
<title>My Products</title>
<link rel="stylesheet"
href="css/style.css">

</head>
<body>
<div class="dashboard">
<div class="sidebar">
<h2>AgriSmart</h2>

<a href="dashboard.php">Dashboard</a>
<a href="add_product.php">Add Product</a>
<a href="view_products.php">My Products</a>
<a href="logout.php">Logout</a>

    </div>
<div class="main-content">
    <h1 class="page-title">My Products</h1>

<div class="form-card">
<table>
<tr>
<th>Image</th>
<th>Name</th>
<th>Category</th>
<th>Price</th>
<th>Quantity</th>
<th>Actions</th>
</tr>

<?php

while(
$row =
mysqli_fetch_assoc($result)
){
?>
<tr>
<td>
<img
src="uploads/<?php
echo $row['image'];
?>"
class="product-image">
</td>
<td>
<?php
echo $row['product_name'];
?>
</td>
<td>
<?php
echo $row['category'];
?>
</td><td>KES
<?php
echo $row['price'];
?>
</td>
<td>
<?php
echo $row['quantity'];
?>
</td>
<td>
<a
class="btn edit-btn"
href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
<a
class="btn delete-btn"href="delete_product.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this product?')">Delete
</a>
</td>
</tr>
<?php
}
?>
</table></div>
</div>
</div>
</body>
</html>
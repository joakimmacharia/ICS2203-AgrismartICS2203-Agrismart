<?php
session_start();
include("../db.php");
$buyer_id=
$_SESSION['user_id'];
$sql=
"SELECT orders.*,
products.product_name
FROM orders
JOIN products
ON orders.product_id=
products.id
WHERE buyer_id=?";

$stmt=
mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param(
$stmt,
"i",
$buyer_id
);

mysqli_stmt_execute($stmt);
$result=
mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<link
rel="stylesheet"
href="../css/style.css">
</head>
<body>
<div class="dashboard">

<div class="sidebar">

<h2>Buyer Panel</h2>

<a href="../dashboard.php">

Dashboard

</a>

<a href="browse_products.php">

Browse Products

</a>

<a href="my_orders.php">

My Orders

</a>

<a href="../logout.php">

Logout

</a>

</div>

<div class="main-content">

<h1 class="page-title">

My Orders

</h1>
<!-- <div class="main-content">
<h1 class="page-title">My Orders</h1> -->

<table>
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Total</th>
<th>Status</th>
</tr>
<?php
while(
$row=
mysqli_fetch_assoc($result)
){
?>

<tr>
<td>
<?php
echo $row['product_name'];
?>
</td>
<td>
<?php
echo $row['quantity'];
?>
</td>
<td>KES
<?php
echo $row['total_price'];
?>
</td>
<td>
<?php
echo $row['order_status'];
?>
</td>
</tr>
<?php
}
?>
</table>
</div>
</body>
</html>
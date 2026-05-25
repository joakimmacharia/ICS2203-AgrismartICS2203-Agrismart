<?php

session_start();

include("db.php");

$farmer_id=
$_SESSION['user_id'];

$sql=
"SELECT orders.*,
products.product_name,
users.fullname

FROM orders

JOIN products
ON orders.product_id=
products.id

JOIN users
ON orders.buyer_id=
users.id

WHERE products.farmer_id=?";

$stmt=
mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$farmer_id
);

mysqli_stmt_execute($stmt);

$result=
mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html>

<head>

<title>Orders</title>

<link
rel="stylesheet"
href="css/style.css">

</head>

<body>

<div class="main-content">

<h1 class="page-title">

Incoming Orders

</h1>

<table>

<tr>

<th>Buyer</th>
<th>Product</th>
<th>Quantity</th>
<th>Total</th>

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
echo $row['fullname'];
?>

</td>

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

<td>

KES
<?php
echo $row['total_price'];
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
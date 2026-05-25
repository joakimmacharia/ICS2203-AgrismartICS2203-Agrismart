<?php

session_start();

if(!isset($_SESSION['user_id'])){

header("Location: ../login.php");
exit();

}

if($_SESSION['role']!='buyer'){

header("Location: ../dashboard.php");
exit();

}

include("../db.php");

$message="";

if(!isset($_GET['id'])){

header("Location:browse_products.php");
exit();

}

$product_id=$_GET['id'];

$sql=
"SELECT products.*,
users.fullname

FROM products

JOIN users
ON products.farmer_id=users.id

WHERE products.id=?";

$stmt=
mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param(
$stmt,
"i",
$product_id
);

mysqli_stmt_execute($stmt);

$result=
mysqli_stmt_get_result($stmt);

$product=
mysqli_fetch_assoc($result);

if(isset($_POST['buy'])){

$quantity=
$_POST['quantity'];

$location=
trim($_POST['location']);

$total=
$product['price']*$quantity;

$buyer_id=
$_SESSION['user_id'];

$insert=
"INSERT INTO orders
(
buyer_id,
product_id,
quantity,
total_price,
delivery_location
)

VALUES(?,?,?,?,?)";

$orderStmt=
mysqli_prepare(
$conn,
$insert
);

mysqli_stmt_bind_param(

$orderStmt,

"iiids",

$buyer_id,
$product_id,
$quantity,
$total,
$location

);

if(
mysqli_stmt_execute(
$orderStmt
)
){

$message=
"<div class='success-box'>
✅ Order placed successfully.
</div>";

}

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Buy Product</title>

<link
rel="stylesheet"
href="../css/style.css">

</head>

<body>

<div class="dashboard">

<div class="sidebar">

<h2>Buyer Panel</h2>

<a href="browse_products.php">

Marketplace

</a>

<a href="my_orders.php">

My Orders

</a>

</div>

<div class="main-content">

<h1 class="page-title">

Purchase Product

</h1>

<?php echo $message; ?>

<div class="form-card">

<img

src="../uploads/<?php
echo $product['image'];
?>"

class="market-image">

<h2>

<?php
echo $product['product_name'];
?>

</h2>

<p>

KES
<?php
echo $product['price'];
?>

</p>

<form method="POST">

<input
type="number"
name="quantity"
placeholder="Quantity"
required>

<br><br>

<textarea

name="location"

placeholder="Delivery Location"

required>
</textarea>
<br><br>
<button class="btn" name="buy">Place Order</button>
</form>
</div>
    </div>
        </div>
</body>
</html>
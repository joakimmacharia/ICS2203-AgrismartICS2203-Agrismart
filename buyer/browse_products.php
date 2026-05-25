<?php

session_start();

/* ---------- LOGIN CHECK ---------- */

if(!isset($_SESSION['user_id'])){

header("Location: ../login.php");
exit();

}

/* ---------- BUYERS ONLY ---------- */

if($_SESSION['role']!='buyer'){

header("Location: ../dashboard.php");
exit();

}

/* ---------- DATABASE ---------- */

include("../db.php");

/* ---------- GET PRODUCTS ---------- */

$sql =
"SELECT products.*,
users.fullname

FROM products

JOIN users

ON products.farmer_id = users.id";

$result =
mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>Browse Products</title>

<link
rel="stylesheet"
href="../css/style.css">

</head>

<body>

<div class="dashboard">

<!-- SIDEBAR -->

<div class="sidebar">

<h2>Buyer Panel</h2>

<a href="../dashboard.php">Dashboard</a>
<a href="browse_products.php">Browse Products</a>
<a href="my_orders.php">My Orders</a>
<a href="../logout.php">Logout</a>

</div>

<!-- MAIN CONTENT -->

<div class="main-content">

<h1 class="page-title">

Marketplace

</h1>

<!-- SEARCH BAR -->

<input

type="text"

id="searchInput"

placeholder="Search products..."

style="margin-bottom:25px;">

<!-- PRODUCT GRID -->

<div class="product-grid">

<?php

while(
$row=
mysqli_fetch_assoc($result)
){

?>

<div class="product-card">

<img

src="../uploads/<?php
echo $row['image'];
?>"

class="market-image">

<h3>

<?php
echo $row['product_name'];
?>

</h3>

<p>

Category:

<?php
echo $row['category'];
?>

</p>

<p>

KES
<?php
echo $row['price'];
?>

</p>

<p>Farmer:<?php echo $row['fullname'];?>

</p>
<a

class="btn"

href="place_order.php?id=<?php echo $row['id']; ?>">Buy Now</a>
</div>
<?php
}
?>
</div>
    </div>
        </div>
<script src="../js/script.js"></script>
</body>
</html>
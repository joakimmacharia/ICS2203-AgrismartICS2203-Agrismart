<?php
session_start();
if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet"
href="css/style.css">
</head>
<body>
        <nav>
            <h2>AgriSmart</h2>
<div>
<a href="logout.php">
Logout
</a></div>
    </nav>
        <section class="hero">
    <div class="card">
<h2>Welcome<?php
echo $_SESSION['fullname'];
?>
</h2>
<br>
<p>
Role:
<strong>
<?php
echo $_SESSION['role'];
?>
</strong>
</p>
<br>
<?php

/* ---------- FARMER DASHBOARD ---------- */

if($_SESSION['role']=='farmer'){

echo '

<h3>Farmer Dashboard</h3>

<p>
Manage products, marketplace listings and customer orders.
</p>

<br>

<a
class="btn"
href="add_product.php">

Add Product

</a>

<a
class="btn"
href="view_products.php">

My Products

</a>

<a
class="btn"
href="orders_farmer.php">

View Orders

</a>

';

}

/* ---------- BUYER DASHBOARD ---------- */

else{

echo '

<h3>Buyer Dashboard</h3>

<p>
Browse products, place purchases and track your orders.
</p>

<br>

<a
class="btn"
href="buyer/browse_products.php">

Browse Marketplace

</a>

<a
class="btn"
href="buyer/my_orders.php">

My Orders

</a>

';

}

?>

</div>
</section>
</body>
</html>
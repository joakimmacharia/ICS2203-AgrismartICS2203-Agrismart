
<?php

session_start();

include("db.php");

$message = "";

if(isset($_POST['login'])){

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql =
"SELECT * FROM users
WHERE email='$email'";

$result =
mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==1){

$user =
mysqli_fetch_assoc($result);

if(
password_verify(
$password,
$user['password']
)
){

$_SESSION['user_id']
=
$user['id'];

$_SESSION['role']
=
$user['role'];

$_SESSION['fullname']
=
$user['fullname'];

header(
"Location: dashboard.php"
);

exit();

}else{

$message =
"Incorrect password.";

}

}else{

$message =
"User not found.";

}

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link rel="stylesheet"
href="css/style.css">

</head>

<body>

<nav>

<h2>AgriSmart</h2>

</nav>

<section class="hero">

<div class="card">

<h2>Login</h2>

<br>

<form method="POST">

<input
type="email"
name="email"
placeholder="Email">

<br><br>

<input
type="password"
name="password"
placeholder="Password">

<br><br>

<button
class="btn"
name="login">

Login

</button>

</form>

<br>

<p>

<?php echo $message; ?>

</p>

<br>

<a href="register.php">

Create Account

</a>

</div>

</section>

</body>
</html>
<?php

include("db.php");

$message = "";

if(isset($_POST['register'])){

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    if(empty($fullname) || empty($email) || empty($password) || empty($role)){

        $message = "All fields required.";

    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users
        (fullname,email,password,role)
        VALUES
        ('$fullname','$email','$hashedPassword','$role')";

        if(mysqli_query($conn,$sql)){

            $message = "Registration successful.";

        } else {

            $message = "Email already exists.";

        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

<title>Register</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<nav>

<h2>AgriSmart</h2>

</nav>

<section class="hero">

<div class="card">

<h2>Register</h2>

<br>

<form id="registerForm" method="POST">

<input type="text"
name="fullname"
placeholder="Full Name">

<br><br>

<input type="email"
name="email"
placeholder="Email">

<br><br>

<input type="password"
name="password"
placeholder="Password">

<br><br>

<select name="role">

<option value="">
Choose Role
</option>

<option value="farmer">
Farmer
</option>

<option value="buyer">
Buyer
</option>

</select>

<br><br>

<button class="btn"
name="register">

Create Account

</button>

</form>

<br>

<p>

<?php echo $message; ?>

</p>

<br>

<a href="login.php">

Already have account?

</a>

</div>

</section>

<script src="js/script.js"></script>

</body>
</html>
<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/bib.css" rel="stylesheet" type="text/css"/>
</head>
<body class="main-bg">
    <div class="login-container text-c animated flipInX">
            <div>
                <h1 class="logo-badge text-whitesmoke"><span class="fa fa-user-circle"></span></h1>
            </div>
                <h3 class="text-whitesmoke">Pablo.Store</h3>
                <p class="text-whitesmoke">Login</p>
                <div class="signup-box">
        <h1>Sign up</h1>
        <div class="container-content">
        <form class= "margin-t"action="" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" placeholder="Masukan Username" name="username" class="form-control" required>
            <div class="form-group">
                <label>Password</label>
                <input type="password" placeholder="Masukan Password" name="password" class="form-control" required>
                <div class="form-group">
            <label>Your Email address</label>
            <input type="text" placeholder="Masukan Email" name="email" class="form-control" required>
            <input type="submit" name="submit" class="form-button button-l margin-b" value="submit">
        </form>
    </div>
    </div>
    <?php
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $password=$_POST['password'];
        $email=$_POST['email'];
        $result = mysqli_query($koneksi,"INSERT INTO pembeli(username,password,email) VALUES ('$username','$password','$email')");
		header("Location:login.php");
    }
	
    ?>


</body>
</html>
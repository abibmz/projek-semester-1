<?php
include 'koneksi.php';
session_start();
if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
if ($username!="" && $password!=""){
  $mysql = mysqli_query($koneksi, "select * from pembeli where username='$username' and password='$password'");
  if($data=mysqli_fetch_array($mysql)){  
    $_SESSION['username']=$data['username'];
    $_SESSION['password']=$data['password'];
    header("Location:index.php");
  }else{
    header("Location:login.php");
  }
}
}
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
                <h3 class="text-whitesmoke" href="home.php">Pablo.Store</h3>
                <p class="text-whitesmoke">Login</p>
            <div class="container-content">
                <form class="margin-t" action="" method="POST">
                    <div class="form-group">
                        <input type="text" name ="username" class="form-control" placeholder="Username" required="">
                    </div>
                    <div class="form-group">
                        <input type="password"  name ="password" class="form-control" placeholder="*****" required="">
                    </div>
                    <button type="submit"  name="submit" class="form-button button-l margin-b">Login</button>
    
                    <a class="text-darkyellow" href="#"><small></small></a>
                    <p class="text-whitesmoke text-center"><small>Tidak mempunyai akun?</small></p>
                    <a class="text-darkyellow" href="daftar.php"><small>Daftar</small></a>
                </form>
                <p class="margin-t text-whitesmoke"><small> Pablo.Store &copy; 2018</small> </p>
            </div>
        </div>
</body>
</html>
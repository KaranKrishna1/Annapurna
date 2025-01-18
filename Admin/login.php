<?php include('../config/constants.php'); ?>
          

<html>
  <head>
    <title> Login | Annapurna</title>
    <link rel="stylesheet" href="../admin.css">
    <link rel="stylesheet" href="../loginstyle.css">
    </head>

    <body>
      <div class="login">
        <div class="nav">
        <img src="../images/logo1.png">
        <h1 class="text-center">LOGIN</h1>
        </div>

        <?php
            if(isset($_SESSION['login'])){
              echo $_SESSION['login'];
              unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])){
              echo $_SESSION['no-login-message'];
              unset($_SESSION['no-login-message']);
            }
          ?>
        <br>

        <form action="" method="POST" class="text-center user">
          Username:
          <input type="text" name="username" placeholder="Enter Username"> <br><br><br>
          Password: 
          <input type="password" name="password" placeholder="Enter Password"> <br><br>

          <input type="submit" name="submit" value="Login" class="welcome">
        </form>
      </div>
    </body>
  
</html>


<?php 
    if (isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password =  '$password'";
        
        $res = mysqli_query($conn,$sql);

        $count = mysqli_num_rows($res);

        if($count==1){
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;
            header('location:'.SITEURL.'admin/');
        }
        else{
            $_SESSION['login'] = "<div class='error'>Username or Password did not match.</div>";
            header('location:'.SITEURL.'admin/login.php');
    }
  }
?>
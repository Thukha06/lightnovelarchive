<?php
  session_start();
  require("database.php");

  $loginidErr = ""; $passwordErr = "" ; $checkErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginid = $_POST["email"];
    $password = $_POST["password"];
    $admin = 600;
    $check = 0;

    if (empty($loginid)) {
      $loginidErr = "Email or user name is required to sign in";
      $check = 1;
    } 
    else if (!preg_match("/^[a-zA-Z][0-9a-zA-Z _]{2,23}[0-9a-zA-Z]$/",$loginid)) {
      if (!filter_var($loginid,FILTER_VALIDATE_EMAIL)) {
        $loginidErr = "Invalid user name or email format. Please try again.";
        $check = 1;
      }  
    }

    if (empty($password)) {
      $passwordErr = "Password is required to sign in";
      $check = 1;
    } else {
      function test_input($password) {
      $password = trim($password);
      $password = stripslashes($password);
      $password = htmlspecialchars($password);
      return $password;
      }
    }
      
    if ($check == 0) {
    //echo $loginid;

      $sql = "SELECT * FROM login_table WHERE (user_name='$loginid' or user_email='$loginid') and password='$password'";
      // foreach($db->query($sql) as $row) { echo $row['user_name']; }
      $stmt = $db->query($sql);
      /*** echo number of columns ***/
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row=$stmt->fetch();

      if (!(empty($row['user_email']))) {
      if($admin == $row['user_type']) {
        $_SESSION['is_locked'] = false;
        $_SESSION['logindata'] = $row['user_name'];
        echo "<script>location.href='dashboard.php';</script>";
      } else {
        $checkErr = "Only for Users with Admin Privilage";
      }
      }
      else{
        $checkErr = "Incorrect Sign-in infos. Please try again.";
      }
    }
      }
   
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Light Novel | ADMIN Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="icon" href="logos/Tab-Logo.ico">

  <style type="text/css">
    .error { color: #FF0000; }
  </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>Admin</b>Login</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <span class="error"><?php echo $checkErr; ?></span>
        <span class="error"><?php echo $loginidErr; ?></span>
        <div class="input-group mb-3">
          <input type="text" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <span class="error"><?php echo $passwordErr; ?></span>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">        
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
 
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>


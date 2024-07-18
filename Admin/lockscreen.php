<?php
  session_start();
  require("database.php");
  $loginid = $_SESSION['logindata'];
  $passwordErr = "" ; $checkErr = "";

  if (($_SERVER["REQUEST_METHOD"] == "POST")&&(isset($_POST['log_in']))) {
    $password = $_POST["password"];
    $admin = 600;
    $check = 0;

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

      $sql = "SELECT * FROM login_table WHERE user_name='$loginid' and password='$password'";
      $stmt = $db->query($sql);
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row = $stmt->fetch();
      $registerId = $row['register_id'];

      if (!(empty($row['user_email']))) {
        if($admin == $row['user_type']) {
          // After successful authentication,
          // reset the lock screen status and redirect to the admin page.
          $_SESSION['is_locked'] = false;
          header('Location: dashboard.php');
          exit;
        } else {
        $checkErr = "Only for Users with Admin Privilage";
        }

      } else {
          $checkErr = "Incorrect Sign-in infos. Please try again.";
      }
    }
  }

  $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
  $stmt = $db->query($sql);
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $row = $stmt->fetch();
  $registerId = $row['register_id'];

  $sql1 = "SELECT * FROM registration_table WHERE register_id='$registerId'";
  $stmt1 = $db->query($sql1);
  $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
  $row1 = $stmt1->fetch();
  $pf = "../".$row1['profile_photo'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Light Novel | Lockscreen</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <style type="text/css">
    .error { color: #FF0000; margin-left: 120px; }
  </style>
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href=""><b>SESSION</b>Locked</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><?php echo $loginid; ?></div>
      <span class="error"><?php echo $checkErr; echo $passwordErr; ?></span>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="<?php echo $pf; ?>" style="width: 70px; height: 70px; object-fit: cover;" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="input-group">
        <input type="password" name="password" class="form-control" placeholder="password">

        <div class="input-group-append">
          <button type="submit" name="log_in" class="btn">
            <i class="fas fa-arrow-right text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="index.php">Or sign in as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
   <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script> </strong>
    All rights reserved.
   <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://goldentkm.com/lightnovelarchive" target="_blank">Light Novel Archive</a>
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

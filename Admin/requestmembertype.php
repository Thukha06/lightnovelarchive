<?php
  session_start();
  require("database.php");

  $loginidErr = ""; $checkErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginid = $_POST["loginid"];
    $usertype = $_POST["usertype"];
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
      
    if ($check == 0) {

      $sql = "SELECT * FROM login_table WHERE (user_name='$loginid' or user_email='$loginid')";
      $stmt = $db->query($sql);
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $row=$stmt->fetch();

      $sql1 = "SELECT * FROM user_table";
      $stmt1 = $db->query($sql1);
      $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
      $users=$stmt1->fetchAll();
      
      if(!(empty($row['user_email']))) {
        $username = $row['user_name'];
        $useremail = $row['user_email'];
        $currentrole = $row['user_type'];

        foreach ($users as $row1) {
          if (($usertype) == ($row1['user_type_name'])) {
            $requestedrole = $row1['user_type'];

          // } else {
          //   $checkErr = "Invalid User Type requested. Please try again.";
          }
        }

      $sql2 = "INSERT INTO role_request (r_user_name, r_user_email, r_current_role, r_requested_role) VALUES ('$username', '$useremail', '$currentrole', '$requestedrole')";
      $db->exec($sql2);

      } else {
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
  <title>A Novel Idea | ADMIN</title>

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
      <a href="#" class="h1"><b>Submit</b>User Type</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Requesting user type change</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <span class="error"><?php echo $checkErr; ?></span>
        <span class="error"><?php echo $loginidErr; ?></span>
        <div class="input-group mb-3">
          <input type="text" name="loginid" class="form-control" placeholder="Username or Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <!-- <div class="input-group mb-3">
          <input type="text" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> -->

        <div class="row">
          <div class="col-sm-12">
            <!-- select -->
            <div class="form-group">
              <label>Select User Type</label>
                <select name="usertype" class="form-control">
                  <option value="Author">Author</option>
                  <option value="Illustrator">Illustrator</option>
                  <option value="Translator">Translator</option>
                </select>
             </div>
            </div>
          </div>

        <div class="row">        
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>

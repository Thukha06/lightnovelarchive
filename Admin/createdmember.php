<?php
  session_start();
  require("database.php");
  $loginid = "";
  $loginid = $_SESSION['logindata'];

  // Code on the admin page to check the lock screen status
  if ($_SESSION['is_locked']) {
      $_SESSION['is_locked'] = true;
      // Redirect to the lock screen page
      header('Location: lockscreen.php');
      exit;
  }

  // Initialize the lock screen status
  $_SESSION['is_locked'] = false;

  // Code on the admin page to lock the screen manually
  if (isset($_POST['log_out'])) {
      $_SESSION['is_locked'] = true;
      // Redirect to the lock screen page
      header('Location: lockscreen.php');
      exit;
  }

  $success = ''; $usertypeget="";
  $usertypenew=""; $usertypenamenew="";
  $check = 0; $typecheck = 0;
  
  // For admin photo
  $sql9 = "SELECT * FROM login_table WHERE user_name='$loginid'";
  $stmt9 = $db->query($sql9);
  $result9 = $stmt9->setFetchMode(PDO::FETCH_ASSOC);
  $row9 = $stmt9->fetch();
  $registerId9 = $row9['register_id'];

  $sql10 = "SELECT * FROM registration_table WHERE register_id='$registerId9'";
  $stmt10 = $db->query($sql10);
  $result10 = $stmt10->setFetchMode(PDO::FETCH_ASSOC);
  $row10 = $stmt10->fetch();
  $pf10 = "../".$row10['profile_photo'];

  // When 'Create' button is pressed
  if (($_SERVER["REQUEST_METHOD"] == "POST")) {
    $checknew = $_POST['checkdata'];

    if($checknew == 0) {
      $usertype = $_POST['usertype'];
      $usertypename = $_POST['usertypename'];

      // Check primary key conflict
      $sql5 = "SELECT * FROM user_table";
      $stmt5 = $db->query($sql5);
      $result5 = $stmt5->setFetchMode(PDO::FETCH_ASSOC);

      while ($row5 = $stmt5->fetch()) {
        if(($usertype == $row5['user_type'])||($usertypename == $row5['user_type_name'])) {
          $typecheck = 1;
        }
        if(($usertype == "")||($usertypename == "")) {
          $typecheck = 2;
        }
      }

      if($typecheck == 1) {
        $success = '<div class="btn btn-info" style="width: 100%;"><h4 class="card-title">Replicate Data is Detected</h4></div>';
      } else if($typecheck == 2) {
        $success = '<div class="btn btn-info" style="width: 100%;"><h4 class="card-title">Invalid Data Input is Detected</h4></div>';
      } else {

        $sql = "INSERT INTO user_table (user_type, user_type_name) VALUES ('$usertype', '$usertypename')";
        $db->exec($sql);
        $success = '<div class="btn btn-info" style="width: 100%;"><h4 class="card-title">New Usertype is Successfully Created</h4></div>';
      }
  
    } else if($checknew == 1) { // When 'Update' button(Display User Type) is pressed
      $usertypenew = $_POST['usertype'];
      $usertypenamenew = $_POST['usertypename'];

      // Check duplicate data
      $sql2 = "SELECT * FROM user_table";
      $stmt2 = $db->query($sql2);
      $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);

      while ($row2 = $stmt2->fetch()) {
        if(($usertypenew == $row2['user_type'])||($usertypenamenew == $row2['user_type_name'])) {
          $typecheck = 1;
        }
      }

      if($typecheck == 1) {
        $success = '<div class="btn btn-info" style="width: 100%;"><h4 class="card-title">Replicate Data is Detected</h4></div>';
      } else {                 
  
        $sql1 = "UPDATE user_table SET user_type_name='$usertypenamenew' WHERE 
        user_type ='$usertypenew'";
        $db->exec($sql1);
        $success = '<div class="btn btn-info" style="width: 100%;"><h4 class="card-title">User Type is Successfully Updated</h4></div>';
      } 
    }
  } else if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['usertypenew']))) {
    $usertypeget = $_GET['usertypenew'];
    $usertypenew = "";
    $usertypenamenew = "";

    $sql3 = "SELECT * FROM user_table WHERE user_type='$usertypeget'";
    $stmt3 = $db->query($sql3);
    $result3 = $stmt3->setFetchMode(PDO::FETCH_ASSOC);

    while ($row3 = $stmt3->fetch()) {
      $usertypenew = $row3['user_type'];
      $usertypenamenew = $row3['user_type_name'];
    }

    $check = 1;
  }

  // When 'Delete' button is pressed
  if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['userdeletenew']))) {
    $userdeletenew = $_GET['userdeletenew'];

    $sql4 = "DELETE FROM user_table WHERE user_type='$userdeletenew'";
    $db->exec($sql4);

    $success = '<div class="btn btn-info" style="width: 100%;"><h4 class="card-title">A User Type is Successfully Delected</h4></div>';
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Light Novel | ADMIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="icon" href="logos/Tab-Logo.ico">
  
  <script>
  function ConfirmUpdate(){
  	var msg=confirm("Are you sure want to update?");
  	if(msg)
  return true;
  	else return false;
  }
  function ConfirmDelete(){
  	var msg=confirm("Are you sure want to delete?");
  	if(msg)
  return true;
  	else return false;
  }
  function ConfirmLogout(){
    var msg=confirm("Are you sure want to Logout of session?");
    if(msg)
    return true;
    else return false;
  }
</script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed pace-primary" style="overflow-x: hidden;">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
      <img src="logos/Tab-Logo.ico" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text" style="font-size: 18px; font-weight: 500;">Light Novel<sub style="font-size: 10px;font-weight: 400; "> Admin Panel</sub></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $pf10; ?>" style="width: 35px; height: 35px; object-fit: cover;" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block"><?php echo $loginid; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                
                Dashboard
              </p>
            </a>
            
          </li>
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Member List
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="createdmember.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Type Creation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="memberlist.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Registered Members</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="requestmember.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Member Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="approvedmember.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Members</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item ">
            <a href="#" class="nav-link 
            ">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Article
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="requestarticle.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Article Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="approvedarticle.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Articles</p>
                </a>
              </li>
          </ul>
             
          <li class="nav-item">
            <a href="#" class="nav-link
            ">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Illustrations
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="requestillustration.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Illustration Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="approvedillustration.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Illustrations</p>
                </a>
              </li>  
        </ul>
         
          <!-- <li class="nav-item ">
            <a href="#" class="nav-link   
            ">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Translations
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="requesttranslation.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Translation Requests</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="approvedtranslation.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Translations</p>
                </a>
              </li>
            </ul> -->
          
          <li class="nav-header">MISCELLANEOUS</li>
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.1/" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li>
         
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="sidebar-custom" style="margin-top: 7px;">
      <a href="../profile.php" class="btn btn-link" title="Turn off Admin mode"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-power"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg></a>
      <button name="log_out" class="btn btn-secondary pos-right" style="margin-right: 5px;" title="Logout of session" onclick='return ConfirmLogout();'><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></button>
    </div>
    </form>
    <!-- /.sidebar-custom -->
  </aside> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <div class="row mb-2">
        <h1></h1>
      </div>
    <!-- Content Header (Page header) -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-6">
          <!-- left column -->
          <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">User Type Creation Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="<?php print $_SERVER['PHP_SELF'];?>" class="form-horizontal">
                <div class="card-body" style="padding-bottom: 0px;">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">User Type</label>
                    <div class="col-sm-9">
                      <input type="text" name="usertype" class="form-control" id="inputEmail3" placeholder="User Type" value="<?php echo $usertypenew;?>">
                      <input type="hidden" name="checkdata" class="form-control" value="<?php echo $check; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">User Type Name</label>
                    <div class="col-sm-9">
                      <input type="text" name="usertypename" class="form-control" id="inputPassword3" placeholder="User Type Name" value="<?php echo $usertypenamenew;?>">
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                	<?php if ($check==0) { ?>
                  <input type="submit" class="btn btn-info" name="create" value="Create"></input>
                  <input type="submit" class="btn btn-info" name="update" value="Update" disabled></input>
                    <?php } ?>
                  <?php if ($check==1) { ?>
	                 <input type="submit" class="btn btn-info" name="create" value="Create" disabled></input>
                   <input type="submit" class="btn btn-info" name="update" value="Update"></input>
                    <?php } ?>
                  <!-- <a href="dashboard.php" class="btn btn-default float-right">Cancel</a> -->
                </div>
              <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->
            <div style="width: 100%; padding: 20px; margin-bottom: 15px; border: none; border-radius: 5px; box-shadow: 1px 1px 5px #ccc;"><h6><b style="color: red;"><i>* C A U T I O N *</i></b><br><br>- Replicate Data for Primary, <i><ins>User Type</ins></i> is not allowed.<br><br>- Replicate Data for already existing <i><ins>User Type Name</ins></i> is not allowed.</h6></div>
            <?php echo $success; ?>
          </div>
          <!-- col -->
               
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Display User Type</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>User Type</th>
                      <th>User Type Name</th>
                      <th>Edit</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                      	$sql6 = "SELECT * FROM user_table";
                      	$stmt6 = $db->query($sql6);
                      	$result6 = $stmt6->setFetchMode(PDO::FETCH_ASSOC);
                      	while ($row6 = $stmt6->fetch()) {
                  	?>
                    <tr>
                    	<?php $usernew=$row6['user_type'];?>
                      <td><?php echo $usernew; ?></td>
                      <td><?php echo $row6['user_type_name']?></td>
                      <td><?php echo "<a href='createdmember.php?usertypenew=$usernew' onclick='return ConfirmUpdate();'><button class='btn btn-block btn-primary btn-sm'>Update</button></a>" ?></td>
                      <td><?php echo "<a href='createdmember.php?userdeletenew=$usernew' onclick='return ConfirmDelete();'><button class='btn btn-block btn-danger btn-sm'>Delete</button></a>";?></td>
                    </tr>
                	<?php } ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- col -->
        </div>        
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
  </div>
  <!-- /.content-wrapper -->
    
  <footer class="main-footer">
   <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script> </strong>
    All rights reserved.
   <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://goldentkm.com/lightnovelarchive" target="_blank">Light Novel Archive</a>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- pace-progress -->
<script src="plugins/pace-progress/pace.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>


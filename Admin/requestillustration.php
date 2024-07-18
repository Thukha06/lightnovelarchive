<?php
session_start();
  require("database.php");
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

  $one=1;
  $zero=0;

  $sql = "SELECT * FROM image_table WHERE accept_reject='$zero'";
  $stmt = $db->query($sql);
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

  if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['rejectillustration']))) {
    $imageid=$_GET['rejectillustration'];
    $sql2 = "DELETE FROM image_table WHERE image_id='$imageid'";
    $db->exec($sql2);
    echo "<script>location.href='requestillustration.php';</script>";
  }
  if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['acceptillustration']))) {
    $imageid=$_GET['acceptillustration'];
    $sql3 = "UPDATE image_table SET accept_reject='$one'WHERE image_id='$imageid'";
    $db->exec($sql3);
    echo "<script>location.href='requestillustration.php';</script>";
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
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <link rel="icon" href="logos/Tab-Logo.ico">

  <script type="text/javascript">
  function ConfirmAccept(){
    var msg=confirm("Are you sure want to Accept?");
    if(msg)
  return true;
    else return false;
  }
  function ConfirmReject(){
    var msg=confirm("Are you sure want to Reject?");
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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed pace-primary">
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
          <li class="nav-item">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Member List
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="createdmember.php" class="nav-link">
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
             <li class="nav-item menu-open">
            <a href="#" class="nav-link  active
            ">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Illustrations
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="requestillustration.php" class="nav-link active">
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
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
            
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable for Requested Illustration</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Title</th>
                    <th>Illustrator Name</th>
                    <th>Preview Image</th>
                    <th>Uploaded Date</th>
                    <th>Accept/Reject</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php while ($row = $stmt->fetch()) { ?>
                    <?php 
                        $filename = $row['image_path'];
                        $imgpath = $row['image_path']; ?>
                  <tr>
                    <?php $imageid = $row['image_id']; ?>
                    <td><?php echo $row['img_title'] ?></td>
                    <td><?php echo $row['user_name'] ?></td>
                    <td><?php echo "<a href='previewimageintable2.php?imgpath=$filename'>$imgpath</a>" ?></td>
                    <td><?php echo $row['img_date'] ?></td>
                   
                    <td style="width: 130px;">                      
                        <div class="row">
                        <div class="col-6">
                          <?php echo "<a class='button' href='requestillustration.php?acceptillustration=$imageid' onclick='return ConfirmAccept();'><button class='btn btn-block btn-success btn-sm'>Accept</button></a>" ?>
                        </div>
                        <div class="col-6">
                          <?php echo "<a class='button' href='requestillustration.php?rejectillustration=$imageid' onclick='return ConfirmReject();'><button class='btn btn-block btn-danger btn-sm'>Reject</button></a>" ?>
                        </div>
                        </div>
                    </td>
                  </tr>
                   <?php } ?>
                </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
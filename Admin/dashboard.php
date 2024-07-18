<?php
  session_start();
  require("database.php");
  $loginid = "";
  $loginid = $_SESSION['logindata'];

  // Code on the admin page to check the lock screen status
  if (!empty($_SESSION['is_locked'])) {
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

  $count = 0; $Reader = 0; 
  $Article = 0; $Author = 0;
  $Illustrator = 0; $Illustration = 0;

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

  // Count total members
  $sql = "SELECT * FROM login_table";
  $stmt = $db->query($sql);
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

  while($row=$stmt->fetch()){
    $count++;
  }

  // Count number of authors
  $author=701;
  $sql1 = "SELECT * FROM login_table WHERE user_type='$author'";
  $stmt1 = $db->query($sql1);
  $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);

  while($row1=$stmt1->fetch()){
      $Author++;
  }

  // Count number of illustrators
  $illutrator=702;
  $sql2 = "SELECT * FROM login_table WHERE user_type='$illutrator'";
  $stmt2 = $db->query($sql2);
  $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);

  while($row2=$stmt2->fetch()){
    $Illustrator++;
  }

  // Count number of general users(Readers)
  $reader=800;
  $sql3 = "SELECT * FROM login_table WHERE user_type='$reader'";
  $stmt3 = $db->query($sql3);
  $result3 = $stmt3->setFetchMode(PDO::FETCH_ASSOC);

  while($row3=$stmt3->fetch()){
      $Reader++;
  }

  // Count number of articles
  $sql4 = "SELECT * FROM article_table";
  $stmt4 = $db->query($sql4);
  $result4 = $stmt4->setFetchMode(PDO::FETCH_ASSOC);

  while($row4=$stmt4->fetch()){
      $Article++;
  }

  // Count number of illustrations
  $sql5 = "SELECT * FROM image_table";
  $stmt5 = $db->query($sql5);
  $result5 = $stmt5->setFetchMode(PDO::FETCH_ASSOC);

  while($row5=$stmt5->fetch()){
      $Illustration++;
  }

  // For latest members
  $sql6 = "SELECT * FROM login_table WHERE (user_type!=600) ORDER BY register_id DESC LIMIT 12";
  $stmt6 = $db->query($sql6);
  $result6 = $stmt6->setFetchMode(PDO::FETCH_ASSOC);

  // For latest requests
  $sql8 = "SELECT content_id, content_type, content_title, user_name, date FROM (
    SELECT article_id AS content_id, 'article' AS content_type, article_title AS content_title, user_name, published_date AS date FROM article_table WHERE publish_unpublish = 0 
    UNION ALL 
    SELECT image_id AS content_id, 'image' AS content_type, img_title AS content_title, user_name, img_date AS date FROM image_table WHERE accept_reject = 0
  ) AS combined_data ORDER BY date DESC LIMIT 7";
  $stmt8 = $db->query($sql8);
  $result8 = $stmt8->setFetchMode(PDO::FETCH_ASSOC);

?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Light Novel Archive | ADMIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <link rel="icon" href="logos/Tab-Logo.ico">
  <script type="text/javascript">
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

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

<!-- Site wrapper -->
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-light">
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
    <a  class="brand-link">
      <img src="logos/Tab-Logo.ico" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text" style="font-size: 18px; font-weight: 500;">Light Novel<sub style="font-size: 10px;font-weight: 400; "> Admin Panel</sub></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
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
          <li class="nav-item menu-open">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item ">
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Member List
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="createdmember.php" class="nav-link ">
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
                <a href="requestmember.php" class="nav-link">
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
        <li class="nav-item ">
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
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="row">
            <div class="col-lg-12">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $count; ?></h3>

                <p>Total Member</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="memberlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $Illustrator ?></h3>

                <p>Illustrator (Lv.1)</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="memberlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <a href="approvedillustration.php" style="text-decoration: none; color: #111111;">
            <div class="info-box col-sm-12 bg-warning">
              <div class="info-box-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg></div>

              <div class="info-box-content">
                <span class="info-box-text">Total Illustration</span>
                <span class="info-box-number"><?php echo $Illustration; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="col-lg-12">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $Reader ?></h3>

                <p>Reader (Lv.0)</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="memberlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $Author; ?></h3>

                <p>Author (Lv.2)</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="memberlist.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            <a href="approvedarticle.php" style="text-decoration: none; color: #ffffff;">
            <div class="info-box col-sm-12 bg-danger">
              <!-- <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span> -->
              <div class="info-box-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg></div>

              <div class="info-box-content">
                <span class="info-box-text">Total Article</span>
                <span class="info-box-number"><?php echo $Article; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div></a>
            </div>
          </div>
<?php 
  // Get the current date
  $date1 = date('Y-m-d');
  $sql11 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date1'";
  $result11 = $db->query($sql11);
  $count1 = $result11->fetchColumn();
  $date1t = date('d', strtotime($date1));

  $date2 = date("Y-m-d", strtotime("-1 day"));
  $sql12 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date2'";
  $result12 = $db->query($sql12);
  $count2 = $result12->fetchColumn();
  $date2t = date('d', strtotime($date2));

  $date3 = date("Y-m-d", strtotime("-2 day"));
  $sql13 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date3'";
  $result13 = $db->query($sql13);
  $count3 = $result13->fetchColumn();
  $date3t = date('d', strtotime($date3));

  $date4 = date("Y-m-d", strtotime("-3 day"));
  $sql14 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date4'";
  $result14 = $db->query($sql14);
  $count4 = $result14->fetchColumn();
  $date4t = date('d', strtotime($date4));

  $date5 = date("Y-m-d", strtotime("-4 day"));
  $sql15 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date5'";
  $result15 = $db->query($sql15);
  $count5 = $result15->fetchColumn();
  $date5t = date('d', strtotime($date5));

  $date6 = date("Y-m-d", strtotime("-5 day"));
  $sql16 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date6'";
  $result16 = $db->query($sql16);
  $count6 = $result16->fetchColumn();
  $date6t = date('d', strtotime($date6));

  $date7 = date("Y-m-d", strtotime("-6 day"));
  $sql17 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date7'";
  $result17 = $db->query($sql17);
  $count7 = $result17->fetchColumn();
  $date7t = date('d', strtotime($date7));

  // Last week
  $date8 = date("Y-m-d", strtotime("-7 day"));
  $sql18 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date8'";
  $result18 = $db->query($sql18);
  $count8 = $result18->fetchColumn();

  $date9 = date("Y-m-d", strtotime("-8 day"));
  $sql19 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date9'";
  $result19 = $db->query($sql19);
  $count9 = $result19->fetchColumn();

  $date10 = date("Y-m-d", strtotime("-9 day"));
  $sql20 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date10'";
  $result20 = $db->query($sql20);
  $count10 = $result20->fetchColumn();

  $date11 = date("Y-m-d", strtotime("-10 day"));
  $sql21 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date11'";
  $result21 = $db->query($sql21);
  $count11 = $result21->fetchColumn();

  $date12 = date("Y-m-d", strtotime("-11 day"));
  $sql22 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date12'";
  $result22 = $db->query($sql22);
  $count12 = $result22->fetchColumn();

  $date13 = date("Y-m-d", strtotime("-12 day"));
  $sql23 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date13'";
  $result23 = $db->query($sql23);
  $count13 = $result23->fetchColumn();

  $date14 = date("Y-m-d", strtotime("-13 day"));
  $sql24 = "SELECT COUNT(*) FROM visiting_count WHERE date='$date14'";
  $result24 = $db->query($sql24);
  $count14 = $result24->fetchColumn();

?>
          <!-- ./col -->
          <div class="col-lg-6">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Online Visitors</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <?php $vThis = $count1 + $count2 + $count3 + $count4 + $count5 + $count6 + $count7; ?>
                      <span class="text-bold text-lg"><?php echo $vThis; ?></span>
                      <span>Visitors This Week</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <?php $vPast = $count8 + $count9 + $count10 + $count11 + $count12 + $count13 + $count14;
                              if ($vPast == 0) { 
                                $Avg = 100; 
                              } else {
                                $Avg = 100-(($vThis*100)/$vPast);
                              } ?>
                        <i class="fas fa-arrow-up"></i> <?php echo $Avg; ?>%
                      </span>
                      <span class="text-muted">Since last week</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative mb-4">
                    <canvas id="visitors-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> This Week
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Last Week
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Latest Members</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                      <?php while ($row6 = $stmt6->fetch()) {

                            $registerId6 = $row6['register_id'];

                            $sql7 = "SELECT * FROM registration_table WHERE register_id=$registerId6";
                            $stmt7 = $db->query($sql7);
                            $result7 = $stmt7->setFetchMode(PDO::FETCH_ASSOC);
                            $row7 = $stmt7->fetch();

                            $pf7 = "../".$row7['profile_photo'];
                            $today = date("Y-m-d");
                            $yesterday = date("Y-m-d", strtotime("-1 day"));

                            // Defining date format to display
                            if ($today == $row7['joined_date']) {
                              $date = "Today";
                            } else if ($yesterday == $row7['joined_date']) {
                              $date = "Yesterday";
                            } else {
                              $date = date('d M', strtotime($row7['joined_date']));
                            }
                            
                        ?>
                      <li>
                        <img src="<?php echo $pf7; ?>" style="width: 60px; height: 60px; object-fit: cover;" alt="User Image">
                        <a class="users-list-name" href="#"><?php echo $row6['user_name']; ?></a>
                        <span class="users-list-date"><?php echo $date ?></span>
                      </li>
                      <?php } ?>
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="memberlist.php">View All Users</a>
                  </div>
                  <!-- /.card-footer -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-md-8">
            <div class="col-md-12">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Requests</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Type</th>
                      <th>Title</th>
                      <th>Creator</th>
                      <th>Uploaded Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if ($stmt8->rowCount() > 0) {
                          while ($row8 = $stmt8->fetch()) { 
                            $Date = date('d M Y', strtotime($row8['date']));
                            $contentType = $row8['content_type'];                      ?>
                    <tr>
                      <?php if ($contentType == 'article') { ?>
                      <td><span class="badge badge-danger" style="padding: 7px;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg> <?php echo 'Article'; ?></span></td>
                      <td><a href="requestarticle.php"><?php echo $row8['content_title']; ?></a></td>
                      <?php } else { ?>
                      <td><span class="badge badge-warning" style="padding: 7px;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> <?php echo 'Illustration'; ?></span></td>
                      <td><a href="requestillustration.php"><?php echo $row8['content_title']; ?></a></td>
                      <?php } ?>
                      <td><?php echo $row8['user_name']; ?></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20"><?php echo $Date; ?></div>
                      </td>
                    </tr>
                    <?php } } else { ?>
                      <tr><td colspan="4">
                      <p style="color: #ccc; font-weight: 700; font-size: 20px; text-align: center;">There's no requested works yet</p></td></tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="requestarticle.php" class="btn btn-sm btn-primary float-left" style="margin-right: 20px;">Article List</a>
                <a href="requestillustration.php" class="btn btn-sm btn-primary">Illustration List</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            </div>

                
                <!--/.card -->
              </div>
            </div>

        <div class="row">
          <!-- Left col -->
          
          <!-- /.col -->   
        </div>
         
        
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    
    <strong>Copyright &copy;<script>document.write(new Date().getFullYear());</script> </strong>
    All rights reserved.
   <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://goldentkm.com/lightnovelarchive" target="_blank">Light Novel Archive</a>
  </footer>
</div>
<!-- ./wrapper -->
</div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
  <!-- pace-progress -->
<script src="plugins/pace-progress/pace.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
<!-- Necessary JavaScript -->
<script type="text/javascript">
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels: ['<?php echo $date7t."th"; ?>', '<?php echo $date6t."th"; ?>', '<?php echo $date5t."th"; ?>', '<?php echo $date4t."th"; ?>', '<?php echo $date3t."th"; ?>', '<?php echo $date2t."th"; ?>', '<?php echo $date1t."th"; ?>'],
      datasets: [{
        type: 'line',
        data: [<?php echo $count7+100; ?>, <?php echo $count6+120; ?>, <?php echo $count5+170; ?>, <?php echo $count4+167; ?>, <?php echo $count3+180; ?>, <?php echo $count2+177; ?>, <?php echo $count1+160; ?>],
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      },
      {
        type: 'line',
        data: [<?php echo $count14+60; ?>, <?php echo $count13+80; ?>, <?php echo $count12+70; ?>, <?php echo $count11+67; ?>, <?php echo $count10+80; ?>, <?php echo $count9+77; ?>, <?php echo $count8+100; ?>],
        backgroundColor: 'tansparent',
        borderColor: '#ced4da',
        pointBorderColor: '#ced4da',
        pointBackgroundColor: '#ced4da',
        fill: false
        // pointHoverBackgroundColor: '#ced4da',
        // pointHoverBorderColor    : '#ced4da'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
})
</script>
</html>
<?php
    session_start();
    require("database.php");
    $loginid = "";

    if(!empty($_SESSION['logindata'])) {
        $loginid = $_SESSION['logindata'];
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
    
        $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
        $stmt = $db->query($sql);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row=$stmt->fetch();

        

        if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['imgpath']))) {
  		$filename=$_GET['imgpath'];
        $folder = "../upload/" . $filename;
  }

  $sql1 = "SELECT * FROM image_table WHERE image_path='$filename'";
        $stmt1 = $db->query($sql1);
       $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
       $row1=$stmt1->fetch();

       $IllustratorName = $row1['user_name'];
       $title = $row1['img_title'];  
       $descrip = $row1['img_descrip'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Light Novel | ADMIN </title>

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
  </script>
</head>
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Oswald:300,400,700);
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic);
  .img{
/*    margin-top: 15px;*/
  }
  .img{
    box-shadow: 5px 5px 20px darkgray;
    border-radius: 10px;
    max-width: 75%;
      height: auto;
  }
  h1 {
    font-family:'Oswald', sans-serif; 
    font-size:24px; 
    font-weight:400; 
    text-transform: uppercase; 
    color:black; 
    padding:5px;
    margin:0;
    text-align: center;
    letter-spacing: 1.5px;
    text-shadow: 1px 1px 2px darkgray;
  }
  h2{
    font-family:'Oswald', sans-serif; 
    font-size:18px; 
    line-height:0; 
    font-weight:400; 
    letter-spacing:4px; 
    text-transform: uppercase; 
    color:black;
    margin-bottom: 30px;
    text-align: center;
    margin-top: 20px;
  }
  .name{
    border: ;
/*    background: #e53637;*/
    color: #ffffff;
    width: 500px;
    border-radius: 20px;
    
  }
  .imgname{
    font-family:'Oswald', sans-serif; 
    font-size:28px; 
    font-weight:400; 
    text-transform: uppercase; 
    color:black; 
    padding:2px;
    text-align: center;
    letter-spacing: 1.5px;
    text-shadow: 1px 1px 2px darkgray;
    margin-top: 20px;
  }
  .container{
/*    box-shadow: 2px 2px 10px darkgray;*/
    width: 100%;
/*    padding-bottom: 30px;*/
/*    padding-top: 15px;*/
    border-radius: 45px;
  }
  .descrip{
    font-family:'Oswald', sans-serif; 
    font-size:28px; 
    font-weight:400; 
    text-transform: uppercase; 
    color:black; 
    padding:5px;
    margin:0;
    text-align: center;
    letter-spacing: 1.5px;
    text-shadow: 1px 1px 2px darkgray;
    margin-top: 40px;
  }
  .description{
    font-family:'Oswald', sans-serif; 
    font-size:18px; 
    line-height:0; 
    font-weight:400; 
    letter-spacing:2px; 
    text-transform: uppercase; 
    color:black;
    margin-bottom: 20px;
    text-align: center;
    margin-top: 20px;
  }
  .title{
    width: 600px;
  }
  .desc{
    width: 600px;
    height: 50px;
  }
  .profile__details__btn .follow-btn:hover {
  font-size: 13px;
  color: #111111;
  display: inline-block;
  background: #111111;
  text-transform: uppercase;
/*  padding: 10px 10px;*/
  border-radius: 4px;
  border: solid white;
  width: 100px;
  border-radius: 20px;
}
.profile__details__btn .follow-btn {
  margin-left: 500px;
  font-size: 13px;
  color: #111111;
  display: inline-block;
  background: #ffffff;
  text-transform: uppercase;
/*  padding: 10px 10px;*/
  border-radius: 4px;
  border: solid white;
  width: 100px;
  border-radius: 20px;
  border: solid black;
  margin-bottom: 25px;
}
.goback{
  font-family:'Oswald', sans-serif; 
    font-size:20px; 
    font-weight:400; 
    text-transform: uppercase; 
    color:#111111;
    margin:0;
    text-align: center;
    letter-spacing: 1.5px;  
}
.goback:hover{
  font-family:'Oswald', sans-serif; 
    font-size:20px; 
    font-weight:400; 
    text-transform: uppercase; 
    color:#ffffff;
    margin:0;
    text-align: center;
    letter-spacing: 1.5px;  
}
.profile__details__btn a{
  text-decoration: none;
}
</style>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed ">
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
          <a href="#" class="d-block"><?php echo $loginid; ?></a>
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
                <a href="approvedillustration.php" class="nav-link ">
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

<div id="parallax-world-of-ugg">
    <center>
    <div class="container">
    <div class="name">
        <h1><?php echo $IllustratorName; ?>'s Illustration</h1>
    </div>
    <div>
  <img class="img" src="<?php echo $folder; ?>">
  </div>
<div class="nameandimage">
  <h1 class="imgname">Title</h1>
  <div class="title">
    <h2><?php echo $title; ?></h2>
  </div>
  <h1 class="descrip">Description</h1>
  <div class="desc">
    <h2 class="description"><?php echo $descrip; ?></h2>
  </div>
</div>
<div class="profile__details__btn">
  <a href="requestillustration.php" class="follow-btn"><h1 class="goback">Go Back</h1></a>
</div>

</div>
</center>
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
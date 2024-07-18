<?php
  session_start();
  require("database.php");
  $loginid = ""; $last_id = "";
  $loginid = $_SESSION['logindata'];

  $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
  $stmt = $db->query($sql);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row=$stmt->fetch();
  $username=$row['user_name'];
  $email=$row['user_email'];

  $msg = "";
  $success = ""; $success1 = "";
  $folderName = "upload";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

    if(file_exists($folderName)){
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $title = $_POST['title'];
    $publishdate = date("Y-m-d");
    $description = $_POST['description'];
    $folder = "./upload/" . $filename;

    // Get all the submitted data from the form
    $sql1 = "INSERT INTO image_table (image_path,user_name,user_email,img_title, img_descrip, img_date) VALUES ('$filename','$username','$email','$title', '$description', '$publishdate')";

    // Execute query
    $db->exec($sql1);
    $last_id = $db->lastInsertId();

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        $success = "Image uploaded successfully";
    } else {
        $success = "Failed to upload image!";
    }
}
else if(mkdir($folderName)){
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $folder = "./upload/" . $filename;

    // Get all the submitted data from the form
    $sql1 = "INSERT INTO image_table (image_path,user_name,user_email,img_title, img_descrip) VALUES ('$filename','$username','$email','$title', '$description')";

    // Execute query
    $db->exec($sql1);
    $last_id = $db->lastInsertId();
    

    // Now let's move the uploaded image into the folder: image
    if (move_uploaded_file($tempname, $folder)) {
        $success = "Image published successfully!";
        $success1 = "Now waiting for Admins to accept it.";
    } else {
        $success = "Failed to upload image!";
    }
}

}


?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Light Novel Archive</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="showarticle.css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="icon" href="Tab-Logo.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href=".Admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href=".Admin/dist/css/adminlte.min.css">
</head>
<style type="text/css">
    .footer{
        margin-top: 5%;
    }
    .col-sm-6 h1 {
        margin-bottom: 20px;
        margin-left: 220px;
        margin-right: 220px;
        font-weight: 700;       
        color: #111111;

    }
    .col-sm-6 {
        margin-left: 300px;
    }
    .custom-file{
        border: solid;
    }
    .form-check-input {
        width: 15px;
        height: 15px;
        margin-left: 450px;
    }
    .form-check-label{
        margin-left: 500px;
        padding-bottom: 20px;
        font-size: 20px;
        font-weight: 500;
        margin-top: 11px;
    }
    .col h1 {
        margin-bottom: 30px;
        margin-top: 20px;
        font-weight: 700;
        color: #111111;
    }
    .col {
        margin-bottom: 20px;
        padding-top: 20px;
    }
    .supercontainer{
        border: ;
        margin-left: 8%;
        width: 80%;
        padding-top: 20px;
    }
    .form-control{
        padding-left: 3%;
        width: 100%;
        padding-top: 1%;
        padding-bottom: 6%;
        border: solid;

    }
    .breadcrumb-option{
        margin-bottom: 25px;
    }
    #parallax-world-of-ugg label {
        font-family:'Oswald', sans-serif; 
        font-size:14px; 
        line-height:0; 
        font-weight:400; 
        letter-spacing: 1px; 
        text-transform: uppercase; 
        color:black;
    }
    /* Style the custom button */
/*    .custom-file-upload {
        border: solid;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        width: 250px;
        border-radius: 50px;
        background: #111111;

     }
     .custom-file-upload h4{
        font-family:'Oswald', sans-serif; 
        font-size:24px; 
        font-weight:400; 
        text-transform: uppercase; 
        color:#ffffff; 
        padding:0; 
        margin:0;
    }*/
/*    .custom-file-upload:hover {
        border: solid;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        width: 250px;
        border-radius: 50px;
        background: #ffffff;

     }
     .custom-file-upload h4:hover {
        font-family:'Oswald', sans-serif; 
        font-size:24px; 
        font-weight:400; 
        text-transform: uppercase; 
        color:#111111; 
        padding:0; 
        margin:0;
    }*/
    .btn {
    	color: #ffffff;
    	background: #111111;
    	margin-left: 410px;
    }
    .button{
    	margin-left: -20px;
    }
    .image{
        border: thin #ccc;
        box-shadow: 2px 2px 10px #111111;
    }
    .choosefile{
    	border: solid;
    }
    /* Hide the default button */
    input[type="file"] {
    	display: none;
    }
    /* Style the custom button */
    .custom-file-upload {
    	color: #ffffff;
    	background: ;
    	font-size: 20px;
    	font-weight: 400;
    	border-radius: 10px;
        border: 1px solid #ccc;
        display: inline-block;
        padding: 20px 20px;
        cursor: pointer;
    }
    .custom-file-upload:hover{
        color: #111111;
    	background: lightgray;
    }
    .visible{
    	margin-top: 5px;
    }

</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="img/MainLogo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="header__nav">
                         <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active"><a href="./index.php">Homepage</a></li>
                                <li><a href="#">Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="./categories.php"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-archive"><polyline points="21 8 21 21 3 21 3 8"></polyline><rect x="1" y="3" width="22" height="5"></rect><line x1="10" y1="12" x2="14" y2="12"></line></svg>&nbsp;Novels List</a>
                                            <ul style="margin-left: 15px;">
                                                <li><a href="./allcreatedworks.php?#target"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> All Created Novels</a></li>
                                                <li><a href="./newlyaddedworks.php?#target"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Newly Added Novels</a></li>
                                                <li><a href="./lastupdated.php?#target"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Last Updated Novels</a></li>
                                                <li><a href="./mostbookmarked.php?#target"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-right"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg> Most Bookmarked Novels</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="./blog.php"><img src="img/illustrate.png" alt="" width="16" height="16"> All illustrations</a></li>
                                        <li><a href="#"><img src="img/contact.png" alt="" width="16" height="16"> Contacts</a></li>
                                    </ul>
                                </li>
                                <li><a href="./novellist.php">Novels List</a></li>
                                <li><a href="./blog.php">illustrations</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./profile.php">Profile</a>
                        <span>Upload Artwork</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <div class="supercontainer">
    <div class="container">
        <center>
            <div id="parallax-world-of-ugg">
            <section>
                <div class="title" style="margin-left: 6%;">
                    <h3>Empower through</h3>
                    <h1>Appreciation</h1><br>
                 <?php echo "<h3>$success</h3>"?>
                 <?php echo "<h3>$success1</h3>"?>
                </div>
            </section>
        <div class="row">
        <div class="col-sm-6">
        <div id="content">
        	<div class="form-group">
        	<label for="imageInput" class="custom-file-upload">
                Add Image
            </label>
        	<input type="file" name="uploadfile" id="imageInput" accept="image/*" name="choosefile">
        	<img id="imagePreview" class="image" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 400px; border-radius: 8px;">
            </div>
    </div>
    </div>
    </div>
        
        <div class="Title">
        <div class="row">
          <div class="col-sm-6">
          <!-- textarea -->
          <div class="form-group">
            <h1>Title</h1>
            <input class="form-control" style="padding-top: 28px;" type="textarea" value="" name="title" placeholder="Enter ...">
          </div>
          </div>
        </div>
        </div>
        <div class="Tag">
        <div class="row">
          <div class="col-sm-6">
          <!-- textarea -->
          <div class="form-group">
            <h1>Description</h1>
            <textarea name="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
          </div>
          </div>
        </div>
        </div>
        <!-- <div class="row">
        <div class="col">
        <div class="form-check">
            <h1>Visible to</h1>
            <div class="visible">
            <div class="row">
            <input class="form-check-input" type="radio" id="radioCheck" name="customRadio" value="All">
            <label class="form-check-label" for="radioCheck">All</label>
            </div>
            <div class="row">
            <input class="form-check-input" type="radio" name="customRadio" id="radioCheck1" value="Author & Illustrator">
            <label class="form-check-label" for="radioCheck1">Author & Illustrator</label>
            </div>
            <div class="row">
            <input class="form-check-input" type="radio" name="customRadio" id="radioCheck2" value="Only Author">
            <label class="form-check-label" for="radioCheck2">Only Author</label>
            </div>
            </div>
        </div>
        </div>
        </div> -->
        </div>
        </center>
        </div>
    	</div>
    <section>
    <div class="block">
    <div id="externalContent"></div>
    <p class="line-break margin-top-20"></p>
    <div class="article-title article__details__btn">
        <center>
        <button class="go-back" type="submit" name="upload">Publish</button></center>
    </div>
    </div>
    </section> 
    </form>
    <footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer__logo">
                    <a href="./index.php"><img src="img/MainLogo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                       <li class="active"><a href="./index.php">Homepage</a></li>
                        <li><a href="./categories.php">Categories</a></li>
                        
                         <li><a href="./categories.php">Novels List</a></li>
                         <li><a href="./blog.php">illustrations</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                 Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://goldentkm.com/lightnovelarchive" target="_blank">Light Novel Archive</a>

              </div>
          </div>
      </div>
  </footer>
  <!-- Footer Section End -->

  <!-- Search model Begin -->
  <div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search model end -->

<!-- Js Plugins -->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/player.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>

<!-- jQuery -->
<script src="Admin./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="Admin./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="Admin./plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="Admin./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Admin./dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function(event) {
            const selectedFile = event.target.files[0];
            
            if (selectedFile) {
                imagePreview.style.display = 'block';
                imagePreview.src = URL.createObjectURL(selectedFile);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.src = '#';
            }
        });
    </script>

</body>

</html>
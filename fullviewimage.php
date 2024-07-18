<?php
    session_start();
    require("database.php");
    $loginid = ""; $descrip = "";
    $IllustratorName = ""; $title = "";

    if(!empty($_SESSION['logindata'])) {
        $loginid = $_SESSION['logindata'];
    }
    
        $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
        $stmt = $db->query($sql);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row=$stmt->fetch();

        if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['imgpath']))) {
  		$filename=$_GET['imgpath'];
        $folder = "./upload/" . $filename;
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
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="showarticle.css">
    <link rel="icon" href="Tab-Logo.ico">
</head>
<style type="text/css">
.creatorname {
    margin-left: 200px;
    margin-right: 200px;
    background-color: #ffffff;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
    padding-top: 20px;
}
.act__details__pic {
    height: 40px;
    width: 40px;
    margin-left: 60px;
    margin-top: 18px;
    border: thin;
    border-color: #111111;
    border-radius: 50%;
    position: relative;
    box-shadow: 2px 2px 5px gray;
}
.art__details__title {
    margin-bottom: 20px;
}

.art__details__title h3 {
    color: #111111;
    font-weight: 700;
    margin-bottom: 25px;
    margin-left: 20px;
    margin-top: 20px;
}

.art__details__title span {
    font-size: 18px;
    font-weight: 600;
    color: #111111;
    display: block;
    margin-left: 30px;
}
.feathericon{
    width: 35px;
    margin-left: 70px;
    margin-top: 25px;
}
.art__details__content {
    padding-bottom:25px ;
    border-radius: 20px;
}
.art__details__text {
    position: relative;
}

.art__details__text p {
    color: #111111;
    font-size: 18px;
    line-height: 30px;
    margin-left: 80px;
}
.haha-option {
  padding-top: 15px;
}
</style>
<body style="overflow-x: hidden;">
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
                <div class="col-lg-2 col-md-2">
                
                <div class="header__right">
                
                <?php if($loginid != "") { ?>
                        <a href="./profile.php"><span class="icon_profile"></span> <?php echo $loginid; ?></a>
                <?php } else { ?>
                        <a href="./login.php"><span class="icon_profile"></span> Login</a>
                    <?php } ?>

                </div>
                
            </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->
    
    <div class="haha-option" style="padding-bottom: 15px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./blog.php">Illustration</a>
                        <span><?php echo $title; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hero Section Begin -->
    <section style="background-color: #f4f6f5; padding-bottom: 70px;">
    <div class="creatorname">
            <center>
                <a href="#">
                <div style="background-size: contain;" class="hero__items set-bg" data-setbg="<?php echo $folder ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="hero__text">
                                <div class="label">Adventure</div>
                                <div class="label">Action</div>
                                <h2>The Beginning After The End</h2>
                                <p>King Grey has unrivaled strength, wealth and prestige in a world governed by martial ability. However...</p>
                            </div>
                        </div>
                    </div>
                </div></a>
            </center>
    
    <!-- Hero Section End -->
    
            <div class="art__details__content">
                <div class="row">
                    <div class="col-lg-1">
                         <div class="feathericon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg>
                                </div>
                        <div class="act__details__pic set-bg" data-setbg="img/JPEG_20180823_080553.jpg">
                        </div>
                    </div>
                    <div class="col-lg-11">
                        <div class="art__details__text">
                            <div class="art__details__title">
                               
                                <h3><?php echo $title; ?></h3>
                                <span><?php echo $IllustratorName; ?></span>
                            </div>
                            <div>
                            <p><?php echo $descrip; ?></p>
                        </div>
                    </div>
                   </div> 
               </div>
            </div>
            <div class="article-title article__details__btn">
        <div class="row">
            <div class="col">
        <a href="blog.php"><button type="submit" name="publish" class="save-btn2" style="width: 130px; margin-bottom: 50px; margin-left: 43%;">Go Back</button></a>
            </div>
        </div>
        </div>
        </div>
        </section>

    <!-- Footer Section Begin -->
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


</body>

</html>
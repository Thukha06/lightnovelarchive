<?php
    session_start();
    require("database.php");
    $loginid = "";

    if(!empty($_SESSION['logindata'])) {
        $loginid = $_SESSION['logindata'];

        // Get the current date
        $date = date('Y-m-d');

        $sql4 = "SELECT * FROM visiting_count WHERE date='$date' and user_name='$loginid'";
        $stmt4 = $db->query($sql4);

        if ($stmt4->rowCount() == 0) {
            $sql5 = "INSERT INTO visiting_count (date, user_name) VALUES ('$date', '$loginid')";
            $db->exec($sql5);
        }
    }

    $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
    $stmt = $db->query($sql);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row=$stmt->fetch();

    // For main banner
    $sql1 = "SELECT * FROM article_table ORDER BY article_id DESC LIMIT 9";
    $stmt1 = $db->query($sql1);
    $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);

    // For newly added works
    $sql3 = "SELECT * FROM article_table ORDER BY article_id DESC LIMIT 9";
    $stmt3 = $db->query($sql3);
    $result3 = $stmt3->setFetchMode(PDO::FETCH_ASSOC);

    // For last updated
    $sql2 = "SELECT * FROM article_table ORDER BY updated_date DESC LIMIT 6";
    $stmt2 = $db->query($sql2);
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
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
    <link rel="icon" href="Tab-Logo.ico">
    <style type="text/css">
    .ch_list {
        padding: 30px;
        border: solid #ccc;
        background: #f4f6f5;
        border-radius: 5px;
    }
    .product__item {
        padding: 2px;
        border-radius: 5px;
        box-shadow: 1px 1px 5px #ccc;
    }
    .cal__text p {
        color: #ffffff;
        position: absolute;
        left: 0;
        bottom: -6%;
        width: 100%;
        text-align: center;
        text-shadow: 1px 1px 5px #111111;
    }
    .cal__text p span {
        color: #ffffff;
        margin-right: 5px;
    }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="header__logo">
                        <a href="./index.php">
                            <img src="img/MainLogo.png" alt="" >
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
                                        <li><a href="./contactUs.php"><img src="img/contact.png" alt="" width="16" height="16"> Contacts</a></li>
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

    <div class="wrap-page">
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="hero__slider owl-carousel">
                <?php while ($row1 = $stmt1->fetch()) { 

                    if (($row1['publish_unpublish']) == 1) {

                        $prevPg1 = 1;
                        $coverPhoto1 = $row1['article_coverphoto'];
                        $articleId1 = $row1['article_id'];
                        $articleTitle1 = $row1['article_title'];
                        $articleDescrip1 = $row1['article_description'];

                        // Check if the text is longer than 102 characters
                        if (strlen($articleDescrip1) > 102) {
                            $articleDescrip1 = substr($articleDescrip1, 0, 102) . '...'; 
                            // Truncate the text to 102 characters and add ellipsis
                        } ?>

                <div class="hero__items set-bg" data-setbg="<?php echo $coverPhoto1; ?>">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 col-sm-8">
                            <div class="hero__text">
                                <h2><?php echo $articleTitle1; ?></h2>
                                <p><?php echo $articleDescrip1; ?></p>
                            <?php echo "<a href='anime-details.php?articleId=$articleId1&prevPg=$prevPg1#target1'><span>Read Now</span> <i class='fa fa-angle-right'></i></a>" ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
    </div>
    <div class="wrap-page">
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <div class="section-title">
                            <h5>Newly Added Novels</h5>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="btn__all">
                            <a href="newlyaddedworks.php?#target" class="primary-btn">View All <span class="arrow_right"></span></a>
                        </div>
                    </div>
                </div>
                    <div class="ch_list">
                        <div class="anime__details__articles">
                        <div class="row">
                            <?php while ($row3 = $stmt3->fetch()) { 

                                if (($row3['publish_unpublish']) == 1) {
                                $prevPg3 = 1;
                                $articleId3 = $row3['article_id'];
                                $articleTitle3 = $row3['article_title']; ?>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="<?php echo $row3['article_photo']; ?>"></div>
                                    <div class="product__item__text" style="padding-top: 0px; text-align: center; height: 80px;">
                                    <?php echo "<h5><a href='anime-details.php?articleId=$articleId3&prevPg=$prevPg3#target1'>$articleTitle3</a></h5>" ?>
                                    </div>
                                </div>
                            </div>
                        <?php } } ?>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                            <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="section-title">
                            <h5>Last Updated</h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="btn__all">
                            <a href="lastupdated.php?#target" class="primary-btn">View All <span class="arrow_right"></span></a>
                        </div>
                    </div>
                            </div>
                            <!-- 
                            <ul class="filter__controls">
                                <li class="active" data-filter=".day">Day</li>
                                <li data-filter=".month">Month</li>
                                <li data-filter=".year">Years</li>
                            </ul> -->
                            <?php while ($row2 = $stmt2->fetch()) {

                                if (($row2['publish_unpublish'])==1) {
                                    $prevPg2 = 3;
                                    $coverPhoto2 = $row2['article_coverphoto'];
                                    $articleId2 = $row2['article_id'];
                                    $title2 = $row2['article_title'];
                                    $date2 = date('d M Y', strtotime($row2['updated_date'])); ?>

                            <?php echo "<div class='filter__gallery item'>
                                <div class='product__sidebar__view__item cal__text set-bg mix day month year' data-setbg='$coverPhoto2'>
                                <h5 style='text-align: center; bottom: 15%;'><a href='anime-details.php?articleId=$articleId2&prevPg=$prevPg2#target1'>$title2</a></h5>
                                    <p><span class='icon_calendar'></span> $date2</p>
                                </div>";
                             } } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
</div>
<!-- Footer Section Begin -->
<footer class="footer">
    <div class="page-up">
        <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="footer__logo">
                    <a href="./index.php"><img src="img/MainLogo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer__nav">
                    <ul>
                        <li class="active"><a href="./index.php">Homepage</a></li>
                        <li><a href="./categories.php">Categories</a></li>
                        <li><a href="./novellist.php">Novels List</a></li></li>
                        <li><a href="./blog.php">illustration</a></li>
                        
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://goldentkm.com/lightnovelarchive" target="_blank">Light Novel Archive</a>
                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

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
</body>

</html>
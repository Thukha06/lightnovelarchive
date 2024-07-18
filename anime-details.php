<?php
    session_start();
    require("database.php");
    $loginid = ""; 
    $username = ""; $email = "";

    if(!empty($_SESSION['logindata'])) {
        $loginid = $_SESSION['logindata'];

        $sql2 = "SELECT * FROM login_table WHERE user_name='$loginid'";
        $stmt2 = $db->query($sql2);
        $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
        $row2=$stmt2->fetch();
        $username = $row2['user_name'];
        $email = $row2['user_email'];
    } 

    if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['articleId']))) {
        $articleId = $_GET['articleId'];
        $prevPg = $_GET['prevPg'];

        $sql = "SELECT * FROM article_table WHERE article_id='$articleId'";
        $stmt = $db->query($sql);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        $author = $row['user_name'];
    } else {

        // Redirect to the main page if GET method return Null
        header('Location: index.php');
        exit;
    }

    $sql1 = "SELECT * FROM chapter_table WHERE article_id='$articleId'";
    $stmt1 = $db->query($sql1);
    $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);

    // Chapter row count
    $sql4 = "SELECT COUNT(*) FROM chapter_table WHERE article_id='$articleId'";
    $stmt4 = $db->query($sql4);
    $result4 = $stmt4->setFetchMode(PDO::FETCH_ASSOC);
    $rowCount = $stmt4->fetchColumn();

    // Bookmark row count
    $sql5 = "SELECT COUNT(*) FROM bookmark_table WHERE article_id='$articleId'";
    $stmt5 = $db->query($sql5);
    $result5 = $stmt5->setFetchMode(PDO::FETCH_ASSOC);
    $rowCount1 = $stmt5->fetchColumn();

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
    <link rel="stylesheet" href="Admin/plugins/fontawesome-free/css/all.min.css">

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
    <style type="text/css">
        .anime-details {
            padding-top: 0px;
            background: #f4f6f5;
        }
        .bruh-option .set-bg {
            padding-top: 200px; 
            padding-bottom: 200px; 
            overflow: hidden; 
            position: relative; 
            width: 100%; 
            background-image: url(https://images.unsplash.com/photo-1415018255745-0ec3f7aee47b?dpr=1&auto=format&fit=crop&w=1500&h=938&q=80&cs=tinysrgb&crop=); 
            background-attachment: fixed; 
            background-size: contain; -moz-background-size: cover; -webkit-background-size: cover; 
            background-repeat: no-repeat; 
            background-position: top center;
        }
        .anime__details__btn .watch-btn span {
            font-size: 14px;
            color: #ffffff;
            background: #e53637;
            display: inline-block;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 14px 20px 14px;
            border-radius: 4px 0 0 4px;
            margin-right: 1px;
        }
    <?php if (!empty($row['article_coverphoto'])) { ?>
        .anime__details__pic {
            height: 440px;
            border: ;
            border-color: #111111;
            border-radius: 5px;
            position: relative;
            box-shadow: 1px 1px 5px gray;
            bottom: 200px;
        }
    <?php } else { ?>
        .anime__details__pic {
            height: 440px;
            border: ;
            border-color: #111111;
            border-radius: 5px;
            position: relative;
            box-shadow: 1px 1px 5px gray;
            bottom: 50px;
        }
    <?php } ?>


        .subcontainer {
            padding: 70px;
            background: #ffffff;
            border-bottom-right-radius: 8px;
            border-bottom-left-radius: 8px;
            box-shadow: 1px 1px 5px #ccc;
    <?php if (empty($row['article_coverphoto'])) { ?>
            -webkit-clip-path: inset(0px -5px -5px -5px);
            clip-path: inset(0px -5px -5px -5px);
    <?php } ?>
        }

        .ch_list {
            padding: 20px;
            border: solid #ccc;
            background: #f4f6f5;
            border-radius: 5px;
        }

        /*.ch_list a {
            background: #ffffff;
        }*/
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
                                <li><a href="./index.php">Homepage</a></li>
                                <li class="active"><a href="#">Categories <span class="arrow_carrot-down"></span></a>
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

    <!-- Breadcrumb Begin -->
    <div class="bruh-option">
        <div class="container">
        <div class="row">
            <div class="cover__links">
                <a href="./index.php"><i class="fa fa-home"></i> Home</a>
            <?php if ($prevPg == 0) { ?>
                <a href="./profile.php"> Profile</a>
            <?php } else if ($prevPg == 1) { ?>
                <a href="./categories.php"> Novels List</a>
                <a href="./newlyaddedworks.php"> Newly Added Novels</a>
            <?php } else if ($prevPg == 2) { ?>
                <a href="./categories.php"> Article List</a>
                <a href="./allcreatedworks.php"> All Created Novels</a>
            <?php } else if ($prevPg == 3) { ?>
                <a href="./categories.php"> Novels List</a>
                <a href="./lastupdated.php"> Last Updated</a>
            <?php } else if ($prevPg == 4) { ?>
                <a href="./categories.php"> Novels List</a>
                <a href="./mostbookmarked.php"> Most Bookmarked</a>
            <?php } ?>
                <span><?php echo $row['article_title']; ?></span>
            </div>
        </div>
        </div>
    <?php if (!empty($row['article_coverphoto'])) { ?>
    <section class="cover-breadcrumb set-bg" data-setbg="<?php echo $row['article_coverphoto']; ?>">
    </section>
    <?php } ?>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad" id="target">
        <div class="container subcontainer">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" id="target1" data-setbg="<?php echo $row['article_photo']; ?>">
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?php echo $row['article_title']; ?></h3>
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path><line x1="16" y1="8" x2="2" y2="22"></line><line x1="17.5" y1="15" x2="9" y2="15"></line></svg> <?php echo $author; ?></span>
                            </div>
                            <p><?php echo $row['article_description'] ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li><span>Total Chapters:</span> <?php echo $rowCount; ?></li>
                                            <li><span>Total Bookmarked:</span> <?php echo $rowCount1; ?></li>
                                            <li><span>Date published:</span> <?php 
                                                $publishedDate = date('d M Y', strtotime($row['published_date']));
                                                echo $publishedDate; ?></li>
                                            <li><span>Last updated:</span> <?php 
                                                $updatedDate = date('d M Y', strtotime($row['updated_date']));
                                                echo $updatedDate; ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <?php if ($loginid!=$author) {

                                $sql3 = "SELECT * FROM bookmark_table WHERE article_id='$articleId' AND user_name='$username'";
                                $stmt3 = $db->query($sql3);
                                $result3 = $stmt3->setFetchMode(PDO::FETCH_ASSOC);
                                $row3=$stmt3->fetch();

                                        if (empty($row3)) { ?>
                                <?php echo "<a href='bookmark.php?articleId=$articleId&prevPg=$prevPg' name='bookmark' class='follow-btn'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-bookmark'><path d='M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z'></path></svg> Bookmark</a>" ?>
                                <?php } else { ?>
                                <?php echo "<a href='unbookmark.php?articleId=$articleId&prevPg=$prevPg' name='unbookmark' class='follow-btn' style='color: #111111; background-color: #ffffff; border: 1px solid black;'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-bookmark'><path d='M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z'></path></svg> Bookmarked</a>" ?>
                                <?php } } ?>

                                <?php if ($loginid==$author) { ?>
                                <?php echo "<a href='createchapter.php?articleId1=$articleId' class='watch-btn'><span><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'><path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'></path><path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'></path></svg> Add New</span> <i
                                                class='fa fa-angle-right' style='padding-top: 13px; padding-bottom: 19px;'></i></a>" ?>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ch_list">
                        <div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>Chapter List</h5>
                        </div>
                        <div class="row">
                        <?php while ($row1 = $stmt1->fetch()) {
                            $chapId = $row1['ch_id'];
                            $chapTitle = $row1['ch_title'];  ?>
                        <?php echo "<a href='readchapter.php?chapId=$chapId'>$chapTitle</a>" ?>
                    <?php } ?>
                </div>
                </div>
            </div>
        </div>
        </section>
        <!-- Anime Section End -->

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
                                <li><a href="./index.php">Homepage</a></li>
                        <li class="active"><a href="./categories.php">Categories</a></li>
                         <li><a href="./novellist.php">Novels List</a></li>
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

    </body>

    </html>
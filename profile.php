<?php
    session_start();
    require("database.php");
    $loginid = ""; $role_exist = "";
    $prevPg = 0;

    if(!empty($_SESSION['logindata'])) {
        $loginid = $_SESSION['logindata'];
    } else {

        // Redirect to the main page if GET method return Null
        header('Location: index.php');
        exit;
    }

    $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
    $stmt = $db->query($sql);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row=$stmt->fetch();
    $username = $row['user_name'];
    $email = $row['user_email'];
    $usertype = $row['user_type'];
    $registerId = $row['register_id'];

    $sql1 = "SELECT * FROM article_table WHERE user_name='$username' and user_email='$email'";
    $stmt1 = $db->query($sql1);
    $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);

    $sql2 = "SELECT * FROM registration_table WHERE register_id='$registerId'";
    $stmt2 = $db->query($sql2);
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $row2 = $stmt2->fetch();

    if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['requestedrole']))) {
        $requestedrole = $_GET['requestedrole'];

        $sql3 = "INSERT INTO role_request (r_user_name, r_user_email, r_current_role, r_requested_role) VALUES ('$username', '$email', '$usertype', '$requestedrole')";
        $db->exec($sql3);

        // Redirect to the same page without the GET parameter
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;

    }

    $sql4 = "SELECT * FROM role_request WHERE r_user_name='$username'";
    $stmt4 = $db->query($sql4);
    $result4 = $stmt4->setFetchMode(PDO::FETCH_ASSOC);
    $row4 = $stmt4->fetch();

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
    <link rel="icon" href="Tab-Logo.ico">
    <style type="text/css">
    .blah-option {
        padding-top: 0px;
        padding-bottom: 65px;
        background: #f4f6f5;
    }
    .subcontainer {
        padding: 70px;
        padding-top: 0px;
        background: #ffffff;
        border-bottom-right-radius: 8px;
        border-bottom-left-radius: 8px;
        box-shadow: 1px 1px 5px #ccc;
    }
    .ch_list {
        margin-top: 50px;
        padding: 20px;
        border: solid #ccc;
        background: #f4f6f5;
        border-radius: 5px;
    }
    .product__item {
        padding: 2px;
        border-radius: 5px;
        box-shadow: 1px 1px 5px #ccc;
    }
    .image-container {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 22.5%; /* Adjust this value to control the aspect ratio */
        overflow: hidden;
    }
    .profile-pic {
        position: absolute;
        width: 100%;
        height: auto;
        top: -70%;
        left: 0;
    }

    .avatar-upload {
        bottom: 150px;
        left: ;
        position: relative;
        max-width: 250px;
        margin: 50px auto;
    }
    .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 4px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.5);
    }
    .avatar-preview #imagePreview {
        width: 100%;
        height: 100%;
        border-radius: 100%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    </style>
    <script type="text/javascript">
        function ConfirmUpdate(){
        var msg=confirm("Are you sure want to Logout?");
        if(msg)
        return true;
        else return false;
        }

        function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
    </script>
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
    <div class="bruh-option">
        <div class="container">
        <div class="row">
            <div class="cover__links">
                <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                <span>Profile</span>
            </div>
        </div>
        </div>
        </div>
    <section hidden class="cover-breadcrumb set-bg" data-setbg="">
    </section>
    <div class="image-container">
        <img class="profile-pic" src="<?php echo $row2['cover_photo']; ?>">
    </div>
    <!-- Breadcrumb End -->
    <div class="blah-option">
    <!-- Anime Section Begin -->
    <div class="container subcontainer">
    <section class="anime__details__profile">
            <div class="profile__details__content">
                <div class="row">
        <div class="col-lg-3">
            <div class="avatar-upload">
        <div class="avatar-preview">
            <div id="imagePreview" class="profile__details__pic set-bg" data-setbg="<?php echo $row2['profile_photo']; ?>">
            </div>
        </div>
    </div>
            </div>
                    <div class="col-lg-9">
                        <div class="profile__details__text">
                            <div class="profile__details__title">
                                <h3>
                                    <?php echo $loginid; ?>
                                    <sup style="font-size: 15px; color: #ccc;">
                            <?php if ($usertype==800) { ?>
                                Lv 0
                            <?php } else if ($usertype==702) { ?>
                                Lv 1
                            <?php } else if ($usertype==701) { ?>
                                Lv 2
                            <?php } else if ($usertype==600) { ?>
                                Admin
                                <?php } ?>
                            </sup>
                                </h3>
                                <span>Introduction</span>
                            </div>
                            <div class="profile__details__rating">
                            <div class="row">
                            <?php if ($usertype==800) { ?>
                                <div class="col">
                                <?php
                                    if(empty($row4['role_request_id'])) { ?>
                                <div class="profile__details__btn" style="width: 170px;">
                            <?php echo "<a href='profile.php?requestedrole=702' class='follow-btn' style='padding-left: 30px; padding-right: 30px;'>Request Lv1</a>" ?>
                                </div>
                                <?php } else { ?>
                                <div class="profile__details__btn" style="width: 170px;">
                                <div class='follow-btn' style='padding-left: 30px; padding-right: 30px; color: #111111; background-color: #ffffff; border: 1px solid #111111;'>Request Pending</div>
                                </div>
                                <?php } ?>
                                </div>
                            <?php } else if ($usertype==702) { ?>
                                <div class="col">
                                <?php if(empty($row4['role_request_id'])) { ?>
                                <div class="profile__details__btn" style="width: 170px;">
                            <?php echo "<a href='profile.php?requestedrole=701' class='follow-btn' style='padding-left: 30px; padding-right: 30px;'>Request Lv2</a>" ?>
                                </div>
                                <?php } else { ?>
                                <div class="profile__details__btn" style="width: 170px;">
                                <div class='follow-btn' style='padding-left: 30px; padding-right: 30px; color: #111111; background-color: #ffffff; border: 1px solid #111111;'>Request Pending</div>
                                </div>
                                <?php } ?>
                                </div>
                            <?php } else if ($usertype==600) { ?>
                                <div class="col">
                                <div class="profile__details__btn" style="width: 190px;">
                                <a href='./Admin/dashboard.php' class='follow-btn' style='padding-left: 20px; padding-right: 20px;'><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Admin Panel</a>
                                </div>
                                </div>
                            <?php } ?>
                                <div class="col">
                                <div class="profile__details__btn">
                                    <a href="editpf.php" class="follow-btn" style="padding-left: 30px; padding-right: 30px;"><i class="fas fa-edit"></i> Edit</a>
                                </div>
                                </div>   
                            </div>
                            </div>
                            <?php if (!empty($row2['self_intro'])) { ?>
                            <p><?php echo $row2['self_intro']; ?></p>
                            <?php } else { ?>
                            <p>Hello there. Nice to meet you!</p>
                            <?php } ?>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9">
                                        <ul>
                                            <li>
                                                <span>Gender:</span> <?php echo $row2['gender']; ?>
                                            </li>
                                            <li>
                                                <span>Birthday:</span> <?php 
                                                if ($row2['birthday'] == '0000-00-00') { 
                                                    echo '<i>Data not assigned</i>'; 
                                                } else { 
                                                    $birthday = date('d M Y', strtotime($row2['birthday']));
                                                    echo $birthday; } ?>
                                            </li>
                                            <li>
                                                <span>Joined:</span> <?php 
                                                    $joinedDate = date('d M Y', strtotime($row2['joined_date']));
                                                    echo $joinedDate; ?>
                                            </li>
                                            <li>
                                                <?php $web = $row2['website']; ?>
                                                <span>Website:</span> <?php if (!empty($web)) { ?><a href="<?php echo $web; ?>" target="_blank"><?php echo $web; ?></a><?php } else { ?><i>Data not assigned</i><?php } ?>
                                            </li>
                                           <!--  <li>
                                                <span>Interest:</span> Action, Adventure, Fantasy, Magic
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                            <div class="anime__details__btn">
                                <!-- <a href="#" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</a> -->

                            <?php if (($usertype==600)||($usertype==701)) { ?>
                                <a href="createarticle.php" class="watch-btn"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pen-tool"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586"></path><circle cx="11" cy="11" r="2"></circle></svg> Create</span> <i
                                    class="fa fa-angle-right" style="padding-top: 15px; padding-bottom: 22.5px;"></i></a>
                                <a href="createartwork.php" class="watch-btn"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> Upload</span> <i
                                    class="fa fa-angle-right" style="padding-top: 15px; padding-bottom: 22.5px;"></i></a>
                                </div>
                                <div class="pfLogout__details__btn">
                                <a href="logout.php" name="logout" class="logout-btn" onclick='return ConfirmUpdate();'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout</a>
                            <?php } else if ($usertype==702) { ?>
                                <a href="createartwork.php" class="watch-btn"><span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-image"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg> Upload</span> <i
                                    class="fa fa-angle-right" style="padding-top: 15px; padding-bottom: 22.5px;"></i></a>
                                </div>
                                <div class="pfLogout__details__btn" style="margin-left: 178px;">
                                <a href="logout.php" name="logout" class="logout-btn" onclick='return ConfirmUpdate();'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout</a>
                            <?php } else if ($usertype==800) { ?>
                                </div>
                                <div class="pfLogout__details__btn" style="margin-left: 353px;">
                                <a href="logout.php" name="logout" class="logout-btn" onclick='return ConfirmUpdate();'><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Logout</a>
                            <?php } ?>
                                </div>
                                </div>
                            </div>
                            </div>
                            </div>
                            </div>
                        <?php if ($usertype != 800) { ?>
                            <div class="ch_list">
                        <div class="anime__details__articles">
                        <div class="section-title">
                            <h5>Created Works</h5>
                        </div>
                        <div class="row">
                        <?php 
                            if ($stmt1->rowCount() > 0) {
                                
                                while ($row1 = $stmt1->fetch()) { 
                                if (($row1['publish_unpublish'])==1) {

                                $articleId=$row1['article_id'];
                                $articleTitle=$row1['article_title']; ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" style="height: 350px" data-setbg="<?php echo $row1['article_photo']; ?>"></div>
                                    <div class="product__item__text" style="padding-top: 0px; text-align: center; height: 80px;">
                                    <?php echo "<h5><a href='anime-details.php?articleId=$articleId&prevPg=$prevPg#target1'>$articleTitle</a></h5>" ?>
                                    </div>
                                </div>
                            </div>
                        <?php } } } else { ?>
                            <p style="color: #ccc; font-weight: 700; font-size: 20px; margin-left: 35%;">
                            There is no created works yet</p>
                        <?php } ?>
                        </div>
            </div>
                        </div>
                        <?php } ?>
                            <div class="ch_list">
                        <div class="anime__details__articles">
                        <div class="section-title">
                            <h5>Bookmark</h5>
                        </div>
                        <div class="row">
                        <?php 
                            $sql5 = "SELECT * FROM bookmark_table WHERE user_name='$username' AND user_email='$email'";
                            $stmt5 = $db->query($sql5);
                            $result5 = $stmt5->setFetchMode(PDO::FETCH_ASSOC);
                            
                            if ($stmt5->rowCount() > 0) {
                            while ($row5=$stmt5->fetch()) {
                                $articleId=$row5['article_id'];

                                $sql6 = "SELECT * FROM article_table WHERE article_id='$articleId'";
                                $stmt6 = $db->query($sql6);
                                $result6 = $stmt6->setFetchMode(PDO::FETCH_ASSOC);
                                $row6 = $stmt6->fetch();
                                if (($row6['publish_unpublish'])==1) {

                                $articleId=$row6['article_id'];
                                $articleTitle=$row6['article_title']; ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" style="height: 350px" data-setbg="<?php echo $row6['article_photo']; ?>"></div>
                                    <div class="product__item__text" style="padding-top: 0px; text-align: center; height: 80px;">
                                    <?php echo "<h5><a href='anime-details.php?articleId=$articleId&prevPg=$prevPg#target1'>$articleTitle</a></h5>" ?>
                                    </div>
                                </div>
                            </div>
                        <?php } } } else { ?>
                            <p style="color: #ccc; font-weight: 700; font-size: 20px; margin-left: 32%;">
                            You haven't bookmark any works yet</p>
                        <?php } ?>
                        </div>
            </div>
                        </div>
        </section>
          </div>
            </div>
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
                              <li Y><a href="./index.php">Homepage</a></li>
                        <li ><a href="./categories.php">Categories</a></li>
                         <li><a href="./novellist.php">Novels List</a></li>
                        <li><a href="./blog.php">illustrations</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                         Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://goldentkm.com/lightnovelarchive" target="_blank">Light Novel Archive</a>

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
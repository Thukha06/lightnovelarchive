<?php
    session_start();
    require("database.php");
    $loginid = "";
    $username = ""; $email = "";

    if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['articleId']))) {
        $articleId = $_GET['articleId'];

        $sql = "SELECT * FROM article_table WHERE article_id='$articleId'";
        $stmt = $db->query($sql);
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();
        $author = $row['user_name'];
    } else {
        echo "<script>
            history.back();
            </script>";
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
    <script type="text/javascript">
        function goBack() {
            history.back();
        }
    </script>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Breadcrumb Begin -->
    <div class="bruh-option">
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
                                            <!-- <li><span>Genre:</span> Action, Adventure, Fantasy, Magic</li> -->
                                        </ul>
                                    </div>
                                </div>
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
<section>
  <div class="block">
    <div id="externalContent"></div>
    <p class="line-break margin-top-20"></p>
    <div class="article-title article__details__btn">
        <center>
        <button class="go-back" onclick="goBack()">Go Back</button></center>
    </div>
  </div>
</section> 
        </section>
        <!-- Anime Section End -->


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
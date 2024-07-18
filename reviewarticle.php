<?php
    session_start();
    require("database.php");
    $content = ""; $reviewImg = "";
    $title = ""; $paratitle = ""; $imgpos = "";
    $content = $_SESSION['content'];
    $reviewImg = $_SESSION['reviewImg'];
    $title = $_SESSION['title'];
    $paratitle = $_SESSION['paratitle'];
    $imgpos = $_SESSION['imgpos'];
    $orien = $_SESSION['orientation'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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

    <style type="text/css">
        #parallax-world-of-ugg .reviewImg {
            padding-top: 200px; 
            padding-bottom: 200px; 
            overflow: hidden; 
            position: relative; 
            width: 100%; 
            background-image: url(<?php echo $reviewImg; ?>?dpr=1&auto=format&fit=crop&w=1500&h=938&q=80&cs=tinysrgb&crop=); 
            background-attachment: fixed; 
            <?php if ($imgpos==0) {
                    if ($orien==0) { ?>
                    background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; 
                <?php } else if ($orien==1) { ?>
                    background-size: 30%;
                <?php } ?>
            <?php } else if ($imgpos==1) {
                    if ($orien==0) { ?>
                    background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; 
                <?php } else if ($orien==1) { ?>
                background-size: 30%;
            <?php } } ?>
            background-repeat: no-repeat; 
            background-position: top center;
        }
    </style>
    <script type="text/javascript">
        function loadExternalHTML() {
            const container = document.getElementById('externalContent');
            fetch('<?php echo $content; ?>')
                .then(response => response.text())
                .then(data => container.innerHTML = data)
                .catch(error => console.error('Error:', error));
        }

        function goBack() {
            history.back();
        }
    </script>
</head>
<body onload="loadExternalHTML()">
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

<!-- partial:index.partial.html -->
<div id="parallax-world-of-ugg">
  
<section>
  <div class="title">
    <h1>ARTICLE REVIEW</h1>
    <p class="line-break margin-top-10"></p>
  </div>
</section>

<section>
  <div class="title">
    <h3><?php echo $title; ?></h3><br>
    <h3><?php echo $paratitle; ?></h3>
  </div>
</section>
<?php if ($imgpos==0) { ?>
<section>
    <div class="reviewImg">
    </div>
</section>

<section>
  <div class="block">
    <div id="externalContent"></div>
    <p class="line-break margin-top-20"></p>
    <div class="article-title article__details__btn">
        <button class="go-back" onclick="goBack()">Go Back</button>
    </div>
  </div>
</section>
<?php } else if ($imgpos==1) { ?>
<section>
  <div class="block">
    <div id="externalContent"></div>
  </div>
</section>
<section>
    <div class="reviewImg">
    </div>
</section>
<section>
  <div class="block">
    <p class="line-break margin-top-20"></p>
    <div class="article-title article__details__btn">
        <button class="go-back" onclick="goBack()">Go Back</button>
    </div>
  </div>
</section>
<?php } else { ?>
<section>
  <div class="block">
    <div id="externalContent"></div>
    <p class="line-break margin-top-20"></p>
    <div class="article-title article__details__btn">
        <button class="go-back" onclick="goBack()">Go Back</button>
    </div>
  </div>
</section>  
<?php } ?>
</div>
<!-- partial -->

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
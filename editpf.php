<?php
    session_start();
    require("database.php");
    $loginid = ""; $checkErr = "";
    $intro = ""; $birthday = "";
    $gender = ""; $website = "";
    $imgSavederr = ""; $imgSavederr1 = "";

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
    $registerId = $row['register_id'];

    // Retaining the profile data
    $sql2 = "SELECT * FROM registration_table WHERE register_id='$registerId'";
    $stmt2 = $db->query($sql2);
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $row2=$stmt2->fetch();
    $intro = $row2['self_intro']; $birthday = $row2['birthday'];
    $gender = $row2['gender']; $website = $row2['website'];
    $filePath = $row2['cover_photo']; $filePath1 = $row2['profile_photo'];

    if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['done']))) {
        $check1 = 0; $check2 = 0;

        // Checking for empty POST data
        if (!empty($_POST['intro'])) {
            $intro = $_POST['intro'];
        }
        if (!empty($_POST['birthday'])) {
            $birthday = date("Y-m-d", strtotime($_POST['birthday']));
        }
        if (!empty($_POST['customRadio'])) {
            $gender = $_POST['customRadio'];
        }
        if (!empty($_POST['website'])) {
            $website = $_POST['website'];
        }

        $filename = str_replace(' ', '', strtolower($username)); // Username without whitespaces

        // Store Cover Image Locally
        if (!empty($_FILES["cover-photo"]["name"])) {
        $imagefile = $_FILES["cover-photo"]["name"];
        $tempname = $_FILES["cover-photo"]["tmp_name"];
        $filePath = "./upload/pfupload/" .$filename. $imagefile;  // Path to cover image

        if (move_uploaded_file($tempname, $filePath)) {
            $check1 = 1;
        } else {
            $imgSavederr = "<b>Failed to upload chapter image!</b>";
            }
        }

        // Store Profile Image Locally
        if (!empty($_FILES["pf-photo"]["name"])) {
        $imagefile1 = $_FILES["pf-photo"]["name"];
        $tempname1 = $_FILES["pf-photo"]["tmp_name"];
        $filePath1 = "./upload/pfupload/" .$filename. $imagefile1;  // Path to profile image

        if (move_uploaded_file($tempname1, $filePath1)) {
            $check2 = 1;
        } else {
            $imgSavederr1 = "<b>Failed to upload chapter image!</b>";
            }
        }

        // Final check before Review
        if(($check1 = 1)&&($check2 = 1)) {
            // Insert data into database
            $sql1 = "UPDATE registration_table SET website='$website', gender='$gender', birthday='$birthday', self_intro='$intro', profile_photo='$filePath1', cover_photo='$filePath' WHERE register_id='$registerId'";
            $db->exec($sql1);

            // Redirect with Delay
            echo "<script>location.href='profile.php';</script>";
        } else {
            $checkErr = "<b>Error uploading files.</b>";
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
    .pfLogout__details__btn .logout-btn {
        font-size: 13px;
        color: #ffffff;
        background: #e53637;
        display: inline-block;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 14px 20px;
        border-radius: 4px;
        margin-left: 850px;
    }
    .article__details__btn {
        margin-bottom: 20px;
    }
    .article__details__btn .title-btn {
        color: #111111;
        width: 70%;
        border: none;
        display: inline-block;
        font-weight: 700;
        letter-spacing: 2px;
        text-align: left;
        text-transform: uppercase;
        padding: 14px 10px;
        border-radius: 10px;
        box-shadow: 1px 1px 5px #ccc;
    }
    .article__details__btn .title-btn input {
        border: none;
        width: 90%;
        text-align: center;
    }

/*    for cover photo*/
    .file-upload {
        display: none;
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
    .p-image {
        position: absolute;
        top: 167px;
        right: 30px;
        color: #666666;
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }
    .p-image:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    }
    .upload-button {
        margin-top: 200px;
        margin-right: 70px;
        color: #ccc;
        font-size: 1.2em;
    }
    .upload-button:hover {
        transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        color: #999;
    }

/*    for profile photo*/
    .avatar-upload {
        bottom: 150px;
        position: relative;
        max-width: 250px;
        margin: 50px auto;
    }
    .avatar-edit {
        position: absolute;
        right: 55px;
        z-index: 1;
        top: 10px;
    }
    #imageUpload {
        display: none;
    }
    .img-upload {
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 100%;
        background: #FFFFFF;
        border: 1px solid transparent;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
        cursor: pointer;
        font-weight: normal;
        transition: all .2s ease-in-out;
    }
    .img-upload:hover {
        background: #f1f1f1;
        border-color: #d6d6d6;
    }
    .img-upload:after {
        content: "\f040";
        font-family: 'FontAwesome';
        color: #757575;
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        text-align: center;
        margin: auto;
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
        var msg=confirm("Are you sure want to update?");
        if(msg)
        return true;
        else return false;
        }
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
                <a href="./profile.php"> Profile</a>
                <span>Edit Profile</span>
            </div>
        </div>
        </div>
    </div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <!-- Cover photo section -->
    <section hidden class="cover-breadcrumb set-bg" data-setbg=""></section>
    <div class="image-container">
        <img class="profile-pic" src="<?php echo $row2['cover_photo']; ?>">
    </div>
    <div class="p-image">
        <i class="fa fa-camera upload-button"></i>
        <input class="file-upload" type="file" name="cover-photo" accept="image/*"/>
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
                <div class="avatar-edit">
                    <input type='file' name="pf-photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                    <label for="imageUpload" class="img-upload"></label>
                </div>
                <div class="avatar-preview">
                    <div id="imagePreview" style="background-image: url(<?php echo $row2['profile_photo']; ?>);"></div>
                </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="profile__details__text">
                <div class="profile__details__title">
                    <h3><?php echo $loginid; ?></h3>
                    <span>Introduction:</span>
                </div>
                    <p>
                        <i class="fas fa-edit"></i>
                        <textarea type="text" style="border: none;" placeholder="Enter Description Here" name="intro" id="autoResizeTextarea" rows="2" cols="80" maxlength="500" value="<?php echo isset($_POST['done']) ? $_POST['intro'] : ''; ?>"><?php echo $intro;?></textarea>
                    </p>
                <div class="profile__details__widget">
                    <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="article-title article__details__btn">
                            <label for="textInput">Birthday:</label><br>
                            <div class="title-btn">
                                <i class="fas fa-edit"></i>
                                <input type="date" name="birthday" maxlength="20" value="<?php  echo $birthday;
                                echo isset($_POST['done']) ? $_POST['birthday'] : ''; ?>">
                            </div>
                        </div>
                        <div class="article-title article__details__btn">
                            <label for="textInput">Gender:</label><br>
                            <div class="row">
                                  <?php if ($gender=="Male"){?>
                                <div class="col-sm-2">

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="Male" checked>
                                <label for="customRadio1" class="custom-control-label">Male</label>
                            </div>
                                </div>
                                <div class="col-sm-2">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="Female">
                                <label for="customRadio2" class="custom-control-label">Female</label>
                            </div>

                                </div>
                                <div class="col-sm-2">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" value="Other">
                                <label for="customRadio3" class="custom-control-label">Other</label>
                            </div>
                            
                                </div>
                            <?php }?>
                             <?php if ($gender=="Female"){?>
                                <div class="col-sm-2">

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="Male" >
                                <label for="customRadio1" class="custom-control-label">Male</label>
                            </div>
                                </div>
                                <div class="col-sm-2">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="Female" checked>
                                <label for="customRadio2" class="custom-control-label">Female</label>
                            </div>

                                </div>
                                <div class="col-sm-2">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" value="Other">
                                <label for="customRadio3" class="custom-control-label">Other</label>
                            </div>
                            
                                </div>
                            <?php }?>
                              <?php if ($gender=="Other"){?>
                                <div class="col-sm-2">

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="Male" >
                                <label for="customRadio1" class="custom-control-label">Male</label>
                            </div>
                                </div>
                                <div class="col-sm-2">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="Female" >
                                <label for="customRadio2" class="custom-control-label">Female</label>
                            </div>

                                </div>
                                <div class="col-sm-2">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" value="Other"checked>
                                <label for="customRadio3" class="custom-control-label">Other</label>
                            </div>
                            
                                </div>
                            <?php }?>
                            </div>
                        </div>
                            <div class="article-title article__details__btn">
                                <label for="textInput">Website:</label><br>
                                <div class="title-btn">
                                    <i class="fas fa-edit"></i>
                                    <input type="url" placeholder="https://..." name="website" maxlength="50" value="<?php echo $website; echo isset($_POST['done']) ? $_POST['website'] : ''; ?>">
                                </div>
                            </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
                    <div class="row" style="margin-top: 20px;">
                        <p>
                        <?php if(($check1 = 0)||($check2 = 0)) {
                                echo $checkErr;
                                echo $imgSavederr;
                                echo $imgSavederr1;
                            } ?>
                        </p>
                        <div class="pfLogout__details__btn">
                            <label for="done-btn" class="logout-btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> Done</label>
                            <input hidden type="submit" name="done" id="done-btn" onclick='return ConfirmUpdate();' value="Done">
                        </div>
                    </div>
                </div>
    </section>
</form>
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
                                <li class="active"><a href="./index.php">Homepage</a></li>
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
<script type="text/javascript">
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

$(document).ready(function() {

    
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
});
</script>
    </body>

    </html>
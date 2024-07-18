<?php
    session_start();
    require("database.php");
    $loginid = ""; $Saved = ""; $Savederr = "";
    $imagefile = ""; $imagefile1 = ""; 
    $tempname = ""; $tempname1 = ""; 
    $imgSaved = ""; $imgSavederr = "";
    $imgSaved1 = ""; $imgSavederr1 = "";
    $imgSaved2 = ""; $imgSavederr2 = "";
    $title = ""; $paratitle = "";
    $descript = ""; $checkErr = "";
    $loginid = $_SESSION['logindata'];

    $sql = "SELECT * FROM login_table WHERE user_name='$loginid'";
    $stmt = $db->query($sql);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $row=$stmt->fetch();
    $username = $row['user_name'];
    $email = $row['user_email'];
    $checkErr = "*Please be aware to choose Images again after page refreshes*";

// When 'Save & Review' button is clicked
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['save']))) {
    $check1 = 0; $check2 = 0; $check3 = 0; $check4 = 0;

    $content = $_POST["content"]; // Main Content
    $title = $_POST["title"]; // Article Title
    $descript = $_POST["descript"]; // Article description
    $paratitle = $_POST["paratitle"]; // Chapter Title
    $imgpos = $_POST["customRadio"]; // Image position
    $orien = $_POST['orientation']; // Image Orientation
    $_SESSION['title'] = $title;
    $_SESSION['paratitle'] = $paratitle;
    $_SESSION['imgpos'] = $imgpos;
    $_SESSION['orientation'] = $orien;

    // Creating Unique name for content file
    $filename1 = str_replace(' ', '', strtolower($title));
    $filename2 = str_replace(' ', '', strtolower($paratitle));
    $filename3 = str_replace(' ', '', strtolower($username));
    $filename = $filename1.$filename2.'by'.$filename3.'.html';

    // Defining the path to store the content
    $filePath = "./content/".$filename; // Path to main content
    $_SESSION['content'] = $filePath;

    // Save the content to the file
    if (file_put_contents($filePath, $content) !== false) {
        $Saved = "Content saved successfully!";
        $check1 = 1;
    } else {
        $Savederr = "<b>Error saving content.</b>";
    }

    // Store Chapter Image Locally
    $imagefile = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $filePath1 = "./content/upload/" .$filename1.$filename2. $imagefile;  // Path to chapter image
    $_SESSION['reviewImg'] = $filePath1;

    if (move_uploaded_file($tempname, $filePath1)) {
        $imgSaved = "Chapter image uploaded successfully!";
        $check2 = 1;
    } else {
        $imgSavederr = "<b>Failed to upload chapter image!</b>";
        }

    // Store Article Profile Image Locally
    $imagefile1 = $_FILES["uploadfile1"]["name"];
    $tempname1 = $_FILES["uploadfile1"]["tmp_name"];
    $filePath2 = "./content/upload/" .$filename1. $imagefile1; // Path to article image

    if (move_uploaded_file($tempname1, $filePath2)) {
        $imgSaved1 = "Article image uploaded successfully!";
        $check3 = 1;
    } else {
        $imgSavederr1 = "<b>Failed to upload article image!</b>";
        }

    // Store Article Cover Image Locally
    $imagefile2 = $_FILES["uploadfile2"]["name"];
    $tempname2 = $_FILES["uploadfile2"]["tmp_name"];
    $filePath3 = "./content/upload/" .$filename1. $imagefile2; // Path to article image

    if (move_uploaded_file($tempname2, $filePath3)) {
        $imgSaved2 = "Article image uploaded successfully!";
        $check4 = 1;
    } else {
        $imgSavederr2 = "<b>Failed to upload article image!</b>";
        }

    // Final check before Review
    if(($check1 = 1)&&($check2 = 1)&&($check3 = 1)&&($check4 = 1)) {
        echo "<script>location.href='reviewarticle.php';</script>";
    } else {
        $checkErr = "<b>Error creating content</b>";
    }
}

// When 'Publish' button is clicked
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['publish']))) {
    $title = $_POST["title"]; // Article Title
    $descript = $_POST["descript"]; // Article description
    $paratitle = $_POST["paratitle"]; // Chapter Title
    $imgpos = $_POST["customRadio"]; // Image position
    $orien = $_POST['orientation']; // Image Orientation

    // Path to main content
    $filename1 = str_replace(' ', '', strtolower($title));
    $filename2 = str_replace(' ', '', strtolower($paratitle));
    $filename3 = str_replace(' ', '', strtolower($username));
    $filename = $filename1.$filename2.'by'.$filename3.'.html';
    $filePath = "./content/".$filename;

    // Path to chapter image
    $imagefile = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $filePath1 = "./content/upload/" .$filename1.$filename2. $imagefile;

    // Path to article profile image
    $imagefile1 = $_FILES["uploadfile1"]["name"];
    $tempname1 = $_FILES["uploadfile1"]["tmp_name"];
    $filePath2 = "./content/upload/" .$filename1. $imagefile1;

    // Path to article cover image
    $imagefile2 = $_FILES["uploadfile2"]["name"];
    $tempname2 = $_FILES["uploadfile2"]["tmp_name"];
    $filePath3 = "./content/upload/" .$filename1. $imagefile2;

    // Retrieving date of creation
    $publishedDate = date("Y-m-d");
    $updatedDate = date("Y-m-d");

    // Inserting data into the database
    $sql1 = "INSERT INTO article_table (article_title, article_photo, article_coverphoto, article_description, user_name, user_email, published_date, updated_date) VALUES ('$title', '$filePath2', '$filePath3', '$descript', '$username', '$email', '$publishedDate', '$updatedDate')";
    $db->exec($sql1);
    $last_id = $db->lastInsertId();

    $sql2 = "INSERT INTO chapter_table (ch_title, ch_photo, ch_content, photo_pos, photo_orien, article_id) VALUES ('$paratitle', '$filePath1', '$filePath', '$imgpos', '$orien', '$last_id')";
    $db->exec($sql2);

    $Saved = "Content published successfully!";
    // Redirect with Delay
    echo "<script>
                setTimeout(function() {
                window.location.href = 'profile.php';
                window.clearTimeout(tID);
            }, 3000);
    </script>";
}
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
        /* Hide the default button */
        input[type="file"] {
            display: none;
        }
        
        /* Style the custom button */
        .custom-file-upload {
            border: 1px solid #ccc;
            border-radius: 5px;
            display: ;
            padding: 6px 12px;
            cursor: pointer;
        }

        .imp {
            color: #e53637;
        }
        
        /* Style the selected file name display */
        .selected-file {
            font-size: 14px;
        }

        #myTextarea::placeholder {
            color: #ccc; /* Change the color */
            text-align: center;
            font-style: italic; /* Apply italic style */
            font-size: 10px; /* Adjust font size */
        }

        /* Add some basic styles to the textarea */
        #autoResizeTextarea {
            overflow: hidden; /* Hide scrollbars */
            resize: none; /* Disable manual resizing */
        }
    </style>
    <script src="https://cdn.tiny.cloud/1/r9mzt2wkvq8qzdwo5yn2otocjk55gta4nf7gvewv4q78aoz2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        let shouldClearContent = false;

        tinymce.init({
            selector: '#myTextarea',
            plugins: 'autoresize anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            autoresize_bottom_margin: 20,
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | table align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        // const clearButton = document.getElementById('clearButton');
        // clearButton.addEventListener('click', function() {
        //     shouldClearContent = true;
        //     const editor = tinymce.get('myTextarea');
        //     editor.setContent('');
        // });

        // Check if content should be cleared before saving
        // window.addEventListener('beforeunload', function(event) {
        //     if (shouldClearContent) {
        //         event.returnValue = 'You have unsaved changes.';
        //     }
        // });

        
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
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="./profile.php">Profile</a>
                        <span>Create Novel</span>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

<div id="parallax-world-of-ugg">

    <section>
        <div class="title">
        <h1>IMAGINATION</h1>
        <h3>Is the beginning of</h3>
        <h1>CREATION</h1>
        <?php if(($check1 = 1)&&($check2 = 1)&&($check3 = 1)&&($check4 = 1)) { ?>
        <br><h3><?php echo $Saved; ?></h3>
        <?php } else { ?>
        <br><h3 style="color: #e53637;"><?php echo $Savederr; ?></h3>
        <?php } ?>
        </div>
    </section>

    <section>
    <div class="block">
        <p class="line-break"></p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="article-title article__details__btn">
            <label for="textInput">Article Title (max 40 characters):<b class="imp">*</b></label><br>
            <div class="title-btn">
            <i class="fas fa-edit"></i>
            <input type="text" placeholder="Enter Title Here" name="title" maxlength="40" value="<?php echo isset($_POST['save']) ? $_POST['title'] : ''; ?>" required>
            </div>
        </div>
        <div class="article-title article__details__btn">
            <label for="textInput">SELECT Article Profile Photo:<b class="imp">*</b><br>(Portrait Layout is advised for best experience)</label><br>
            <div class="pfimage-btn">
            <label for="fileInput1" class="custom-file-upload">
                Choose File
            </label>
            <input type="file" id="fileInput1" name="uploadfile1">
            <div class="selected-file" id="selectedFile1"></div>
            <center><img id="imagePreview1" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 400px;"></center> 
            </div>
        </div>
        <div class="article-title article__details__btn">
            <label for="textInput">SELECT Article Cover Photo:<br>(Landscape Layout is advised for best experience)</label><br>
            <div class="pfimage-btn">
            <label for="fileInput2" class="custom-file-upload">
                Choose File
            </label>
            <input type="file" id="fileInput2" name="uploadfile2">
            <div class="selected-file" id="selectedFile2"></div>
            <center><img id="imagePreview2" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 400px;"></center> 
            </div>
        </div>
        <div class="article-title article__details__btn">
            <label for="textInput">Description (max 500 characters):<b class="imp">*</b></label><br>
            <div class="title-btn">
            <i class="fas fa-edit"></i>
            <textarea type="text" placeholder="Enter Description Here" name="descript" id="autoResizeTextarea" rows="1" cols="50" maxlength="500" value="<?php echo isset($_POST['save']) ? $_POST['descript'] : ''; ?>" required></textarea>
            </div>
        </div>
        <p class="line-break margin-top-20"></p><br>
        <div class="article-title article__details__btn">
            <label for="textInput">Chapter Name (max 20 characters):<b class="imp">*</b></label><br>
            <div class="title-btn">
            <i class="fas fa-edit"></i>
            <input type="text" placeholder="Enter Chapter Name Here" name="paratitle" maxlength="20" value="<?php echo isset($_POST['save']) ? $_POST['paratitle'] : ''; ?>" required>
            </div>
        </div>
        <div class="article-title article__details__btn">
            <label for="textInput">SELECT Chapter Photo:<br>(Landscape Layout is advised for best experience)</label><br>
            <div class="pfimage-btn">
            <label for="fileInput" class="custom-file-upload">
                Choose File
            </label>
            <input type="file" id="fileInput" name="uploadfile"><br>
            <div class="selected-file" id="selectedFile"></div>
            <center><img id="imagePreview" src="#" alt="Image Preview" style="display: none; max-width: 100%; max-height: 400px;"></center> 
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
        <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="customRadio1" name="customRadio" value="0">
            <label for="customRadio1" class="custom-control-label">Before Paragraph</label>
        </div>
        <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="customRadio2" name="customRadio" value="1" >
            <label for="customRadio2" class="custom-control-label">After Paragraph</label>
        </div>
        <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="customRadio3" name="customRadio" value="2" checked>
            <label for="customRadio3" class="custom-control-label">No Selection</label>
        </div>
            </div>
        <div class="col-sm-6">
            <div class="form-group">
            <label>Orientation:</label><br>
              <select name="orientation" class="form-control">
                  <option value="0">Landscape</option>
                  <option value="1">Portrait</option>
              </select>
            </div>
            </div>
        </div>
        <div class="article-title article__details__btn">
        <label for="textInput">Main Content:<b class="imp">*</b></label><br>
        <textarea name="content" id="myTextarea" rows="5" cols="50" style="text-align: center; padding: 10px; padding-top: 50px;" placeholder="Refresh the page again if the text editor is not present.&#10;Also please check to ensure you have a stable connection."></textarea>
        </div>
        <p class="line-break margin-top-20"></p><br>
        <div class="article-title article__details__btn">
        <div class="row">
            <div class="col">
        <input type="submit" name="save" class="save-btn1" value="Save & View"></input>
            </div>
            <div class="col">
        <input type="submit" name="publish" class="save-btn2" id="clearButton" value="Publish"></input>
            </div>
        </div>
        </div><br>
        <div class="title">
        <h3 style="color: #e53637; letter-spacing: 4px;"><?php echo $checkErr; ?></h3><br>
        <?php if(($check1 = 1)&&($check2 = 1)&&($check3 = 1)&&($check4 = 1)) { ?>
        <h3><?php echo $imgSaved; ?></h3><br>
        <h3><?php echo $imgSaved1; ?></h3><br>
        <h3><?php echo $imgSaved2; ?></h3><br>
        <h3><?php echo $Saved; ?></h3>
        <?php } else { ?>
        <h3 style="color: #e53637;"><?php echo $imgSavederr; ?></h3><br>
        <h3 style="color: #e53637;"><?php echo $imgSavederr1; ?></h3><br>
        <h3 style="color: #e53637;"><?php echo $imgSavederr2; ?></h3><br>
        <h3 style="color: #e53637;"><?php echo $Savederr; ?></h3>
        <?php } ?>
        </div>
    </form>
    </div>
    </section>
</div>

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
        const textarea = document.getElementById('autoResizeTextarea');
        
        textarea.addEventListener('input', function() {
            this.style.height = 'auto'; // Reset height to auto
            this.style.height = (this.scrollHeight) + 'px'; // Set new height based on content
        });

        // Image Preview for Chapter Photo
        const imageInput = document.getElementById('fileInput');
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

        // Image Preview for Article Profile Photo
        const imageInput1 = document.getElementById('fileInput1');
        const imagePreview1 = document.getElementById('imagePreview1');
        
        imageInput1.addEventListener('change', function(event) {
            const selectedFile1 = event.target.files[0];
            
            if (selectedFile1) {
                imagePreview1.style.display = 'block';
                imagePreview1.src = URL.createObjectURL(selectedFile1);
            } else {
                imagePreview1.style.display = 'none';
                imagePreview1.src = '#';
            }
        });

        // Image Preview for Article Cover Photo
        const imageInput2 = document.getElementById('fileInput2');
        const imagePreview2 = document.getElementById('imagePreview2');
        
        imageInput2.addEventListener('change', function(event) {
            const selectedFile2 = event.target.files[0];
            
            if (selectedFile2) {
                imagePreview2.style.display = 'block';
                imagePreview2.src = URL.createObjectURL(selectedFile2);
            } else {
                imagePreview2.style.display = 'none';
                imagePreview2.src = '#';
            }
        });

        window.addEventListener('resize', setAspectRatio);
        window.addEventListener('load', setAspectRatio);

        /* Show uploaded file name for custom select button */
        const fileInput = document.getElementById('fileInput');
        const selectedFileDisplay = document.getElementById('selectedFile');

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                selectedFileDisplay.textContent = 'Selected file: ' + fileInput.files[0].name;
            } else {
                selectedFileDisplay.textContent = '';
            }
        });
    </script>
</body>
</html>
<?php
  session_start();
  require("database.php");
  $loginid = $_SESSION['logindata'];
  $filename = $_SESSION['image_path'];
  $folderName = "upload";
  // $filename = "Panda.jpg";
  $folder = "../upload/" . $filename;

  $sql1 = "SELECT * FROM image_table WHERE image_path='$filename'";
  $stmt1 = $db->query($sql1);
  $result1 = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
  $row1=$stmt1->fetch();

  $IllustratorName = $row1['user_name'];
  $title = $row1['img_title'];  
  $descrip = $row1['img_descrip'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Light Novel | ADMIN Panel</title>
	<link rel="stylesheet" type="text/css" href="showarticle.css">
	<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
</head>
<style type="text/css">
	@import url(https://fonts.googleapis.com/css?family=Oswald:300,400,700);
@import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic);
	.img{
		margin-top: 15px;
	}
	img{
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
/*		background: #e53637;*/
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
		box-shadow: 2px 2px 10px darkgray;
		width: 800px;
		padding-bottom: 30px;
		padding-top: 15px;
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
		margin-bottom: 30px;
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
/*	padding: 10px 10px;*/
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
/*	padding: 10px 10px;*/
	border-radius: 4px;
	border: solid white;
	width: 100px;
	border-radius: 20px;
	border: solid black;
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
<body>
<div id="parallax-world-of-ugg">
    <center>
    <div class="container">
    <div class="name">
        <h1><?php echo $IllustratorName; ?>'s Illustration</h1>
    </div>
    <div class="img">
	<img src="<?php echo "$folder";?>">
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
</body>
</html>
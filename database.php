<?php
	$servername="localhost:3306";
	$username="root"; $password=""; $dbname="lightnovelarchive";

	try {
    	$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    	//echo 'Connected to database<br/>';
  	} catch(PDOException $e) {
    	echo $sql . "<br>" . $e->getMessage();
  	}
?>
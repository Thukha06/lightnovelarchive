<?php
	session_start();
    require("database.php");
    $loginid = "";
    $username = ""; $email = "";

    if(!empty($_SESSION['logindata'])) {
        $loginid = $_SESSION['logindata'];
    }

    $sql2 = "SELECT * FROM login_table WHERE user_name='$loginid'";
    $stmt2 = $db->query($sql2);
    $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
    $row2=$stmt2->fetch();
    $username = $row2['user_name'];
    $email = $row2['user_email'];

    if (($_SERVER["REQUEST_METHOD"] == "GET") && (!empty($_GET['articleId']))) {
        $articleId=$_GET['articleId'];
        $prevPg = $_GET['prevPg'];

        $sql = "DELETE FROM bookmark_table WHERE article_id='$articleId' AND user_name='$username'";
        $db->exec($sql);

        header("Location: anime-details.php?articleId=".$articleId."&prevPg=".$prevPg."#target");
        exit;
    }

?>
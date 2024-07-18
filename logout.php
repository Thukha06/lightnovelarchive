<?php
    session_start();

    // session_destroy();
    unset($_SESSION['logindata']);
    echo "<script>location.href='index.php';</script>"
    
?>
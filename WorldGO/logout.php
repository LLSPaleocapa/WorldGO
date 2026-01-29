<?php 

    setcookie("username", "", time() - 3600, "/");
    setcookie("color", "", time() - 3600, "/");

    session_start();
    unset($_SESSION["name"]);
    session_destroy();
    //eliminare cookie

    header("location: index.php");
    exit();

?>
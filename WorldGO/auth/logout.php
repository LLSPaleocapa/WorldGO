<?php 

    setcookie("username", "", time() - 3600, "/");
    setcookie("color", "", time() - 3600, "/");
    setcookie('jwt', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Strict',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    ]);

    session_start();
    unset($_SESSION["name"]);
    session_destroy();

    header("location: ../index.php");
    exit();

?>
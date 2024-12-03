<?php
session_start();

if (isset($_SESSION['token'])) {
    header("Location: /login_inte/home.php");
    exit(); 
} else {
    header("Location: /login_inte/login.html");
    exit();
}
?>

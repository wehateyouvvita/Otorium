<?php
session_start();

if (!isset($_SESSION['session'])) {
	header("Location: login/");
} else if (isset($_SESSION['session'])!="") {
	header("Location: home.php");
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['session']);
    unset($_COOKIE['token']);
    setcookie('token', null, -1, "/", "otorium.xyz", TRUE);
	header("Location: login/");
}

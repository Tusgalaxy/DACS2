<?php

session_start();

if(isset($_SESSION['wenet_userid'])){

    $_SESSION['wenet_userid'] = NULL;

    unset($_SESSION['wenet_userid']);
}

header("Location: login.php");
die;
<?php
session_start();

function isIT() {
    $return = false;
    if (isset($_SESSION['it']) && $_SESSION['it']==1) {
        $return = true;
    }

    if (!$return) {
        header("Location: index.php");
        die();
    }
}

function msg($msg, $type) {
    $_SESSION['msg'] = $msg;
    $_SESSION['type'] = $type;
}

if (!isset($_SESSION['id']) &&
    ($_SERVER['REQUEST_URI'] != '/rfcmanager/login.php') &&
    ($_SERVER['REQUEST_URI'] != '/rfcmanager/login_check.php') &&
    ($_SERVER['REQUEST_URI'] != '/rfcmanager/registration.php')) {
    header("Location: login.php");
    die();
}
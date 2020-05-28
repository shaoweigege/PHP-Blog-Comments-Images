<?php

$view  = require 'class/View.php';
$valid = require 'class/Valid.php';

if (isset($_POST['submit'])) {
    $valid->csrf_check();
    $dbase = require 'class/DBase.php';
    $dbase->doLogin($_POST['uname'], $_POST['upass']);
    header('location:index.php');
    exit();
}
require 'include/header.php';
if (UNAME) {
    header('location:index.php');
    exit();
}
$view->loginForm($valid);

require 'include/footer.php';

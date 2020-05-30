<?php

$view  = require 'class/View.php';
$valid = require 'class/Valid.php';
$error = '';

if (isset($_POST['submit'])) {
    $valid->csrf_check();
    $dbase = require 'class/DBase.php';
    $dbase->doLogin();
    $error = 'Username and password are incorrect';
}
require 'include/header.php';
if (UNAME) {
    header('location:index.php');
    exit();
}
echo '&nbsp;&nbsp;'.$error;
$view->loginForm($valid);

require 'include/footer.php';

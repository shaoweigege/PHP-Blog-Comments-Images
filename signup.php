<?php

$view  = require 'class/View.php';
$valid = require 'class/Valid.php';
require 'include/header.php';
if (UNAME) {
    header('location:index.php');
    exit();
}

echo '<div class="post">';
if (isset($_POST['submit'])) {
    $valid->csrf_check();
    if ($valid->captcha_check()) {
        $dbase = require 'class/DBase.php';
        $dbase->doSignUp();
    }
}
$view->signUpForm($valid);

require 'include/footer.php';

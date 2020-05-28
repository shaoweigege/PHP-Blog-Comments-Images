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
        if ($_POST['upass'] == $_POST['upass2']) {
            $dbase = require 'class/DBase.php';
            $uname = $dbase->getUname($_POST['uname']);
            if (!$uname) {
                $dbase->insertUser($_POST['uname'], $_POST['upass']);
                echo 'Success!</div>';
                require 'include/footer.php';
                exit();
            } else {
                echo 'Username already taken';
            }
        } else {
            echo 'Passwords don\'t match';
        }
    }
}
$view->signUpForm($valid);

require 'include/footer.php';

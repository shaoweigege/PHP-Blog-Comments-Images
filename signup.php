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
        $rpost =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        extract($rpost);
        if ($upass == $upass2) {
            $dbase = require 'class/DBase.php';
            $uname = $dbase->getUname($uname);
            if (!$uname) {
                $dbase->insertUser($uname, $upass);
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

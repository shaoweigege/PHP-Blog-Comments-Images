<?php

require 'include/header.php';
if (ULEVEL < 1) {
    header('location:index.php');
    exit();
}

$view  = require 'class/View.php';
$valid = require 'class/Valid.php';

if (isset($_POST['submit'])) {
    $valid->csrf_check();
    $dbase = require 'class/DBase.php';
    $pid = $dbase->insertPost($_POST['title'], $_POST['body']);
    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
        $dbase->imageUpload($pid);
    }
    header('location:readpost.php?id='.$pid);
    exit();
}
$view->addPostForm($valid);

require 'include/footer.php';

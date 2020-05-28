<?php

require 'include/header.php';
if (ULEVEL < 2) {
    header('location:index.php');
    exit();
}

$dbase = require 'class/DBase.php';
$view  = require 'class/View.php';

if (isset($_POST['submit'])) {
    extract($_POST);
    $dbase->updateLevel($id, $ulevel);
}

$users = $dbase->loadUsers();
$view->userLevel($users);

require 'include/footer.php';

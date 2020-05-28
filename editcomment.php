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
    if ($submit == 'Edit') {
        $dbase->updateComment($comid, $comment);
        header('location:readpost.php?id='.$postid);
        exit();
    }
    if ($submit == 'Delete') {
        $dbase->deleteComment($comid);
        header('location:readpost.php?id='.$postid);
        exit();
    }
}

$id = $_GET['id'];
$comment = $dbase->getComment($id);
$view->editCommentForm($comment);

require 'include/footer.php';

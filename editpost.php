<?php

require 'include/header.php';
if (ULEVEL < 2) {
    header('location:index.php');
    exit();
}

$dbase = require 'class/DBase.php';
$view  = require 'class/View.php';

if (isset($_POST['submit'])) {
    $rpost =  filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    extract($rpost);
    if ($submit == 'Edit') {
        $dbase->updatePost($postid, $title, $body);
        header('location:readpost.php?id='.$postid);
        exit();
    }
    if ($submit == 'Delete') {
        $dbase->deletePost($postid);
        $dbase->deletePostComments($postid);
        $dbase->decreaseUposts($userid);
        header('location:index.php');
        exit();
    }
}

$id = $_GET['id'];
$post = $dbase->loadPost($id);
$view->editPostForm($post);

require 'include/footer.php';

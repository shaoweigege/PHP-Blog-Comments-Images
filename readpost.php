<?php

$valid = require 'class/Valid.php';
$dbase = require 'class/DBase.php';
$view  = require 'class/View.php'; 

require 'include/header.php';

if (isset($_POST['submit'])) {
    $valid->csrf_check();
    if ($valid->captcha_check()) {
        $dbase->insertComment($_POST['author'], $_POST['comment'], $_POST['postid']);
        $id = $_POST['postid'];
    }
}    
    
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$dbase->increaseView($id);

$post = $dbase->loadPost($id);
$view->viewOnePost($post, $dbase);
$comments = $dbase->loadComments($id);
if ($comments)
    $view->viewComments($comments);
else {
    echo '<div class="post"><br>';
    echo 'No comments</div>';
}
$view->commentsForm($id, $valid);

require 'include/footer.php';
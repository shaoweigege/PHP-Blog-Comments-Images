<?php

if (!is_file('data/db_config.php')) {
    header('location:install/index.php');
    exit();
}

$dbase = require 'class/DBase.php';
$pagin = require 'class/Pagin.php';
$view  = require 'class/View.php';

require 'include/header.php';

$total = $dbase->countPosts();
if ($total == 0)
    echo '<div class="post">No Posts</div>';
else {
    $offset = $pagin->setup($total, $perpage);
    $posts = $dbase->loadPosts($offset, $perpage);
    $view->viewPosts($posts, $dbase);

    $pagin->showfoot();
}

require 'include/footer.php';

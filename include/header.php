<?php

require 'include/config.php';

if (isset($_COOKIE['userdata2'])) {
    list($id, $uname, $ulevel) = json_decode($_COOKIE['userdata2']);
    define('UID', $id);
    define('UNAME', $uname);
    define('ULEVEL', $ulevel);
} else {
    define('UID', 0);
    define('UNAME', false);
    define('ULEVEL', 0);
}

?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $blog_title ?></title>
<style>
    body {
        font-family: 'Times New Roman';
        font-size: 17px;
        margin: 0;
        background: #999999;
    }
    a {
        color: #0000cc;
    }
    a:hover {
        color: #cc0000;
    }
    #container {
        width: 850px;
        margin: auto;
        color: #ffffff;
        background: #000000;
    }
    #navbar {
        padding: 8px 0px;
    }
    #navbar a {
        margin-left: 20px;
        color: #ffffff;
        text-decoration: none;
    }
    #navbar a:hover {
        text-decoration: underline;
    }
    #btitle {
        font-size: 20px;
        font-weight: bold;
    }
    #content {
        margin: 0 2px;
        color: #000000;
    }
    .post {
        background: #eeeeee;
        padding: 6px 12px;
        margin-top: 2px;
    }
    .title {
        margin: 5px 0px;
        font-weight: bold;
    }
    .info {
        font-style: italic;  
        font-size: 16px;
    }
    .info a {
        text-decoration: none;
    }
    .texten {
        margin-top:6px;
    }
    .image {
        float: left;
        margin-right: 10px;
    }
    .clearboth {
        clear: both;
    }
    #footer {
        text-align: center;
        font-size: 13px;
        font-style: italic;
    }
</style>
</head>
<body>
<div id="container">
<div id="navbar">
<?php echo '<span id="btitle"><a href="index.php">'.$blog_title.'</a></span>' ?>
<a href="index.php">Home</a>
<a href="popular.php">Popular</a>
<?php
if (UNAME) {
    if (ULEVEL > 0) {
        echo '<a href="addpost.php">Add Post</a>';
        echo '<a href="members.php">Members</a>';
    }
    if (ULEVEL == 2)
        echo '<a href="userlevel.php">UserLevel</a>';
    echo '<a href="logout.php">Logout</a> ';
    echo UNAME;
} else {
    echo '<a href="login.php">Login</a>';
    echo '<a href="signup.php">Sign Up</a>';
}
?>
</div>
<div id="content">


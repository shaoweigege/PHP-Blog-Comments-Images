<?php

$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    userid MEDIUMINT,
    posttitle VARCHAR(100),
    postbody  TEXT,
    stamptime INTEGER,
    image VARCHAR(100) DEFAULT '',
    numviews MEDIUMINT DEFAULT 0
    )";
$db->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    author  VARCHAR(100),
    commentbody TEXT,
    postid  MEDIUMINT,
    stamptime INTEGER
    )";
$db->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    uname VARCHAR(100) UNIQUE,
    upass VARCHAR(100),
    ulevel TINYINT DEFAULT 1,
    uposts MEDIUMINT DEFAULT 0
    )";
$db->exec($sql);

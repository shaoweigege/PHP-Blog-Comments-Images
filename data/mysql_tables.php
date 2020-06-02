<?php

$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    userid INTEGER,
    posttitle TEXT,
    postbody  TEXT,
    stamptime INTEGER,
    image TEXT DEFAULT '',
    numviews INTEGER DEFAULT 0
    )";
$db->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    author  TEXT,
    commentbody TEXT,
    postid  INTEGER,
    stamptime INTEGER
    )";
$db->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    uname TEXT UNIQUE,
    upass TEXT,
    ulevel INTEGER DEFAULT 1,
    uposts INTEGER DEFAULT 0
    )";
$db->exec($sql);

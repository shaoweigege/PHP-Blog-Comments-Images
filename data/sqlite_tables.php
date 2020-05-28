<?php

$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY,
    userid INTEGER,
    posttitle TEXT,
    postbody  TEXT,
    stamptime INTEGER,
    image TEXT DEFAULT '',
    numviews INTEGER DEFAULT 0
    )";
$db->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY,
    author  TEXT,
    comment TEXT,
    postid  INTEGER,
    stamptime INTEGER
    )";
$db->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY,
    uname TEXT UNIQUE COLLATE NOCASE,
    upass TEXT,
    ulevel INTEGER DEFAULT 1,
    uposts INTEGER DEFAULT 0
    )";
$db->exec($sql);

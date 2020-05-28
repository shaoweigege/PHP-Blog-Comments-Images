<?php

require 'include/header.php';

$dbase = require 'class/DBase.php';
$view  = require 'class/View.php';

$users = $dbase->loadUsers();
$view->listUsers($users);

require 'include/footer.php';

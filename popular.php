<?php

require 'include/header.php';

$dbase = require 'class/DBase.php';
$view  = require 'class/View.php';

$views = $dbase->getViews();
$view->listViews($views);
 
require 'include/footer.php';

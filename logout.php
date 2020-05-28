<?php

setcookie('userdata2', '', time() - 3600);
header('location:index.php');
exit();

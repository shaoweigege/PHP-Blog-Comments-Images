<?php

chdir('../');

if (is_file('data/db_config.php')) {
    header('location:../index.php');
    exit();
}

if (!isset($_POST['step'])) {
    include('install/html/step1.php');
    exit();
}

if ($_POST['step'] == '1') {
    $blog_title = $_POST['blog_title'];
    $perpage    = $_POST['perpage'];
    $timezone   = $_POST['timezone'];
    $locale     = $_POST['locale'];
    $config = <<<WRITE
<?php

\$blog_title = '$blog_title';
\$perpage = $perpage;
date_default_timezone_set('$timezone');
setlocale(LC_TIME, '$locale');

WRITE;
    file_put_contents('include/config.php', $config);

    $driver = $_POST['driver'];
    include('install/html/step2head.php');
    include('install/html/'.$driver.'.php');
    include('install/html/step2foot.php');
    exit();
}

if ($_POST['step'] == '2') {
    $driver = $_POST['driver'];
    $name   = $_POST['dbname'];
    if ($driver == 'sqlite') {
        $host = $user = $pass = '';
    }
    if ($driver == 'mysql') {
        $host = $_POST['dbhost'];
        $user = $_POST['dbuser'];
        $pass = $_POST['dbpass'];
    }

    include('install/class/DSNCreator.php');
    $pdo_dsn = new DSNCreator();
    $pdo_dsn->createDSN($driver, $host, $name, $user, $pass);
    $pdo_dsn->configWrite();
    $pdo_dsn->createTables();

    include('install/html/finish.php');
}
exit();

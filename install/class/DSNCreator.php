<?php

class DSNCreator
{
    public $driver;
    public $dsn;
    public $user;
    public $pass;

    public function createDSN($driver, $host, $name, $user, $pass)
    {
        // Create DSN
        $this->driver = $driver;
        if ($driver == 'sqlite') {
            $this->dsn = 'sqlite:' . $name;
        }
        if ($driver == 'mysql') {
            $this->dsn = 'mysql:host=' . $host . ';dbname=' . $name;
        }
        $this->user = $user;
        $this->pass = $pass;

        // Create MySQL Database if not exists
        if ($driver == 'mysql') {
            $dsn = 'mysql:host='.$host;
            $db = new PDO($dsn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE IF NOT EXISTS $name";
            $db->exec($sql);
            $db = null;
        }
    }

    public function configWrite()
    {
        $write = <<<WRITE
<?php

define('DRIVER', '$this->driver');
define('DSN', '$this->dsn');
define('USER', '$this->user');
define('PASS', '$this->pass');

WRITE;
        file_put_contents('data/db_config.php', $write);
    }

    public function createTables()
    {
        require('data/db_config.php');
        $db = new PDO(DSN, USER, PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        require 'data/'.DRIVER.'_tables.php';

        $db = null;
    }

}

<?php
Abstract Class Database
{
    protected $dsn;
    protected $pdo;

    public function __construct()
    {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $this->dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME. ";charset=" . CHARSET;
        $this->pdo = new PDO($this->dsn,DBUSER,DBPASS,$opt);
    }
}

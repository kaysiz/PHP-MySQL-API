<?php

class DB{
    private $dbhost = 'localhost';
    private $dbuser = 'root';
    private $dbpass = '';
    private $dbname = 'slimapp';

    //connect

    /**
     * @return string
     */
    public function connect()
    {
        $mysql_connect_str = "mysql:host=$this->dbhost; dbname=$this->dbname";
        $dbConnection = New PDO($mysql_connect_str, $this->dbuser,$this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
<?php

namespace TDW\LIB\Database;

class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";

    public function connect()
    {
        try {
            $conn = new \PDO("mysql:host=$this->servername;dbname=tdw", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch
        (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return  false;
        }
    }
}
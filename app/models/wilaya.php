<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;
use function Sodium\add;

class Wilaya
{
    private $code;
    private $name;

    public function __construct($code, $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public static function getWilaya($wilayaId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM wilayas WHERE id = ?');
            $stmt->bindParam(1, $wilayaId);
            $stmt->execute();
            $data = $stmt->fetch();
            return new Wilaya($data['1'], $data['2']);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getWillayas()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM wilayas');
            $stmt->execute();
            $wilayas = $stmt->fetchAll();
            $result = [];
            foreach ($wilayas as $wilaya) {
                array_push($result, new Wilaya($wilaya['1'], $wilaya['2']));
            }
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
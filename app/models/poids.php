<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Poids
{
    private $id;
    private $poidsInterval;

    public function getPoidsId()
    {
        return $this->id;
    }

    public function getPoidsInterval()
    {
        return $this->poidsInterval;
    }

    public function __construct($id, $poidsInterval)
    {
        $this->poidsInterval = $poidsInterval;
        $this->id = $id;
    }

    public static function getAllPoidsInterval()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM poids');
            $result = $stmt->execute();

            if (!$result || !$stmt->rowCount()) return false;

            $data = $stmt->fetchAll();
            $poidsIntervals = [];
            foreach ($data as $poids) {
                array_push($poidsIntervals, new Poids($poids['id'], $poids['poids']));
            }
            return $poidsIntervals;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getPoids($poidsId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM poids WHERE id = ?');
            $stmt->bindParam(1, $poidsId);
            $stmt->execute();
            $data = $stmt->fetch();
            return new Poids($data['0'], $data['1']);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
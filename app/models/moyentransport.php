<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class MoyenTransport
{
    private $id;
    private $moyen;

    public function getMoyenId()
    {
        return $this->id;
    }

    public function getMoyenName()
    {
        return $this->moyen;
    }

    public function __construct($id, $moyen)
    {
        $this->moyen = $moyen;
        $this->id = $id;
    }

    public static function getAllMoyensTrasport()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM moyentransport');
            $stmt->execute();
            $result = $stmt->execute();

            if (!$result || !$stmt->rowCount()) return false;

            $data = $stmt->fetchAll();
            $moyens = [];
            foreach ($data as $moyen) {
                array_push($moyens, new MoyenTransport($moyen['id'], $moyen['moyen']));
            }
            return $moyens;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
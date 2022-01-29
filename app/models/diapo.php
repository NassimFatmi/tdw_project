<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Diapo
{
    private $id;
    private $link;

    public function __construct($id, $link)
    {
        $this->id = $id;
        $this->link = $link;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLink()
    {
        return $this->link;
    }

    public static function getDiapos()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM diapo');
            $stmt->execute();
            if (!$stmt->rowCount()) return [];
            $data = $stmt->fetchAll();
            $diapos = [];
            foreach ($data as $diapo) {
                array_push($diapos, new Diapo($diapo["id"], $diapo["imageLink"]));
            }
            return $diapos;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function updateDiapo($id,$imageLink)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('UPDATE diapo SET imageLink = ? WHERE id = ?');
            $stmt->bindParam(1, $imageLink);
            $stmt->bindParam(2, $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
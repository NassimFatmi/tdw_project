<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Trajet
{
    private $id;
    private $transporteurId;
    private $wilayaId;

    public function setTrajetId($id)
    {
        $this->id = $id;
    }

    public function setTransporteurId($id)
    {
        $this->transporteurId = $id;
    }

    public function setWilayaId($id)
    {
        $this->wilayaId = $id;
    }

    public static function buildTrajets($trajetsArray)
    {
        $trajets = [];
        foreach ($trajetsArray as $trajet) {
            $newTrajet = new Trajet();
            $newTrajet->setWilayaId($trajet);
            array_push($trajets, $newTrajet);
        }
        return $trajets;
    }

    public function saveTrajet()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO trajet (transporteurId, wilayaId) VALUES (?,?)');
            $stmt->bindParam(1, $this->transporteurId);
            $stmt->bindParam(2, $this->wilayaId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getWilayaId () {
        return $this->wilayaId;
    }
}
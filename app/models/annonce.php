<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Annonce
{
    private $annonceId;
    private $pointDepart;
    private $pointArrive;
    private $typeTransport;
    private $moyenTransport;
    private $poids;
    private $description;

    public function __construct($pointArrive, $pointDepart, $typeTransport, $moyenTransport, $poids, $description)
    {
        $this->pointDepart = $pointDepart;
        $this->pointArrive = $pointArrive;
        $this->typeTransport = $typeTransport;
        $this->moyenTransport = $moyenTransport;
        $this->poids = $poids;
        $this->description = $description;
    }

    public function setAnnonceId($id)
    {
        $this->annonceId = $id;
    }

    public function getAnnonceId()
    {
        return $this->annonceId;
    }

    public function saveAnnonce()
    {
        try {

            $this->pointDepart->saveAdresse();
            $this->pointArrive->saveAdresse();

            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO annonce (adresseDepart, adresseArrive, typeTransport,poids,moyentransport,description) VALUES (?,?,?,?,?,?)');
            $adrDepartId = $this->pointDepart->getAdresseId();
            $adrArriveId = $this->pointArrive->getAdresseId();
            $typeId = $this->typeTransport->getTypeId();
            $moyenId = $this->moyenTransport->getMoyenId();
            $poidsId = $this->poids->getPoidsId();

            $stmt->bindParam(1, $adrDepartId);
            $stmt->bindParam(2, $adrArriveId);
            $stmt->bindParam(3, $typeId);
            $stmt->bindParam(4, $poidsId);
            $stmt->bindParam(5, $moyenId);
            $stmt->bindParam(6, $this->description);

            $result = $stmt->execute();
            if (!$result) return false;
            $id = $db->lastInsertId();
            $this->setAnnonceId($id);
            return true;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
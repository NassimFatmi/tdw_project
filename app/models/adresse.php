<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Adresse
{
    private $adresseId;
    private $commune;
    private $adr;
    private $wilayaCode;

    public function __construct($commune, $adr, $wilaya)
    {
        $this->wilayaCode = $wilaya;
        $this->adr = $adr;
        $this->commune = $commune;
    }

    public function setAdresseId($id)
    {
        $this->adresseId = $id;
    }

    public function getAdresseId()
    {
        return $this->adresseId;
    }

    public function getCommune()
    {
        return $this->commune;
    }

    public function getAdresseExacte()
    {
        return $this->adr;
    }

    public function getWilayaCode()
    {
        return $this->wilayaCode;
    }

    public function getWilaya()
    {
        $wilaya = Wilaya::getWilaya($this->wilayaCode);
        return $wilaya->getName();
    }

    public function saveAdresse()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO adresse (commune, adr, wilayaId) VALUES (?,?,?)');
            $stmt->bindParam(1, $this->commune);
            $stmt->bindParam(2, $this->adr);
            $stmt->bindParam(3, $this->wilayaCode);
            $result = $stmt->execute();
            $id = $db->lastInsertId();
            $this->setAdresseId($id);
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getAdresse($adresseId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM adresse WHERE adresseId = ?');
            $stmt->bindParam(1, $adresseId);
            $result = $stmt->execute();
            if (!$stmt->rowCount()) return false;
            $data = $stmt->fetch();
            $adresse = new Adresse($data['commune'], $data['adr'], $data['wilayaId']);
            $adresse->setAdresseId($adresseId);
            return $adresse;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;
use TDW\LIB\File;

class Annonce
{
    use File;

    private $annonceId;
    private $pointDepart;
    private $pointArrive;
    private $typeTransport;
    private $moyenTransport;
    private $poids;
    private $description;
    private $createdAt;
    private $verifier;
    private $archive;
    private $prix;
    private $finished;

    public function __construct($pointArrive, $pointDepart, $typeTransport, $moyenTransport, $poids, $description)
    {
        $this->pointDepart = $pointDepart;
        $this->pointArrive = $pointArrive;
        $this->typeTransport = $typeTransport;
        $this->moyenTransport = $moyenTransport;
        $this->poids = $poids;
        $this->description = $description;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setAnnonceId($id)
    {
        $this->annonceId = $id;
    }

    public function setVerifer($verifier)
    {
        $this->verifier = $verifier;
    }

    public function setArchiver($archive)
    {
        $this->archive = $archive;
    }

    public function setFinished($finished)
    {
        $this->finished = $finished;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getAnnonceId()
    {
        return $this->annonceId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPointDepart()
    {
        return $this->pointDepart;
    }

    public function getPoinArrive()
    {
        return $this->pointArrive;
    }

    public function getPoids()
    {
        return $this->poids;
    }

    public function getTypeTransport()
    {
        return $this->typeTransport;
    }

    public function getMoyTransport()
    {
        return $this->moyenTransport;
    }

    public function isVerified()
    {
        return $this->verifier;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function isFinished()
    {
        return $this->finished;
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
            return $this->_saveImage($this->annonceId, 'annonce', 'annonces');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getRandomAnnonce()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('
                        SELECT id1 AS annonceId, departWilaya, arriveWilaya,description,verifier,prix FROM
                                (SELECT annonceId AS id1, description,wilayas.nom AS departWilaya,verifier,prix
                                    FROM annonce
                                    JOIN adresse
                                    ON adresse.adresseId = annonce.adresseDepart
                                    JOIN wilayas ON wilayas.id = wilayaId
                                    WHERE verifier = true AND finished = false AND archive = false
                                    ) t1
                                JOIN
                                (SELECT annonceId AS id2 ,wilayas.nom AS arriveWilaya
                                    FROM annonce
                                    JOIN adresse
                                    ON adresse.adresseId = annonce.adresseArrive
                                    JOIN wilayas ON wilayas.id = wilayaId) t2
                                ON
                                t1.id1 = t2.id2
                                ORDER BY RAND()
                                LIMIT 8');
            $stmt->execute();
            if (!$stmt->rowCount()) return false;
            $data = $stmt->fetchAll();
            $db = null;
            return $data;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getAnnonce($annonceid)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM annonce WHERE annonceId = ?');
            $stmt->bindParam(1, $annonceid);
            $stmt->execute();
            // annonce data
            $annonceData = $stmt->fetch();

            // get annonce adresses
            $pointDepart = Adresse::getAdresse($annonceData['adresseDepart']);
            $pointArrive = Adresse::getAdresse($annonceData['adresseArrive']);

            // get the spécifications
            $poids = Poids::getPoids($annonceData['poids']);
            $moyenTransport = MoyenTransport::getMoyenTransport($annonceData['moyentransport']);
            $typeTransport = TypeTransport::getTypeTransport($annonceData['typeTransport']);

            $annonce = new Annonce($pointArrive, $pointDepart, $typeTransport, $moyenTransport, $poids, $annonceData['description']);
            $annonce->setAnnonceId($annonceData['annonceId']);
            $annonce->setCreatedAt($annonceData['created_at']);
            $annonce->setVerifer($annonceData['verifier']);
            $annonce->setPrix($annonceData['prix']);
            $annonce->setFinished($annonceData['finished']);

            return $annonce;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAnnonceClientName()
    {
        if (!$this->annonceId) return false;
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT clientannonce.clientId,nom,prenom,phone FROM clientannonce
                                            JOIN
                                            client
                                            ON clientannonce.clientId = client.clientId
                                            WHERE annonceId = ?');
            $stmt->bindParam(1, $this->annonceId);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getClientAnnonces($clientId, $limit, $offset)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM clientannonce
                                        JOIN annonce ON annonce.annonceId = clientannonce.annonceId
                                        WHERE clientannonce.clientId = :id AND archive = 0
                                        ORDER BY created_at DESC
                                        LIMIT :limit OFFSET :offset');
            $stmt->bindParam(':id', $clientId, \PDO::PARAM_INT);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);

            $stmt->execute();

            $data = $stmt->fetchAll();

            $annonces = [];

            foreach ($data as $item) {
                // get annonce adresses
                $pointDepart = Adresse::getAdresse($item['adresseDepart']);
                $pointArrive = Adresse::getAdresse($item['adresseArrive']);

                // get the spécifications
                $poids = Poids::getPoids($item['poids']);
                $moyenTransport = MoyenTransport::getMoyenTransport($item['moyentransport']);
                $typeTransport = TypeTransport::getTypeTransport($item['typeTransport']);
                $annonce = new Annonce($pointArrive, $pointDepart, $typeTransport, $moyenTransport, $poids, $item['description'], $item['created_at']);
                $annonce->setAnnonceId($item['annonceId']);
                $annonce->setCreatedAt($item['created_at']);
                $annonce->setVerifer($item['verifier']);
                $annonce->setPrix($item['prix']);
                $annonce->setFinished($item['finished']);
                array_push($annonces, $annonce);
            }
            return $annonces;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function deleteAnnonce($annonceId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('UPDATE annonce SET annonce.archive = true WHERE annonce.annonceId = ?');
            $stmt->bindParam(1, $annonceId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function searchAnnonce($wilayaDepartId, $wilayaArriveId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM
                                                (SELECT annonce.finished,annonce.verifier,annonce.archive,annonce.annonceId,annonce.description,annonce.prix,adresse.wilayaId AS wilayaDepart
                                                FROM annonce
                                                JOIN adresse ON adresse.adresseId = annonce.adresseDepart) t1
                                                JOIN
                                                (SELECT annonce.annonceId,adresse.wilayaId AS wilayaArrive
                                                FROM annonce
                                                JOIN adresse ON adresse.adresseId = annonce.adresseArrive) t2
                                                ON t1.annonceId = t2.annonceId
                                                WHERE wilayaDepart = ? AND wilayaArrive = ? AND finished = false AND verifier = true AND archive = false');
            $stmt->bindParam(1, $wilayaDepartId);
            $stmt->bindParam(2, $wilayaArriveId);
            $stmt->execute();
            if (!$stmt->rowCount()) return [];
            $data = $stmt->fetchAll();
            $db = null;
            return $data;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getAnnonceFinished()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT annonceId FROM annonce WHERE finished = true');
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getAnnonceNumber()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT annonceId FROM annonce');
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
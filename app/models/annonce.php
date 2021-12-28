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
            $saved = $this->_saveAnnonceImage($this->annonceId, 'annonce', 'annonces');
            return $saved;
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
                        SELECT id1 AS annonceId, departWilaya, arriveWilaya,description FROM
                                (SELECT annonceId AS id1, description,wilayas.nom AS departWilaya 
                                    FROM annonce
                                    JOIN adresse
                                    ON adresse.adresseId = annonce.adresseDepart
                                    JOIN wilayas ON wilayas.id = wilayaId) t1
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
            return $annonce;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    private function _saveAnnonceImage($annonceId, $filePrefix, $path)
    {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileAcctualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($fileAcctualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $fileNewName = $filePrefix . '_' . $annonceId . '.' . $fileAcctualExt;
                    $fileDestination = PUBLIC_FOLDER . DS . 'uploads' . DS . $path . DS . $fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    unset($_FILES);
                    return true;
                } else {
                    $_SESSION['errorMessage'] = 'Votre fichier est trop large.';
                    return false;
                }
            } else {
                $_SESSION['errorMessage'] = 'Il y a un error lors le telechargement de votre fichier';
                return false;
            }
        } else {
            $_SESSION['errorMessage'] = 'On accepte pas ce type de ficher.';
            return false;
        }
    }

    public function getAnnonceClientName() {
        if(!$this->annonceId) return false;
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
}
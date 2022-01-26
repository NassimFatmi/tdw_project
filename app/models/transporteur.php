<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;
use TDW\LIB\File;

class Transporteur extends AbstractModel
{
    use File;

    private $certifier;
    private $trajets;
    private $stars;
    private $count;

    public function __construct($nom, $prenom, $email, $phone, $adresse)
    {
        parent::__construct($nom, $prenom, $email, $phone, $adresse);
    }

    public function setCertifier($certifier)
    {
        $this->certifier = $certifier;
    }

    public function isCertifier()
    {
        return $this->certifier;
    }

    public function setTrajets($trajets)
    {
        $this->trajets = $trajets;
    }

    public function setStars($stars, $count)
    {
        $this->stars = $stars;
        $this->count = $count;
    }

    public function getStarsRatio()
    {
        return $this->stars / $this->count;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function register($password)
    {
        try {
            if (!$this->adresse->saveAdresse()) {
                return false;
            }

            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO transporteur (nom, prenom, email,password,phone,adresseId) VALUES (?,?,?,?,?,?)');

            $stmt->bindParam(1, $this->nom);
            $stmt->bindParam(2, $this->prenom);
            $stmt->bindParam(3, $this->email);
            $stmt->bindParam(4, $password);
            $stmt->bindParam(5, $this->phone);
            $stmt->bindParam(6, $this->adresse->getAdresseId());

            $result = $stmt->execute();
            if (!$result) return false;
            $userId = $db->lastInsertId();
            $this->setId($userId);

            foreach ($this->trajets as $trajet) {
                $trajet->setTransporteurId($this->id);
                $trajet->saveTrajet();
            }

            return $this->_saveImage($this->id, 'transporteur', 'profiles' . DS . 'transporteurs');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function exists($email)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT transporteur FROM client WHERE email = ?');
            $stmt->bindParam(1, $email);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function login($email, $password)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT transporteurId,nom,prenom,email,phone,adresseId,certifier,stars,count FROM transporteur WHERE email = ? AND password = ?');
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);

            $stmt->execute();

            if ($stmt->rowCount()) {
                $data = $stmt->fetch();
                // get user adresse
                $userAdresse = Adresse::getAdresse($data['adresseId']);
                $transporteur = new Transporteur($data["nom"], $data["prenom"], $data["email"], $data["phone"], $userAdresse);
                $transporteur->setCertifier($data["certifier"]);
                $transporteur->setId($data["transporteurId"]);
                $transporteur->setStars($data["stars"], $data["count"]);
                // recuperation des trajets
                $trajetStmt = $db->prepare('SELECT * FROM trajet WHERE transporteurId = ?');
                $trajetStmt->bindParam(1, $data["transporteurId"]);
                $trajetStmt->execute();

                $trajetsData = $trajetStmt->fetchAll();

                $trajets = [];
                foreach ($trajetsData as $trajetData) {
                    $trajet = new Trajet();
                    $trajet->setWilayaId($trajetData['wilayaId']);
                    array_push($trajets, $trajet);
                }
                $transporteur->setTrajets($trajets);
                return $transporteur;
            } else {
                return false;
            }

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function postuler($annonceId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO transporteurdemande (transporteurId,annonceId) VALUES (?,?)');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $annonceId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isPostuled($annonceId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM transporteurdemande WHERE transporteurId = ? AND annonceId = ?');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $annonceId);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getDemandes()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT annonce.annonceId,annonce.description,transporteurdemande.done,transporteurdemande.refuser FROM transporteurdemande
                                        JOIN annonce ON transporteurdemande.annonceId = annonce.annonceId
                                        WHERE transporteurId = ?');
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTrajets()
    {
        return $this->trajets;
    }

    public static function getTranspoteursByTrajets($wilayaDepart, $wilayaArrive)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT transporteurId FROM 
                                        (SELECT transporteurId FROM trajet WHERE trajet.wilayaId = ?) t1
                                        JOIN
                                        (SELECT transporteurId AS tId FROM trajet WHERE trajet.wilayaId = ?) t2
                                        ON t1.transporteurId = t2.tId');
            $stmt->bindParam(1, $wilayaDepart);
            $stmt->bindParam(2, $wilayaArrive);
            $stmt->execute();
            if ($stmt->rowCount()) {
                $data = $stmt->fetchAll();
                $ids = [];
                foreach ($data as $id) {
                    array_push($ids, $id[0]);
                }
                $sqlArray = '(' . implode(',', $ids) . ')';
                $getTransporteursStmt = $db->prepare('SELECT transporteurId,nom,prenom,phone,certifier,stars,count FROM transporteur WHERE transporteurId IN ' . $sqlArray);
                $getTransporteursStmt->execute();
                return $getTransporteursStmt->fetchAll();
            } else return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getNotifications()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT clientdemande.id,clientdemande.done,clientdemande.refuser, clientannonce.clientId,nom,prenom,phone,prix,annonce.annonceId,annonce.description FROM clientdemande
                                        JOIN clientannonce ON clientannonce.annonceId = clientdemande.annonceId
                                        JOIN client ON client.clientId = clientannonce.clientId
                                        JOIN annonce ON annonce.annonceId = clientdemande.annonceId
                                        WHERE transporteurId = ?');
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function accepteDemande($annonceId, $demandeId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();

            $stmtUpdateDemande = $db->prepare('UPDATE clientdemande SET done = true WHERE id = ?');
            $stmtUpdateDemande->bindParam(1, $demandeId);

            $stmtUpdateAnnonce = $db->prepare('UPDATE annonce SET finished = true WHERE annonceId = ?');
            $stmtUpdateAnnonce->bindParam(1, $annonceId);

            $deleteOtherDemandes = $db->prepare('UPDATE transporteurdemande SET refuser = true WHERE annonceId = ? AND done = 0');
            $deleteOtherDemandes->bindParam(1, $annonceId);

            return $stmtUpdateDemande->execute() && $stmtUpdateAnnonce->execute() && $deleteOtherDemandes->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function refuseDemande($annonceId, $demandeId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();

            $stmt = $db->prepare('UPDATE clientdemande SET refuser = true WHERE annonceId = ? AND id = ?');
            $stmt->bindParam(1, $annonceId);
            $stmt->bindParam(2, $demandeId);

            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getNumberOfTransporteurs()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT transporteurId FROM transporteur');
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTransactions()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT prix,clientdemande.created_at FROM clientdemande 
                                        JOIN annonce ON clientdemande.annonceId = annonce.annonceId
                                        WHERE clientdemande.transporteurId = ? AND clientdemande.done = true
                                        UNION
                                        SELECT prix,transporteurdemande.created_at FROM transporteurdemande
                                        JOIN annonce ON transporteurdemande.annonceId = annonce.annonceId
                                        WHERE transporteurdemande.transporteurId = ? AND transporteurdemande.done = true');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $this->id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function demanderVerification($title, $description)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO verficationdemandes (transporteurId,title,description) VALUES (?,?,?)');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $title);
            $stmt->bindParam(3, $description);
            if ($stmt->execute()) {
                $id = $db->lastInsertId();
                return $this->_saveImage($id, 'certifcat', 'certifications');
            } else return false;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
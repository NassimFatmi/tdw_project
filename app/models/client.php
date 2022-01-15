<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;
use TDW\LIB\File;

class Client extends AbstractModel
{
    use File;

    public function __construct($nom, $prenom, $email, $phone, $adresse)
    {
        parent::__construct($nom, $prenom, $email, $phone, $adresse);
    }

    public function register($password)
    {
        try {
            // save the adresse of the user
            if (!$this->adresse->saveAdresse()) {
                return false;
            }
            // save the user to the database
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO client (nom, prenom, email,password,phone,adresseId) VALUES (?,?,?,?,?,?)');

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
            return $this->_saveImage($this->id, 'client', 'profiles' . DS . 'clients');
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
            $stmt = $db->prepare('SELECT email FROM client WHERE email = ?');
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
            $stmt = $db->prepare('SELECT clientId,nom,prenom,email,phone,adresseId FROM client WHERE email = ? AND password = ?');
            $stmt->bindParam(1, $email);
            $stmt->bindParam(2, $password);

            $stmt->execute();
            if ($stmt->rowCount()) {
                $data = $stmt->fetch();
                // get user adresse
                $userAdresse = Adresse::getAdresse($data['adresseId']);
                $client = new Client($data["nom"], $data["prenom"], $data["email"], $data["phone"], $userAdresse);
                $client->setId($data["clientId"]);
                return $client;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function saveClientAnnonce($annonce)
    {
        if (!$annonce->saveAnnonce()) return false;
        if (!$this->_saveLinkAnnonceClient($annonce->getAnnonceId())) return false;
        return true;
    }

    private function _saveLinkAnnonceClient($annonceId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO clientannonce (clientId, annonceId) VALUES (?,?)');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $annonceId);
            return $stmt->execute();
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
            $stmt = $db->prepare('SELECT transporteurdemande.id,transporteurdemande.refuser, clientannonce.annonceId,transporteurdemande.transporteurId,transporteurdemande.done,transporteur.nom,transporteur.prenom,annonce.description
                                        FROM clientannonce
                                        JOIN transporteurdemande ON clientannonce.annonceId = transporteurdemande.annonceId
                                        JOIN transporteur ON transporteurdemande.transporteurId = transporteur.transporteurId
                                        JOIN annonce ON annonce.annonceId = transporteurdemande.annonceId
                                        WHERE clientannonce.clientId = ?');
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

            $stmtUpdateDemande = $db->prepare('UPDATE transporteurdemande SET done = true WHERE id = ?');
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

            $stmt = $db->prepare('UPDATE transporteurdemande SET refuser = true WHERE annonceId = ? AND id = ?');
            $stmt->bindParam(1, $annonceId);
            $stmt->bindParam(2, $demandeId);

            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isTheOwner($annonceId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();

            $stmt = $db->prepare('SELECT * FROM clientannonce WHERE clientId = ? AND annonceId = ?');
            $stmt->bindParam(1, $this->id);
            $stmt->bindParam(2, $annonceId);

            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function demanderTransport($annonceId, $transporteurId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();

            $stmt = $db->prepare('INSERT INTO clientdemande (annonceId,transporteurId) VALUES (?,?)');
            $stmt->bindParam(1, $annonceId);
            $stmt->bindParam(2, $transporteurId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isDemander($annonceId, $transporteurId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM clientdemande WHERE annonceId = ? AND transporteurId = ?');
            $stmt->bindParam(1, $annonceId);
            $stmt->bindParam(2, $transporteurId);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getNumberOfclients()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT clientId FROM client');
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
            $stmt = $db->prepare('SELECT clientannonce.annonceId, prix,created_at FROM clientannonce
                                        JOIN annonce ON annonce.annonceId = clientannonce.annonceId 
                                        WHERE clientannonce.clientId = ? AND finished = true');
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function rateTransporteur($demandeId, $starsCount)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT transporteurId FROM transporteurdemande WHERE id = ?');
            $stmt->bindParam(1, $demandeId);
            $stmt->execute();
            $data = $stmt->fetch();
            $transporteurId = $data['transporteurId'];

            $transporteur = $db->prepare("SELECT stars, count FROM transporteur WHERE transporteurId = ?");
            $transporteur->bindParam(1, $transporteurId);
            $transporteur->execute();
            $transporteurData = $transporteur->fetch();

            $newStars = $transporteurData['stars'] + $starsCount;
            $newCount = $transporteurData['count'] + 1;

            $starsStmt = $db->prepare('UPDATE transporteur SET stars = ? , count = ? WHERE transporteurId = ?');
            $starsStmt->bindParam(1, $newStars);
            $starsStmt->bindParam(2, $newCount);
            $starsStmt->bindParam(3, $transporteurId);
            return $starsStmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
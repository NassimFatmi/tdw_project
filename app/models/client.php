<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Client extends AbstractModel
{
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
            return true;
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
}
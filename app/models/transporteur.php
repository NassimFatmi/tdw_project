<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Transporteur extends AbstractModel
{
    private $certifier;
    private $trajets;

    public function __construct($nom, $prenom, $email, $phone, $adresse)
    {
        parent::__construct($nom, $prenom, $email, $phone, $adresse);
    }

    public function setCertifier($certifier)
    {
        $this->certifier = $certifier;
    }

    public function setTrajets($trajets)
    {
        $this->trajets = $trajets;
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
            $stmt = $db->prepare('SELECT transporteurId,nom,prenom,email,phone,adresseId,certifier FROM transporteur WHERE email = ? AND password = ?');
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
                return $transporteur;
            } else {
                return false;
            }

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function saveTrajets()
    {

    }
}
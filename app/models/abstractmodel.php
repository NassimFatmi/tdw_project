<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;
use TDW\LIB\File;

abstract class AbstractModel
{
    protected $id;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $phone;
    protected $adresse;

    protected function __construct($nom, $prenom, $email, $phone, $adress)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->phone = $phone;
        $this->adresse = $adress;
    }

    protected function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->nom;
    }

    public function getLastName()
    {
        return $this->prenom;
    }

    public function getFullName()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    public function getAdresseText()
    {
        return $this->adresse->getFullAdresse();
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function contactAdmin($email,$objet, $message)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO reports (email,objet,message) VALUES (?,?,?)');
            $stmt->bindParam(1,$email);
            $stmt->bindParam(2,$objet);
            $stmt->bindParam(3,$message);
            return  $stmt->execute();
        }catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    abstract public function register($password);

    abstract public function exists($email);

    abstract public function getNotifications();

    abstract public function accepteDemande($annonceId, $demandeId);

    abstract public function refuseDemande($annonceId, $demandeId);

    abstract public function getTransactions();
}
<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

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

    public function getFullName()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    public function getAdresseText()
    {
        return $this->adresse->getFullAdresse();
    }

    abstract public function register($password);

    abstract public function exists($email);

}
<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Signal
{
    private $signalId;
    private $client;
    private $transporteur;
    private $objet;
    private $message;

    public function __construct($signalId, $client, $transporteur, $objet, $message)
    {
        $this->signalId = $signalId;
        $this->transporteur = $transporteur;
        $this->client = $client;
        $this->objet = $objet;
        $this->message = $message;
    }

    public function getSignalId()
    {
        return $this->signalId;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getObjet()
    {
        return $this->objet;
    }

    public function getTransporteur()
    {
        return $this->transporteur;
    }

    public static function getSignal($id)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT
                                        signalId, client.nom AS clientNom,
                                        client.prenom AS clientPrenom,
                                        transporteur.nom AS transporteurNom,
                                        transporteur.prenom AS transporteurPrenom,
                                        objet,
                                        message
                                        FROM signals
                                        JOIN client ON client.clientId = signals.clientId
                                        JOIN transporteur ON transporteur.transporteurId = signals.transporteurId
                                        WHERE signalId = ?');
            $stmt->bindParam(1, $id);

            if (!$stmt->execute()) {
                return false;
            }
            $data = $stmt->fetch();
            $client = $data["clientNom"] . ' ' . $data["clientPrenom"];
            $transporteur = $data["transporteurNom"] . ' ' . $data["transporteurPrenom"];
            return new Signal($data["signalId"], $client, $transporteur, $data["objet"], $data["message"]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
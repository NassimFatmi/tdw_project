<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class TypeTransport
{
    private $id;
    private $type;

    public function getTypeId()
    {
        return $this->id;
    }

    public function getTypeName()
    {
        return $this->type;
    }

    public function __construct($id, $type)
    {
        $this->type = $type;
        $this->id = $id;
    }

    public static function getAllTypesTransport()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM typetransport');
            $stmt->execute();
            $result = $stmt->execute();

            if (!$result || !$stmt->rowCount()) return false;

            $data = $stmt->fetchAll();
            $types = [];
            foreach ($data as $type) {
                array_push($types, new TypeTransport($type['id'], $type['type']));
            }
            return $types;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
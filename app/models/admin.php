<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;
use TDW\LIB\File;

class Admin
{
    use File;

    private $adminId;

    public function __construct($adminId)
    {
        $this->adminId = $adminId;
    }

    public static function login($adminName, $password)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT adminId FROM admin WHERE adminName = ? AND password = ?');
            $stmt->bindParam(1, $adminName);
            $stmt->bindParam(2, $password);

            $stmt->execute();
            if ($stmt->rowCount()) {
                $data = $stmt->fetch();
                return new Admin($data['adminId']);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getAllAnnonces($limit, $offset, $filters)
    {
        $query = 'SELECT * FROM annonce JOIN clientannonce ON annonce . annonceId = clientannonce . annonceId';

        if (isset($filters["verifier"]) || isset($filters["finished"]) || isset($filters["archive"])) {
            $query .= ' WHERE ';
            $count = 0;
            if (isset($filters["verifier"])) {
                $query .= ' verifier = true ';
                $count++;
            }
            if (isset($filters["finished"])) {
                if ($count) {
                    $query .= ' AND ';
                }
                $query .= ' finished = true ';
                $count++;
            }
            if (isset($filters["archive"])) {
                if ($count) {
                    $query .= ' AND ';
                }
                $query .= ' archive = true ';
            }
        }

        try {
            $query .= ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare($query);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount()) {
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function verifyAnnonce($annonceId, $prix)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('UPDATE annonce SET verifier = true, prix = ? WHERE annonceId = ?');
            $stmt->bindParam(1, $prix);
            $stmt->bindParam(2, $annonceId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function archiveAnnonce($annonceId)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('UPDATE annonce SET archive = true WHERE annonceId = ?');
            $stmt->bindParam(1, $annonceId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getClients($limit, $offset)
    {
        try {
            $query = 'SELECT * FROM client LIMIT :limit OFFSET :offset';
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare($query);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount()) {
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTransporteurs($limit, $offset)
    {
        try {
            $query = 'SELECT * FROM transporteur LIMIT :limit OFFSET :offset';
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare($query);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount()) {
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getNews($limit, $offset)
    {
        try {
            $query = 'SELECT * FROM news LIMIT :limit OFFSET :offset';
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare($query);
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount()) {
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteNews($newsId)
    {
        try {
            $query = 'DELETE FROM news WHERE newsId = ?';
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $newsId);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function createNews($title, $summary, $article)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('INSERT INTO news (title, summary, article) VALUES (?,?,?)');

            $stmt->bindParam(1, $title);
            $stmt->bindParam(2, $summary);
            $stmt->bindParam(3, $article);

            $result = $stmt->execute();
            if (!$result) return false;
            $id = $db->lastInsertId();
            return $this->_saveImage($id, 'news', 'news');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getSignals()
    {
        try {
            $query = 'SELECT * FROM signals';
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount()) {
                return $stmt->fetchAll();
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
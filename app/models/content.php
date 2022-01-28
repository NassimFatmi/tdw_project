<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class Content
{
    private $contentId;
    private $title;
    private $content;
    private $video;
    private $image;

    public function getContentId()
    {
        return $this->contentId;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function __construct($contentId, $title, $content, $video, $image)
    {
        $this->contentId = $contentId;
        $this->title = $title;
        $this->content = $content;
        $this->video = $video;
        $this->image = $image;
    }

    public static function getPresentationContent()
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM presentation');
            $stmt->execute();
            $data = $stmt->fetchAll();
            $sections = [];
            foreach ($data as $section) {
                array_push($sections, new Content($section["id"], $section["sectionTitle"], $section["sectionBody"], $section["videoLink"], $section["imageLink"]));
            }
            return $sections;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getContentById($id)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM presentation WHERE id = ?');
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $section = $stmt->fetch();
            return new Content($section["id"], $section["sectionTitle"], $section["sectionBody"], $section["videoLink"], $section["imageLink"]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function modifier($title, $body, $video, $image)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('UPDATE presentation
                                        SET sectionTitle = ? ,sectionBody = ?, videoLink = ?,imageLink = ?
                                        WHERE id = ?');
            $stmt->bindParam(5, $this->contentId);
            $stmt->bindParam(1, $title);
            $stmt->bindParam(2, $body);
            $stmt->bindParam(3, $video);
            $stmt->bindParam(4, $image);
            return $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
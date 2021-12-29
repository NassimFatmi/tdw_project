<?php

namespace TDW\Models;

use TDW\LIB\Database\Database;

class News
{
    private $newsId;
    private $title;
    private $summary;
    private $article;
    private $createdAt;

    public function __construct($id, $title, $summary, $createdAt)
    {
        $this->newsId = $id;
        $this->title = $title;
        $this->summary = $summary;
        $this->createdAt = $createdAt;
    }

    public function setArticle($article)
    {
        $this->article = $article;
    }

    public function getNewsId()
    {
        return $this->newsId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function getArticle()
    {
        return $this->article;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public static function getNews($limit, $startFrom)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT newsId,title,summary,created_at FROM news ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
            $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
            $stmt->bindParam(':offset', $startFrom, \PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->rowCount()) return [];

            $data = $stmt->fetchAll();
            $newsList = [];
            foreach ($data as $news) {
                array_push($newsList, new News($news['newsId'], $news['title'], $news['summary'], $news['created_at']));
            }
            return $newsList;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getNewsDetails($id)
    {
        try {
            $conn = new Database();
            $db = $conn->connect();
            $stmt = $db->prepare('SELECT * FROM news WHERE newsId = ?');
            $stmt->bindParam(1, $id, \PDO::PARAM_INT);
            $stmt->execute();

            if (!$stmt->rowCount()) return false;

            $data = $stmt->fetch();
            $news = new News($data['newsId'], $data['title'], $data['summary'], $data['created_at']);
            $news->setArticle($data['article']);
            return $news;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
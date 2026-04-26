<?php
namespace Database;

use PDO;

class Category extends BaseSql
{
    public int $id;
    public string $title;
    public string $description;
    public string $created_at;
    public string $updated_at;
    public array $articles;

    private static int $page = 1;
    private int $perPage = 5;
    private static string $sort = '';
    private static string $date = '';

    public static function getCategories() : array
    {
        $sql = "SELECT * FROM category ";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    
    public static function getCategoryById(int $id) : self
    {
        $sql = "SELECT * FROM category WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject(self::class);
    }

    public function getArticles() : array
    {
        if (!$this->id) {
            throw new \Exception("Category ID is not set.");
        }

        $sql = "SELECT a.* FROM article a 
                JOIN article_category ac ON a.id = ac.article_id 
                WHERE ac.category_id = :category_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':category_id' => $this->id]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    public function laststArticles(int $limit = 3) : array
    {
        if (!$this->id) {
            throw new \Exception("Category ID is not set.");
        }

        $sql = "SELECT a.* FROM article a 
                JOIN article_category ac ON a.id = ac.article_id 
                WHERE ac.category_id = :category_id 
                ORDER BY a.published_at DESC 
                LIMIT :limit";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':category_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Article::class);
    }

    public function paginationArticles() : array
    {
        if (!$this->id) {
            throw new \Exception("Category ID is not set.");
        }

        $offset = (self::$page - 1) * $this->perPage;
        $sql = "SELECT a.* FROM article a 
                JOIN article_category ac ON a.id = ac.article_id 
                WHERE ac.category_id = :category_id" . " "
                . (self::$date ? "AND a.published_at >= :start AND a.published_at <= :end" : '') . " "
                . (self::$sort ? "ORDER BY a.counter_show " . self::$sort :
                 "ORDER BY a.published_at  DESC" ) . "
                LIMIT :limit OFFSET :offset";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':category_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $this->perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        if (self::$date) {
            $stmt->bindValue(':start',(new \DateTime(self::$date))->format('Y-m-d 00:00:00'), PDO::PARAM_STR);
            $stmt->bindValue(':end', (new \DateTime(self::$date))->format('Y-m-d 23:59:59'), PDO::PARAM_STR);
        }

        $stmt->execute();

        return [
            'items' => $stmt->fetchAll(PDO::FETCH_CLASS, Article::class),
            'page' => self::$page,
            'totalPages' => ceil($this->getTotalArticles() / $this->perPage),
            'sort' => self::$sort,
            'date' => self::$date
        ];
    }

    public static function setPage(int $page) : void
    {
       self::$page = $page;
    }

    private function getTotalArticles() : int
    {
        $sql = "SELECT COUNT(*) FROM article a 
                JOIN article_category ac ON a.id = ac.article_id 
                WHERE ac.category_id = :category_id" . " "
                . (self::$date ? "AND a.published_at >= :start AND a.published_at <= :end" : '');
        $stmt = self::$pdo->prepare($sql);
        
        $stmt->bindValue(':category_id', $this->id, PDO::PARAM_INT);
         if (self::$date) {
            $stmt->bindValue(':start',(new \DateTime(self::$date))->format('Y-m-d 00:00:00'), PDO::PARAM_STR);
            $stmt->bindValue(':end', (new \DateTime(self::$date))->format('Y-m-d 23:59:59'), PDO::PARAM_STR);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public static function setSort(string $sort) : void
    {
        self::$sort = $sort;
    }

    public static function setDate(string $date) : void
    {
        self::$date = $date;
    }
}
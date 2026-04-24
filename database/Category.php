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

    public static function getCategories()
    {
        $sql = "SELECT * FROM category ";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    
    public static function getCategoryById(int $id)
    {
        $sql = "SELECT * FROM category WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject(self::class);
    }

    public function getArticles()
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
}
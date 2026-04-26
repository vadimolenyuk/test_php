<?php
namespace Database;

class Article extends BaseSql
{
    public int $id;
    public string $title;
    public string $description;
    public string $image;
    public string $details;
    public array $categories;
    public int $counter_show;
    public string $created_at;  
    public string $updated_at;
    public string $published_at;

    public static function getArticles() : array
    {
        $sql = "SELECT * FROM article ";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function getArticleById(int $id) : self
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetchObject(self::class);
    }

    public function getCategories() : array
    {
        if (!$this->id) {
            throw new \Exception("Article ID is not set.");
        }

        $sql = "SELECT c.* FROM category c 
                JOIN article_category ac ON c.id = ac.category_id 
                WHERE ac.article_id = :article_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':article_id' => $this->id]);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Category::class);
    }

    public static function addViewCount(int $articleId) : void
    {
        $sql = "UPDATE article SET counter_show = counter_show + 1 WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([':id' => $articleId]);
    }
}
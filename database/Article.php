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

    public function getLinkArticle(int $limit = 3) 
    {
        $sql = "SELECT a.* FROM article a
                JOIN article_category ac ON ac.article_id = :id 
                JOIN article_category ac1 ON ac.category_id = ac1.category_id 
				Where ac1.article_id =  a.id and a.id != :id 
                ORDER BY a.published_at DESC
                LIMIT :limit";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Article::class);
    }
}
<?php
namespace Console;

use Database\BaseSql;

class Console
{
    const COUNT_DATA = 20;
    private $db;

    public function __construct()
    {
       $this->db = new BaseSql();
    }

    private function createCategorys()
    {
        $sql = "INSERT INTO category (title, description) VALUES (:title, :description)";
        $stmt = $this->db->pdo->prepare($sql);
        for($i = 0; $i < self::COUNT_DATA; $i++) {
            $stmt->execute([
                ':title' => "Category " . $i,
                ':description' => "This is a category " . $i
            ]);
        }
    }

    private function createArticles()
    {
        $sql = "INSERT INTO article (title, description, image, details) VALUES (:title, :description, :image, :details)";
        $stmt = $this->db->pdo->prepare($sql);
        for($i = 0; $i < self::COUNT_DATA; $i++) {
            $stmt->execute([
                ':title' => "Article " . $i,
                ':description' => "This is the content of article " . $i,
                ':image' => "image" . rand(1, 10) . ".jpg",
                ':details' => "Detailed content of article. " . $i
            ]);
        }
    }

    private function createArticleCategorys()
    {
        $sql = "INSERT INTO article_category (category_id, article_id) VALUES (:category_id, :article_id)";
        $stmt = $this->db->pdo->prepare($sql);
        for($i = 0; $i < self::COUNT_DATA; $i++) {
            $stmt->execute([
                ':category_id' => rand(1, self::COUNT_DATA),
                ':article_id' => rand(1, self::COUNT_DATA)
            ]);
        }
    }

    public function testData()
    {
        try {
            $this->db->pdo->beginTransaction();
            $this->createCategorys();
            $this->createArticles();
            $this->createArticleCategorys();
            $this->db->pdo->commit();
        } catch (\Exception $e) {
            $this->db->pdo->rollBack();
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    public function createTables()
    {
        $sql = file_get_contents(__DIR__ . '/../create_database.sql');     
        $this->db->pdo->exec($sql);
    }
}

require_once __DIR__ . '/../vendor/autoload.php'; 
if ($argc > 1) {
    $command = $argv[1];
    $console = new Console();

    switch ($command) {
        case 'createData':
            $console->testData();
            break;
        case 'createTables':
            $console->createTables();
            break;
        default:
            echo "Unknown command: $command\n";
    }
} else {
    echo "No command provided.\n";
}
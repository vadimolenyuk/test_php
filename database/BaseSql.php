<?php
namespace Database;

use PDO;

class BaseSql
{
    public PDO $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=db;port=3306;dbname=' . getenv('MYSQL_DATABASE'); 
        $username = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
        try {
            $this->pdo = new \Pdo($dsn, $username, $password);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }
}
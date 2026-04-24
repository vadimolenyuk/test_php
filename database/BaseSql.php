<?php
namespace Database;

use PDO;

class BaseSql
{
    protected static PDO $pdo;

    public static function connect()
    {
        if (!isset(self::$pdo)) {
            $dsn = 'mysql:host=db;port=3306;dbname=' . getenv('MYSQL_DATABASE'); 
            $username = getenv('MYSQL_USER');
            $password = getenv('MYSQL_PASSWORD');
            try {
                self::$pdo = new \Pdo($dsn, $username, $password);
            } catch (\PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                exit;
            }
        }
    }

}
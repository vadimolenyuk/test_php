<?php
namespace Console;

use Database\BaseSql;

class Console
{
    private $db;

    public function __construct()
    {
       $this->db = new BaseSql();
    }

    public function testData()
    {
  
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
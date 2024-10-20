<?php

namespace App\Core;
/**
 * Class Database
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 * @param array $config
 */

use PDO;

class Database
{
    public PDO $pdo;
    public function __construct(public array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations(): void
    {
       $this->createMigrationsTable();
       $appliedMigrations = $this->getAppliedMigrations();
        $newMigrations = [];
       $files = scandir(Application::$ROOT_DIR . '/src/Migrations');
       $toApplyMigrations = array_diff($files, $appliedMigrations);
       foreach($toApplyMigrations as $migration) {
           if($migration === '.' || $migration === '..') {
               continue;
           }
           require_once(Application::$ROOT_DIR . '/src/Migrations/' . $migration);
           $className = pathinfo($migration, PATHINFO_FILENAME);
           $instance = new $className();
           $this->log("Applyling migration $migration");
           $instance->up();
           $this->log("Applied migration $migration");
           $newMigrations[] = $migration;
       }
       if(!empty($newMigrations)) {
           $this->saveMigrations($newMigrations);
       }else {
           $this->log("All migrations applied");
       }
    }

    public function createMigrationsTable(): void
    {
      $this->pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255),
        create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE = InnoDB;
      ");
    }

    public function getAppliedMigrations(): false|array
    {
       $stmt = $this->pdo->prepare("SELECT migration FROM migrations;");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations): bool
    {
       $str = implode(",", array_map(fn($m)=>"('$m')", $migrations));
       $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES ($str);");
       return $stmt->execute();
    }

    protected function log($message): void
    {
        echo '['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
}
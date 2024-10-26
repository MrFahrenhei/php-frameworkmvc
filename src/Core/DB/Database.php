<?php

namespace App\Core\DB;
use App\Core\Application;
use PDO;
use PDOStatement;

/**
 * Class Database
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core\DB
 */

class Database
{
    public PDO $pdo;

    /**
     * @param array $config
     */
    public function __construct(public array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return void
     */
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
           $this->log("Applying migration $migration");
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

    /**
     * @return void
     */
    public function createMigrationsTable(): void
    {
      $this->pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255),
        create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE = InnoDB;
      ");
    }

    /**
     * @return false|array
     */
    public function getAppliedMigrations(): false|array
    {
       $stmt = $this->pdo->prepare("SELECT migration FROM migrations;");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @param array $migrations
     * @return bool
     */
    public function saveMigrations(array $migrations): bool
    {
       $str = implode(",", array_map(fn($m)=>"('$m')", $migrations));
       $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES ($str);");
       return $stmt->execute();
    }

    /**
     * @param string $message
     * @return void
     */
    protected function log(string $message): void
    {
        echo '['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
    }

    /**
     * @param string $sql
     * @return false|PDOStatement
     */
    public function prepare(string $sql): false|PDOStatement
    {
        return $this->pdo->prepare($sql);
    }
}
<?php

use App\Core\Application;

class m0001_initinal{
    public function up()
    {
        $db = Application::$app->db;
        $sql = '
                CREATE TABLE IF NOT EXISTS 
                `users` 
                (`id` int AUTO_INCREMENT PRIMARY KEY,
                `email` varchar(255) NOT NULL,
                firstname varchar(255) NOT NULL,
                lastname varchar(255) NOT NULL,
                status tinyint(1) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
                ENGINE=InnoDB 
                DEFAULT CHARSET=utf8;
        ';
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql = 'DROP TABLE `users`';
        $db->pdo->exec($sql);
    }
}
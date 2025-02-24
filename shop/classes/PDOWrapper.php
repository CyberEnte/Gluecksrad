<?php

namespace DC\Shop\shop\classes;

use PDO;

class PDOWrapper {

    private static ?self $instance = null;

    protected PDO $pdo;

    private function __construct()
    {
        $database = getenv("MYSQL_SCHEMA");
        $host = getenv("MYSQL_HOST");
        $user = getenv("MYSQL_USER");
        $password = getenv("MYSQL_PASSWORD");
        $this->pdo = new PDO("mysql:dbname=$database;host=$host", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
    }

    public static function getInstance(): self {
        if(self::$instance === null) self::$instance = new self();
        return self::$instance;
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }

    public function select(string $query, array $params = []): array {
        $preparedStatement = $this->pdo->prepare($query);
        $preparedStatement->execute($params);
        return $preparedStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $query, array $params = []): int|bool {
        $preparedStatement = $this->pdo->prepare($query);
        if ($preparedStatement->execute($params)) {
            return (int)$this->pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public function update(string $query, array $params = []): bool {
        $query = $this->pdo->prepare($query);
        return $query->execute($params);
    }

}
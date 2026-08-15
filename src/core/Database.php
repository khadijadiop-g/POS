<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $config = require __DIR__ . '/env.php';

        try {
            $dsn = "pgsql:host={$config['pgsql']['host']};port={$config['pgsql']['port']};dbname={$config['pgsql']['dbname']}";
            $this->pdo = new PDO($dsn, $config['pgsql']['user'], $config['pgsql']['password']);
        } catch (PDOException $e) {
            $this->pdo = new PDO('sqlite:' . $config['sqlite']['path']);
            $this->pdo->exec('PRAGMA foreign_keys = ON;');
        }

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnexion(): PDO
    {
        return $this->pdo;

    }


    public function query(string $sql, bool $single = true): array
    {
        $result = $this->pdo->query($sql);
        return $single ? $result->fetch() : $result->fetchAll();
    }

    public function prepare(string $sql, array $datas): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($datas);
        return $stmt;
    }

    public function executeQuery(string $sql, array $datas, bool $single = true): array
    {
        $stmt = $this->prepare($sql, $datas);
        return $single ? $stmt->fetch() : $stmt->fetchAll();
    }

    public function executeUpdate(string $sql, array $datas): int
    {
        $stmt = $this->prepare($sql, $datas);

        return str_starts_with(strtoupper($sql), 'INSERT')
            ? (int) $this->pdo->lastInsertId()
            : $stmt->rowCount();
    }

    private function __clone()
    {
    }
}

<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $config = require 'env.php';

        try {
            $dsn = "pgsql:host={$config['pgsql']['host']};port={$config['pgsql']['port']};dbname={$config['pgsql']['dbname']}";
            $this->pdo = new PDO($dsn, $config['pgsql']['user'], $config['pgsql']['password']);
            echo "Connexion à la base de données PostgreSQL réussie.";
        } catch (PDOException $e) {
            $this->pdo = new PDO('sqlite:' . $config['sqlite']['path']);
            $this->pdo->exec('PRAGMA foreign_keys = ON;');
            echo "Connexion à la base de données SQLite réussie.";
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

}
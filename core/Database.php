<?php

class Database
{
    private $DB_HOST = 'localhost';
    private $DB_PORT = '3306';
    private $DB_USER = '--';
    private $DB_PASS = '--';
    private $DB_NAME = '--';
    private $DB_CHARSET = 'utf8mb4';

    private $provider;
    private $stmt;
    private $errorDB;

    public function __construct()
    {
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
        try {
            $this->provider = new PDO('mysql:host=' . $this->DB_HOST . ';port=' . $this->DB_PORT . ';dbname=' . $this->DB_NAME . ';charset=' . $this->DB_CHARSET, $this->DB_USER, $this->DB_PASS, $options);
        } catch (PDOException $e) {
            $this->setErrorDB($e->getMessage() . $e->getCode());

            if (APP_MODE == 'debug') {
                echo $this->getErrorDB();
            } else {
                // Loggen

            }
        }
    }

    public function connectDB()
    {
        return $this->provider;
    }

    public function query($sql)
    {
        $this->stmt = $this->provider->prepare($sql);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function getErrorDB()
    {
        return $this->errorDB;
    }

    public function setErrorDB($errorDB): self
    {
        $this->errorDB = $errorDB;

        return $this;
    }
}

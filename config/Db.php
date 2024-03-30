<?php

class Db
{
    private $host;
    private $user;
    private $password;
    private $dbName;

    public function __construct($host="localhost", $user="root", $password="root", $dbName="meetic_db")
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    protected function connect()
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbName";
            $db = new PDO($dsn, $this->user, $this->password);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $db->exec("SET NAMES utf8");
            return $db;
        } catch (PDOException $e) {
            exit("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
}

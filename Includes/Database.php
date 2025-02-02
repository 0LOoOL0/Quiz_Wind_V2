<?php

class Database
{
    private $connection;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->connect($host, $username, $password, $dbname);
    }

    private function connect($host, $username, $password, $dbname)
    {
        try {
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
            $this->connection = new PDO($dsn, $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function beginTransaction() {
        return $this->connection->beginTransaction();
    }
    
    public function commit() {
        return $this->connection->commit();
    }
    
    public function rollBack() {
        return $this->connection->rollBack();
    }


    // testing connection, only for my use

    public function isConnected()
    {
        return $this->connection !== null;
    }

    public function queryStatement($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    //neccesery for user inputs
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }

    public function execute($stmt, $params = [])
    {
        try {
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            return false; // Handle error gracefully
        }
    }

    public function fetchAll($stmt)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchSingle($stmt)
    {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

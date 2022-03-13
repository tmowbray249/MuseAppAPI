<?php

class Database {

    private $dbConnection;

    public function __construct($dbName) {
        $this->setDbConnection($dbName);
    }

    private function setDbConnection($dbName) {
        $this->dbConnection = new PDO("sqlite:$dbName");
        $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function executeSQL($sql, $params = [], $return_ID=false)
    {
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);

        if ($return_ID) {
            return $this->dbConnection->lastInsertID();
        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

}
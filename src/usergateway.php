<?php

class UserGateway extends Gateway {

    public function __construct() {
        $this->setDatabase(DATABASE);
    }

    public function findPassword($username) {
        $sql = "SELECT id, password
                FROM user
                WHERE username = ?";
        $param = [$username];
        $result = $this->getDatabase()->executeSQL($sql, $param);
        $this->setResult($result);
    }

}
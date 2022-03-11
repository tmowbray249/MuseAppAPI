<?php

class UserGateway extends Gateway {

    public function __construct() {
        $this->setDatabase(DATABASE);
    }

    public function findPassword($username) {
        $sql = "SELECT user_id, password
                FROM users
                WHERE username = ?";
        $param = [$username];
        $result = $this->getDatabase()->executeSQL($sql, $param);
        $this->setResult($result);
    }

}
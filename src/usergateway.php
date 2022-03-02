<?php

class UserGateway extends Gateway {

    public function __construct() {
        $this->setDatabase(DATABASE_USER);
    }

    public function findPassword($email) {
        $sql = "SELECT id, password
                FROM user
                WHERE email = ?";
        $param = [$email];
        $result = $this->getDatabase()->executeSQL($sql, $param);
        $this->setResult($result);
    }

}
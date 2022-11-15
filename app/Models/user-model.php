<?php

class UserModel extends GeneralModel{

    function __construct() {
        parent::__construct();
    }

    function getUser($email) {
        $query = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $query->execute([$email]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}

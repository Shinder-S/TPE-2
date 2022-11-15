<?php

class GeneralModel{
    
    protected $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_stock;charset=utf8', 'root', '');
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}
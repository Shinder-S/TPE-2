<?php

require_once './app/Models/general-model.php';

class DrinkModel extends GeneralModel{

    public function __construct() {
        parent::__construct();
    }

    function getAll($column, $value, $orderBy, $cond, $limit, $offset) {
        $query = $this->db->prepare("SELECT * FROM drink WHERE $column = ? ORDER BY $orderBy $cond LIMIT ? OFFSET ?");
        $query->execute([$value, $limit, $offset]);

        $drinks = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $drinks;
    }

    function getQuantRegisters() {
        $query = $this->db->prepare("SELECT COUNT(*) FROM drink");
        $query->execute();

        return $query->fetchColumn();
    
    }

    function get($id) {
        $query = $this->db->prepare("SELECT * FROM Drink WHERE id_drink = ?");
        $query->execute([$id]);
        $drink = $query->fetch(PDO::FETCH_OBJ);
        
        return $drink;
    }

    function insert($name, $brand, $amount) {
        $query = $this->db->prepare("INSERT INTO drink (name, brand, amount) VALUES (?, ?, ?)");
        $query->execute([$name, $brand, $amount]);

        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM drink WHERE id_drink = ?');
        $query->execute([$id]);
    }

    function edit($name, $brand, $amount, $id) {
        $query = $this->db->prepare("UPDATE Drink SET name = ?,
                                                    brand = ?,
                                                    amount = ? 
                                            WHERE id_drink = ?");
        $query->execute([$name, $brand, $amount, $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
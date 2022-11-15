<?php

require_once './app/Models/general-model.php';

class AlcoholContentModel extends GeneralModel{

    function __construct() {
        parent::__construct();
    }

    function getAll($column, $value, $orderBy, $cond, $limit, $offset) {
        $query = $this->db->prepare("SELECT * FROM alcohol_content WHERE $column = ? ORDER BY $orderBy $cond LIMIT ? OFFSET ?");
        $query->execute([$value, $limit, $offset]);

        $alcoholContents = $query->fetchAll(PDO::FETCH_OBJ); 
        
        return $alcoholContents;
    }

    function getQuantRegisters() {
        $query = $this->db->prepare("SELECT COUNT(*) FROM alcohol_content");
        $query->execute();

        return $query->fetchColumn();
    
    }

    function get($id) {
        $query = $this->db->prepare("SELECT * FROM alcohol_content WHERE id_alcohol_content = ?");
        $query->execute([$id]);
        $alcoholContent = $query->fetch(PDO::FETCH_OBJ);
        
        return $alcoholContent;
    }

    function insert($name, $brand, $id_drink) {
        $query = $this->db->prepare("INSERT INTO alcohol_content (name, brand, id_drink) VALUES (?, ?, ?)");
        $query->execute([$name, $brand, $id_drink]);

        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM alcohol_content WHERE id_alcohol_content = ?');
        $query->execute([$id]);
    }

    function edit($name, $brand, $id_drink, $id) {
        $query = $this->db->prepare("UPDATE alcohol_content SET name = ?,
                                                    brand = ?,
                                                    id_drink = ? 
                                            WHERE id_alcohol_content = ?");
        $query->execute([$name, $brand, $id_drink, $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
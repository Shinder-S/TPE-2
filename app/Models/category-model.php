<?php

require_once './app/Models/general-model.php';

class CategoryModel extends GeneralModel{

    public function __construct() {
        parent::__construct();
    }
    
    public function getAll($column, $value, $orderBy, $cond, $limit, $offset) {
        $query = $this->db->prepare("SELECT * FROM category WHERE $column = ? ORDER BY $orderBy $cond LIMIT ? OFFSET ?");
        $query->execute([$value, $limit, $offset]);

        $species = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $species;
    }

    public function getQuantRegisters() {
        $query = $this->db->prepare("SELECT COUNT(*) FROM category");
        $query->execute();

        return $query->fetchColumn();
    
    }

    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM category WHERE id_category = ?");
        $query->execute([$id]);
        $specie = $query->fetch(PDO::FETCH_OBJ);
        
        return $specie;
    }

    public function insert($name, $amount, $photo, $id_alcohol_content) {
        $query = $this->db->prepare("INSERT INTO category (name, amount, photo, id_alcohol_content) VALUES (?, ?, ?, ?)");
        $query->execute([$name, $amount, $photo, $id_alcohol_content]);

        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM category WHERE id_category = ?');
        $query->execute([$id]);
    }

    public function edit($name, $amount, $photo, $id_alcohol_content, $id) {
        $query = $this->db->prepare("UPDATE category SET name = ?,
                                                    amount = ?,
                                                    photo = ?,
                                                    id_alcohol_content = ? 
                                            WHERE id_category = ?");
        $query->execute([$name, $amount, $photo, $id_alcohol_content, $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

}
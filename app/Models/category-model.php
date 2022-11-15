<?php

require_once './app/Models/general-model.php';

class CategoryModel extends GeneralModel{

    public function __construct() {
        parent::__construct();
    }
    
    public function getAll($column, $value, $orderBy, $cond, $limit, $offset) {
        $query = $this->db->prepare("SELECT * FROM specie WHERE $column = ? ORDER BY $orderBy $cond LIMIT ? OFFSET ?");
        $query->execute([$value, $limit, $offset]);

        $species = $query->fetchAll(PDO::FETCH_OBJ);
        
        return $species;
    }

    public function getQuantRegisters() {
        $query = $this->db->prepare("SELECT COUNT(*) FROM specie");
        $query->execute();

        return $query->fetchColumn();
    
    }

    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM specie WHERE id_specie = ?");
        $query->execute([$id]);
        $specie = $query->fetch(PDO::FETCH_OBJ);
        
        return $specie;
    }

    public function insert($scientific_name, $author, $location, $id_subclass) {
        $query = $this->db->prepare("INSERT INTO specie (scientific_name, author, location, id_subclass) VALUES (?, ?, ?, ?)");
        $query->execute([$scientific_name, $author, $location, $id_subclass]);

        return $this->db->lastInsertId();
    }

    function delete($id) {
        $query = $this->db->prepare('DELETE FROM specie WHERE id_specie = ?');
        $query->execute([$id]);
    }

    public function edit($scientific_name, $author, $location, $id_subclass, $id) {
        $query = $this->db->prepare("UPDATE specie SET scientific_name=?,
                                                    author=?,
                                                    location=?,
                                                    id_subclass=? 
                                            WHERE id_specie=?");
        $query->execute([$scientific_name, $author, $location, $id_subclass, $id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }

}
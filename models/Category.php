<?php
// models/Category.php

class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Leer todas las categorías
    public function read() {
        $query = "SELECT id, name, description FROM " . $this->table_name . " ORDER BY name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Crear una nueva categoría
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name = :name, description = :description";
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        // Vincular valores
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Leer una categoría
    public function readOne() {
        $query = "SELECT id, name, description FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            return true;
        }
        
        return false;
    }
}
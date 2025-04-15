<?php
// models/Product.php

class Product {
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $image;
    public $category_id;
    public $category_name;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo producto
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET name = :name, 
                      description = :description, 
                      price = :price, 
                      image = :image, 
                      category_id = :category_id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Vincular valores
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":category_id", $this->category_id);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Leer todos los productos
    public function read() {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, p.category_id, c.name as category_name, p.created_at
                  FROM " . $this->table_name . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
    
    // Leer un solo producto
    public function readOne() {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, p.category_id, c.name as category_name, p.created_at
                  FROM " . $this->table_name . " p
                  LEFT JOIN categories c ON p.category_id = c.id
                  WHERE p.id = :id
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->image = $row['image'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
            $this->created_at = $row['created_at'];
            return true;
        }
        
        return false;
    }

    // Actualizar producto
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET name = :name, 
                      description = :description, 
                      price = :price, 
                      image = :image, 
                      category_id = :category_id
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular valores
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":id", $this->id);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar producto
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Sanitizar id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Vincular id
        $stmt->bindParam(":id", $this->id);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
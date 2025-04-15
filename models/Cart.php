<?php
// models/Cart.php

class Cart {
    private $conn;
    private $table_name = "cart_items";

    public $id;
    public $user_id;
    public $product_id;
    public $quantity;
    public $created_at;

    // Propiedades adicionales para información del producto
    public $product_name;
    public $product_price;
    public $product_image;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Agregar producto al carrito
    public function addItem() {
        // Primero verificar si el producto ya está en el carrito
        $query = "SELECT id, quantity FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND product_id = :product_id";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // El producto ya está en el carrito, actualizar cantidad
            $this->id = $row['id'];
            $this->quantity = $row['quantity'] + 1;
            return $this->updateQuantity();
        } else {
            // El producto no está en el carrito, agregar nuevo
            $query = "INSERT INTO " . $this->table_name . " 
                      SET user_id = :user_id, 
                          product_id = :product_id, 
                          quantity = :quantity";
    
            $stmt = $this->conn->prepare($query);
    
            // Sanitizar datos
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->product_id = htmlspecialchars(strip_tags($this->product_id));
            $this->quantity = 1;
    
            // Vincular valores
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":product_id", $this->product_id);
            $stmt->bindParam(":quantity", $this->quantity);
    
            // Ejecutar consulta
            if ($stmt->execute()) {
                return true;
            }
    
            return false;
        }
    }

    // Obtener todos los items del carrito de un usuario
    public function getUserCart() {
        $query = "SELECT c.id, c.user_id, c.product_id, c.quantity, c.created_at,
                  p.name as product_name, p.price as product_price, p.image as product_image
                  FROM " . $this->table_name . " c
                  LEFT JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = :user_id
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        return $stmt;
    }

    // Actualizar cantidad de un item
    public function updateQuantity() {
        $query = "UPDATE " . $this->table_name . " 
                  SET quantity = :quantity
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Vincular valores
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar item del carrito
    public function removeItem() {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Vincular valores
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Vaciar el carrito del usuario
    public function clearCart() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Obtener el total del carrito
    public function getCartTotal() {
        $query = "SELECT SUM(p.price * c.quantity) as total
                  FROM " . $this->table_name . " c
                  LEFT JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? $row['total'] : 0;
    }

    // Contar ítems en el carrito
    public function countItems() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] ? $row['count'] : 0;
    }
}
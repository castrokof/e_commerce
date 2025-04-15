<?php
// models/User.php

class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear un nuevo usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET username = :username, 
                      email = :email, 
                      password = :password, 
                      role = :role";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Vincular valores
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);

        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Verificar si el usuario existe y las credenciales son correctas
    public function login() {
        $query = "SELECT id, username, email, password, role FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :email";

        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Vincular valores
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);

        // Ejecutar consulta
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Verificar contraseña
            if (password_verify($this->password, $row['password'])) {
                // Asignar valores
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->role = $row['role'];
                
                return true;
            }
        }
        
        return false;
    }

    // Verificar si el nombre de usuario o email ya existe
    public function userExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username OR email = :email";

        $stmt = $this->conn->prepare($query);

        // Sanitizar
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Vincular valores
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);

        // Ejecutar consulta
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Obtener usuario por ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->role = $row['role'];
            $this->created_at = $row['created_at'];
            return true;
        }
        
        return false;
    }
}
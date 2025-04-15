<?php
// controllers/ProductController.php

require_once 'models/Product.php';
require_once 'models/Category.php';

class ProductController {
    private $db;
    private $product;
    private $category;

    public function __construct($db) {
        $this->db = $db;
        $this->product = new Product($db);
        $this->category = new Category($db);
    }

    public function index() {
        // Verificar si el usuario está autenticado
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        // Obtener todos los productos
        $stmt = $this->product->read();

        // Incluir la vista
        include 'views/products/list.php';
    }

    public function create() {
        // Verificar si el usuario está autenticado y es administrador
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=home');
            exit;
        }

        // Si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos
            $this->product->name = isset($_POST['name']) ? $_POST['name'] : '';
            $this->product->description = isset($_POST['description']) ? $_POST['description'] : '';
            $this->product->price = isset($_POST['price']) ? $_POST['price'] : 0;
            $this->product->category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

            // Manejo de la imagen
            $this->product->image = 'default.jpg'; // Imagen predeterminada
            
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $this->product->image = $filename;
                }
            }

            // Validación básica
            if (empty($this->product->name) || empty($this->product->price)) {
                $errorMsg = "El nombre y el precio son obligatorios";
                $categories = $this->category->read();
                include 'views/products/add.php';
                return;
            }

            // Crear producto
            if ($this->product->create()) {
                // Redirigir a la lista de productos
                header('Location: index.php?action=products&created=1');
                exit;
            } else {
                $errorMsg = "No se pudo crear el producto";
                $categories = $this->category->read();
                include 'views/products/add.php';
            }
        } else {
            // Obtener categorías para el formulario
            $categories = $this->category->read();
            
            // Mostrar formulario de creación
            include 'views/products/add.php';
        }
    }

    public function edit() {
        // Verificar si el usuario está autenticado y es administrador
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=home');
            exit;
        }

        // Obtener ID del producto
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?action=products');
            exit;
        }

        $this->product->id = $id;

        // Si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos
            $this->product->name = isset($_POST['name']) ? $_POST['name'] : '';
            $this->product->description = isset($_POST['description']) ? $_POST['description'] : '';
            $this->product->price = isset($_POST['price']) ? $_POST['price'] : 0;
            $this->product->category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;

            // Mantener la imagen actual si no se sube una nueva
            $this->product->readOne();
            $currentImage = $this->product->image;
            
            // Manejo de la imagen
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/images/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $filename = uniqid() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $this->product->image = $filename;
                }
            } else {
                $this->product->image = $currentImage;
            }

            // Validación básica
            if (empty($this->product->name) || empty($this->product->price)) {
                $errorMsg = "El nombre y el precio son obligatorios";
                $categories = $this->category->read();
                include 'views/products/edit.php';
                return;
            }

            // Actualizar producto
            if ($this->product->update()) {
                // Redirigir a la lista de productos
                header('Location: index.php?action=products&updated=1');
                exit;
            } else {
                $errorMsg = "No se pudo actualizar el producto";
                $categories = $this->category->read();
                include 'views/products/edit.php';
            }
        } else {
            // Obtener categorías para el formulario
            $categories = $this->category->read();
            
            // Obtener datos del producto
            if ($this->product->readOne()) {
                include 'views/products/edit.php';
            } else {
                header('Location: index.php?action=products');
                exit;
            }
        }
    }

    public function delete() {
        // Verificar si el usuario está autenticado y es administrador
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=home');
            exit;
        }

        // Obtener ID del producto
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?action=products');
            exit;
        }

        $this->product->id = $id;

        // Eliminar producto
        if ($this->product->delete()) {
            header('Location: index.php?action=products&deleted=1');
        } else {
            header('Location: index.php?action=products&deleted=0');
        }
        exit;
    }
}
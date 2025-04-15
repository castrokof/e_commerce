<?php
// index.php

// Incluir configuración de base de datos
require_once 'config/database.php';

// Incluir controladores
require_once 'controllers/UserController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CartController.php';

// Crear instancia de la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Determinar la acción a realizar
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// Enrutar la solicitud al controlador y método apropiados
switch ($action) {
    case 'register':
        $userController = new UserController($db);
        $userController->register();
        break;
        
    case 'login':
        $userController = new UserController($db);
        $userController->login();
        break;
        
    case 'logout':
        $userController = new UserController($db);
        $userController->logout();
        break;
        
    case 'home':
        // Verificar si el usuario está autenticado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        
        $productController = new ProductController($db);
        $productController->index();
        break;
        
    case 'products':
        $productController = new ProductController($db);
        $productController->index();
        break;
        
    case 'add_product':
        $productController = new ProductController($db);
        $productController->create();
        break;
        
    case 'edit_product':
        $productController = new ProductController($db);
        $productController->edit();
        break;
        
    case 'delete_product':
        $productController = new ProductController($db);
        $productController->delete();
        break;

    case 'cart':
        $cartController = new CartController($db);
        $cartController->viewCart();
        break;
        
    case 'add_to_cart':
        $cartController = new CartController($db);
        $cartController->addToCart();
        break;
        
    case 'update_quantity':
        $cartController = new CartController($db);
        $cartController->updateQuantity();
        break;
        
    case 'remove_from_cart':
        $cartController = new CartController($db);
        $cartController->removeFromCart();
        break;
        
    case 'clear_cart':
        $cartController = new CartController($db);
        $cartController->clearCart();
        break;    
        
    default:
        // Página no encontrada
        include 'views/404.php';
        break;
}
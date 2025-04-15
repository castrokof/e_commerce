<?php
// controllers/CartController.php

require_once 'models/Cart.php';

class CartController {
    private $db;
    private $cart;

    public function __construct($db) {
        $this->db = $db;
        $this->cart = new Cart($db);
    }

    // Mostrar el carrito
    public function viewCart() {
        // Verificar si el usuario está autenticado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $this->cart->user_id = $_SESSION['user_id'];
        
        // Obtener todos los ítems del carrito
        $items = $this->cart->getUserCart();
        
        // Obtener el total del carrito
        $total = $this->cart->getCartTotal();
        
        // Mostrar la vista del carrito
        include 'views/cart/view.php';
    }

    // Agregar producto al carrito
    public function addToCart() {
        // Verificar si el usuario está autenticado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        // Recibir ID del producto
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
        
        if (!$product_id) {
            header('Location: index.php?action=home');
            exit;
        }

        $this->cart->user_id = $_SESSION['user_id'];
        $this->cart->product_id = $product_id;
        
        // Agregar al carrito
        if ($this->cart->addItem()) {
            header('Location: index.php?action=cart&added=1');
        } else {
            header('Location: index.php?action=home&error=1');
        }
        exit;
    }

    // Actualizar cantidad de un ítem
    public function updateQuantity() {
        // Verificar si el usuario está autenticado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        // Recibir datos
        $item_id = isset($_POST['item_id']) ? $_POST['item_id'] : null;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
        
        if (!$item_id) {
            header('Location: index.php?action=cart');
            exit;
        }

        $this->cart->id = $item_id;
        $this->cart->user_id = $_SESSION['user_id'];
        $this->cart->quantity = $quantity;
        
        // Si la cantidad es 0, eliminar el ítem
        if ($quantity <= 0) {
            $this->cart->removeItem();
        } else {
            // Actualizar cantidad
            $this->cart->updateQuantity();
        }
        
        header('Location: index.php?action=cart&updated=1');
        exit;
    }

    // Eliminar ítem del carrito
    public function removeFromCart() {
        // Verificar si el usuario está autenticado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        // Recibir ID del ítem
        $item_id = isset($_GET['id']) ? $_GET['id'] : null;
        
        if (!$item_id) {
            header('Location: index.php?action=cart');
            exit;
        }

        $this->cart->id = $item_id;
        $this->cart->user_id = $_SESSION['user_id'];
        
        // Eliminar del carrito
        if ($this->cart->removeItem()) {
            header('Location: index.php?action=cart&removed=1');
        } else {
            header('Location: index.php?action=cart&error=1');
        }
        exit;
    }

    // Vaciar carrito
    public function clearCart() {
        // Verificar si el usuario está autenticado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $this->cart->user_id = $_SESSION['user_id'];
        
        // Vaciar carrito
        if ($this->cart->clearCart()) {
            header('Location: index.php?action=cart&cleared=1');
        } else {
            header('Location: index.php?action=cart&error=1');
        }
        exit;
    }
}
<?php
// controllers/UserController.php

require_once 'models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        $this->user = new User($db);
    }

    public function register() {
        // Si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos
            $this->user->username = isset($_POST['username']) ? $_POST['username'] : '';
            $this->user->email = isset($_POST['email']) ? $_POST['email'] : '';
            $this->user->password = isset($_POST['password']) ? $_POST['password'] : '';
            $this->user->role = 'cliente'; // Por defecto, los nuevos usuarios son clientes

            // Validación básica
            if (empty($this->user->username) || empty($this->user->email) || empty($this->user->password)) {
                $errorMsg = "Todos los campos son obligatorios";
                include 'views/users/register.php';
                return;
            }

            // Verificar si el usuario ya existe
            if ($this->user->userExists()) {
                $errorMsg = "El nombre de usuario o email ya está registrado";
                include 'views/users/register.php';
                return;
            }

            // Crear usuario
            if ($this->user->create()) {
                // Redirigir al login
                header('Location: index.php?action=login&registered=1');
                exit;
            } else {
                $errorMsg = "No se pudo crear la cuenta";
                include 'views/users/register.php';
            }
        } else {
            // Mostrar formulario de registro
            include 'views/users/register.php';
        }
    }

    public function login() {
        // Si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibir datos
            $this->user->username = isset($_POST['username']) ? $_POST['username'] : '';
            $this->user->email = isset($_POST['username']) ? $_POST['username'] : ''; // Permitir login con username o email
            $this->user->password = isset($_POST['password']) ? $_POST['password'] : '';

            // Validación básica
            if (empty($this->user->username) || empty($this->user->password)) {
                $errorMsg = "Todos los campos son obligatorios";
                include 'views/users/login.php';
                return;
            }

            // Verificar credenciales
            if ($this->user->login()) {
                // Iniciar sesión y guardar datos del usuario
                session_start();
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['role'] = $this->user->role;

                // Redirigir según rol
                header('Location: index.php?action=home');
                exit;
            } else {
                $errorMsg = "Credenciales incorrectas";
                include 'views/users/login.php';
            }
        } else {
            // Mostrar formulario de login
            $registered = isset($_GET['registered']) ? true : false;
            include 'views/users/login.php';
        }
    }

    public function logout() {
        // Iniciar sesión
        session_start();
        
        // Destruir todas las variables de sesión
        $_SESSION = array();
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir al login
        header('Location: index.php?action=login');
        exit;
    }
}
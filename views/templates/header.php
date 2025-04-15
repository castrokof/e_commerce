<?php
// views/templates/header.php
session_start();
// Obtener el contador de ítems en el carrito
$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    require_once 'models/Cart.php';
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    $cart = new Cart($db);
    $cart->user_id = $_SESSION['user_id'];
    $cartCount = $cart->countItems();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce - Sistema Web</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">E-commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=home">Productos</a>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=add_product">Agregar Producto</a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=cart">
                            <i class="fas fa-shopping-cart"></i> Carrito
                            <?php if ($cartCount > 0): ?>
                            <span class="badge bg-danger"><?php echo $cartCount; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">Hola, <?php echo $_SESSION['username']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=logout">Cerrar sesión</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=login">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=register">Registrarse</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
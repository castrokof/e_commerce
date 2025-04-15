<?php
// views/404.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - E-Commerce</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error-container {
            text-align: center;
            padding: 100px 20px;
        }
        .error-code {
            font-size: 8rem;
            color: #4a89dc;
            margin-bottom: 20px;
        }
        .error-message {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <div class="error-message">Página no encontrada</div>
            <p>Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
            <a href="index.php" class="btn primary">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
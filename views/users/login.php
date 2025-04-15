<?php
// views/users/login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - E-Commerce</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h1>Iniciar Sesión</h1>
            
            <?php if (isset($registered) && $registered): ?>
                <div class="alert success">
                    ¡Registro exitoso! Ahora puedes iniciar sesión.
                </div>
            <?php endif; ?>
            
            <?php if (isset($errorMsg)): ?>
                <div class="alert error">
                    <?php echo $errorMsg; ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?action=login" method="post">
                <div class="form-group">
                    <label for="username">Usuario o Email:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn primary">Iniciar Sesión</button>
                </div>
            </form>
            
            <p class="auth-link">¿No tienes una cuenta? <a href="index.php?action=register">Regístrate aquí</a></p>
        </div>
    </div>
</body>

<!--Usuario: admin
Email: admin@example.com
Contraseña: admin123-->
</html>
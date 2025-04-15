<?php
// views/users/register.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - E-Commerce</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h1>Crear Cuenta</h1>
            
            <?php if (isset($errorMsg)): ?>
                <div class="alert error">
                    <?php echo $errorMsg; ?>
                </div>
            <?php endif; ?>
            
            <form action="index.php?action=register" method="post">
                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn primary">Registrarse</button>
                </div>
            </form>
            
            <p class="auth-link">¿Ya tienes una cuenta? <a href="index.php?action=login">Inicia sesión aquí</a></p>
        </div>
    </div>
</body>
</html>
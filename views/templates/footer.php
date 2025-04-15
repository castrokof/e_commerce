<?php
// views/templates/footer.php
?>
<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <h5>E-commerce</h5>
                <p>Tu tienda en línea de confianza para todos tus productos favoritos.</p>
            </div>
            <div class="col-md-4">
                <h5>Enlaces rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php?action=home" class="text-white">Inicio</a></li>
                    <li><a href="index.php?action=cart" class="text-white">Carrito</a></li>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <li><a href="index.php?action=login" class="text-white">Iniciar sesión</a></li>
                    <li><a href="index.php?action=register" class="text-white">Registrarse</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contacto</h5>
                <address>
                    <i class="fas fa-map-marker-alt"></i> Dirección: Calle Principal 123<br>
                    <i class="fas fa-phone"></i> Teléfono: (123) 456-7890<br>
                    <i class="fas fa-envelope"></i> Email: info@ecommerce.com
                </address>
            </div>
        </div
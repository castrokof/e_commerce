<?php
// views/products/list.php

// Incluir encabezado
include_once 'views/templates/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Productos</h1>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="index.php?action=add_product" class="btn primary">Agregar Producto</a>
        <?php endif; ?>
    </div>
    
    <?php if (isset($_GET['created']) && $_GET['created'] === '1'): ?>
        <div class="alert success">Producto creado exitosamente.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['updated']) && $_GET['updated'] === '1'): ?>
        <div class="alert success">Producto actualizado exitosamente.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] === '1'): ?>
        <div class="alert success">Producto eliminado exitosamente.</div>
    <?php endif; ?>
    <div class="product-grid">
    <?php
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if (isset($image) && $image): ?>
                        <img src="assets/images/products/<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($name); ?>">
                    <?php else: ?>
                        <img src="assets/images/products/default.jpg" alt="Default">
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h3><?php echo htmlspecialchars($name); ?></h3>
                    <p class="product-category"><?php echo htmlspecialchars($category_name); ?></p>
                    <p class="product-description"><?php echo htmlspecialchars(substr($description, 0, 100)) . (strlen($description) > 100 ? '...' : ''); ?></p>
                    <p class="product-price">$<?php echo number_format($price, 2); ?></p>
                    
                    <div class="product-actions">
                        <form action="index.php?action=add_to_cart" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                            <button type="submit" class="btn secondary">Agregar al carrito</button>
                        </form>
                        
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <div>
                                <a href="index.php?action=edit_product&id=<?php echo $id; ?>" class="btn secondary">Editar</a>
                                <a href="index.php?action=delete_product&id=<?php echo $id; ?>" class="btn danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No hay productos disponibles.</p>";
    }
    ?>
</div>
</div>

<?php
// Incluir pie de página
include_once 'views/templates/footer.php';
?>
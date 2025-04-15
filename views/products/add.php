<?php
// views/products/add.php

// Incluir encabezado
include_once 'views/templates/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Agregar Producto</h1>
        <a href="index.php?action=products" class="btn secondary">Volver a Productos</a>
    </div>
    
    <?php if (isset($errorMsg)): ?>
        <div class="alert error"><?php echo $errorMsg; ?></div>
    <?php endif; ?>
    
    <form action="index.php?action=add_product" method="post" enctype="multipart/form-data" class="form-container">
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" rows="5"></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" required>
        </div>
        
        <div class="form-group">
            <label for="category_id">Categoría:</label>
            <select id="category_id" name="category_id">
                <option value="">Seleccionar categoría</option>
                <?php 
                while ($category = $categories->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image">Imagen:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn primary">Guardar Producto</button>
        </div>
    </form>
</div>

<?php
// Incluir pie de página
include_once 'views/templates/footer.php';
?>
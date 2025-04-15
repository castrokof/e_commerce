<?php
// views/products/edit.php

// Incluir encabezado
include_once 'views/templates/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Editar Producto</h1>
        <a href="index.php?action=products" class="btn secondary">Volver a Productos</a>
    </div>
    
    <?php if (isset($errorMsg)): ?>
        <div class="alert error"><?php echo $errorMsg; ?></div>
    <?php endif; ?>
    
    <form action="index.php?action=edit_product&id=<?php echo $this->product->id; ?>" method="post" enctype="multipart/form-data" class="form-container">
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($this->product->name); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($this->product->description); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo htmlspecialchars($this->product->price); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="category_id">Categoría:</label>
            <select id="category_id" name="category_id">
                <option value="">Seleccionar categoría</option>
                <?php 
                while ($category = $categories->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($category['id'] == $this->product->category_id) ? 'selected' : '';
                    echo '<option value="' . $category['id'] . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image">Imagen actual:</label>
            <?php if ($this->product->image): ?>
                <img src="assets/images/products/<?php echo htmlspecialchars($this->product->image); ?>" alt="<?php echo htmlspecialchars($this->product->name); ?>" class="thumbnail">
            <?php else: ?>
                <p>No hay imagen</p>
            <?php endif; ?>
            <label for="image">Cambiar imagen:</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn primary">Actualizar Producto</button>
        </div>
    </form>
</div>

<?php
// Incluir pie de página
include_once 'views/templates/footer.php';
?>
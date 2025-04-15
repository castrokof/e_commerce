<?php
// views/cart/view.php
include 'views/templates/header.php';
?>

<div class="container mt-4">
    <h1>Mi Carrito de Compras</h1>
    
    <?php if (isset($_GET['added'])): ?>
        <div class="alert alert-success">Producto agregado al carrito correctamente.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['removed'])): ?>
        <div class="alert alert-warning">Producto eliminado del carrito.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-info">Carrito actualizado correctamente.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['cleared'])): ?>
        <div class="alert alert-warning">Carrito vaciado correctamente.</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">Ocurrió un error al procesar tu solicitud.</div>
    <?php endif; ?>
    
    <?php
    // Verificar si hay productos en el carrito
    if ($items->rowCount() > 0):
    ?>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if ($item['product_image']): ?>
                                <img src="assets/images/products/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" class="img-thumbnail mr-3" style="width: 50px; height: 50px;">
                            <?php else: ?>
                                <img src="assets/images/products/default.jpg" alt="Default" class="img-thumbnail mr-3" style="width: 50px; height: 50px;">
                            <?php endif; ?>
                            <span><?php echo $item['product_name']; ?></span>
                        </div>
                    </td>
                    <td>$<?php echo number_format($item['product_price'], 2); ?></td>
                    <td>
                        <form action="index.php?action=update_quantity" method="post" class="form-inline">
                            <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control form-control-sm" style="width: 60px;">
                            <button type="submit" class="btn btn-sm btn-primary ml-2">Actualizar</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></td>
                    <td>
                        <a href="index.php?action=remove_from_cart&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto del carrito?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total:</strong></td>
                    <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="d-flex justify-content-between mt-3">
        <a href="index.php?action=home" class="btn btn-secondary">Seguir comprando</a>
        <div>
            <a href="index.php?action=clear_cart" class="btn btn-warning mr-2" onclick="return confirm('¿Estás seguro de vaciar el carrito?')">Vaciar carrito</a>
            <a href="index.php?action=checkout" class="btn btn-success">Proceder al pago</a>
        </div>
    </div>
    
    <?php else: ?>
    
    <div class="alert alert-info">
        Tu carrito está vacío. <a href="index.php?action=home">Haz clic aquí</a> para comenzar a comprar.
    </div>
    
    <?php endif; ?>
</div>

<?php include 'views/templates/footer.php'; ?>
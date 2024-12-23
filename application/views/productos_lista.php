<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos - Administración</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-4">Administración de Productos</h1>
                
                <div class="card">
                    <div class="card-header">
                        <a href="<?= site_url('admin/agregar_producto') ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar Nuevo Producto
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($productos)): ?>
                                        <?php foreach ($productos as $producto): ?>
                                        <tr>
                                            <td><?= $producto->id_producto ?></td>
                                            <td>
                                                <?php if(!empty($producto->imagen)): ?>
                                                    <img src="<?= base_url('uploads/productos/' . $producto->imagen) ?>" 
                                                         alt="<?= $producto->nombre ?>" 
                                                         style="max-width: 50px; max-height: 50px;">
                                                <?php else: ?>
                                                    Sin imagen
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $producto->nombre ?></td>
                                            <td><?= $producto->categoria ?></td>
                                            <td>$<?= number_format($producto->precio, 2) ?></td>
                                            <td><?= $producto->stock ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('admin/editar_producto/' . $producto->id_producto) ?>" 
                                                       class="btn btn-sm btn-warning">
                                                        Editar
                                                    </a>
                                                    <a href="<?= site_url('admin/eliminar_producto/' . $producto->id_producto) ?>" 
                                                       class="btn btn-sm btn-danger" 
                                                       onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                                        Eliminar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="alert alert-info">
                                                    No hay productos registrados
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
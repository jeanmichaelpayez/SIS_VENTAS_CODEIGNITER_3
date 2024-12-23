<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* Fondo gradiente interactivo */
        body {
            margin: 0;
            height: 100vh;
            overflow-y: auto;
            font-family: Arial, sans-serif;
            position: relative;
            background: linear-gradient(45deg, #000000, #4b0082, #0000ff, #00ffff); /* Negro, morado, azul, celeste */
            background-size: 300% 300%;
            animation: gradientAnimation 8s infinite ease-in-out;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Contenedor con efecto glassmorphism */
        .dashboard-container {
            background: rgba(255, 255, 255, 0.2); /* Fondo translúcido */
            backdrop-filter: blur(12px); /* Desenfoque */
            -webkit-backdrop-filter: blur(12px); /* Desenfoque para Safari */
            border: 1px solid rgba(255, 255, 255, 0.3); /* Borde translúcido */
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4); /* Sombra */
            padding: 20px;
            width: 100%;
            max-width: 1200px;
            margin: 80px auto;
            position: relative;
            text-align: center;
        }

        /* Texto y enlaces */
        h1, h2, h3, p {
            margin-bottom: 20px;
            color: white; /* Texto en blanco */
        }

        a {
            text-decoration: none;
            color: white;
            background-color: rgba(0, 0, 255, 0.7); /* Botón translúcido */
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin: 5px;
        }

        a:hover {
            background-color: rgba(0, 0, 200, 0.9);
        }

        /* Ruido */
        .noise {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/noise.png'); /* Patrón de ruido */
            opacity: 0.1;
            z-index: 1;
            pointer-events: none;
        }

        /* Barra superior */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 2;
        }

        .top-bar a {
            margin-left: 10px;
        }

        /* Contenedor de productos */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            width: 300px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
            text-align: left;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
        }

        .card-text {
            font-size: 0.9rem;
            color: #ddd;
        }

        .btn {
            display: inline-block;
            background-color: rgba(0, 0, 255, 0.7);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: rgba(0, 0, 200, 0.9);
        }

        /* Tabla de productos (Administrador) */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            overflow: hidden;
            color: white;
        }

        .table th, .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .table th {
            background-color: rgba(0, 0, 255, 0.7);
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Botones de acción */
        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn-warning {
            background-color: rgba(255, 165, 0, 0.7);
        }

        .btn-danger {
            background-color: rgba(255, 0, 0, 0.7);
        }

        .btn-warning:hover {
            background-color: rgba(255, 165, 0, 0.9);
        }

        .btn-danger:hover {
            background-color: rgba(255, 0, 0, 0.9);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Fondo de ruido -->
    <div class="noise"></div>

    <!-- Barra superior -->
    <div class="top-bar">
        <div>
            Hola, Bienvenido <?= $nombre; ?> (<?= $rol; ?>)
        </div>
        <div>
            <a href="#" id="nosotrosBtn">Nosotros</a>
            <a href="<?= site_url('mensajes') ?>">CHAT</a>
            <a href="<?= site_url('dashboard/dni') ?>">DNI</a>
            <a href="<?= site_url('dashboard/api') ?>">API</a>
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Contenedor del dashboard -->
    <div class="dashboard-container">
        <?php if ($rol === '1. administrador'): ?>
            <h1 class="mt-4">Administración de Productos</h1>
            <div class="cs">
                <div class="card-header">
                    <a href="<?= site_url('admin/agregar_producto') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Agregar Nuevo Producto
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
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
                                            <div class="btn-group">
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
        <?php else: ?>
            <h2>TIENDA DE INFORMATICA COMPUTER WORLD</h2>
            <h2>Productos Disponibles</h2>
            <div class="container">
                <?php foreach($productos as $producto): ?>
                    <div class="card">
                        <img src="<?= base_url('uploads/productos/' . $producto->imagen) ?>" alt="<?= $producto->nombre ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $producto->nombre ?></h5>
                            <p class="card-text"><?= $producto->descripcion ?></p>
                            <p>Precio: $<?= $producto->precio ?></p>
                            <a href="<?= site_url('carrito/agregar/' . $producto->id_producto) ?>" class="btn">Agregar al Carrito</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Evento para mostrar el mensaje de "Nosotros"
        document.getElementById('nosotrosBtn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Nosotros',
                text: 'Somos un e-commerce centrado en la venta de artículos informáticos, ofrecemos una gran variedad de artículos entre los que destacan computadoras, laptops, periféricos y otros.',
                icon: 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#007bff'
            });
        });
    </script>
</body>
</html>
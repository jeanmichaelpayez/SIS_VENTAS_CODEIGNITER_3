<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        /* Formulario de Producto */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: white;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-control-file {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-primary {
            background-color: rgba(0, 0, 255, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: rgba(0, 0, 200, 0.9);
        }

        .btn-secondary {
            background-color: rgba(128, 128, 128, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: rgba(128, 128, 128, 0.9);
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
            <a href="<?= site_url('mensajes') ?>">CHAT</a>
            <a href="<?= site_url('dashboard/dni') ?>">DNI</a>
            <a href="<?= site_url('dashboard/api') ?>">API</a>
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Contenedor del dashboard -->
    <div class="dashboard-container">
        <?php if ($rol === '1. administrador'): ?>
            <div class="container">
                <h2><?= isset($producto) ? 'Editar' : 'Agregar' ?> Producto</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="<?= isset($producto) ? $producto->nombre : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="descripcion" class="form-control"><?= isset($producto) ? $producto->descripcion : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Categoría</label>
                        <select name="categoria" class="form-control" required>
                            <option value="">Seleccionar Categoría</option>
                            <option value="laptops" <?= isset($producto) && $producto->categoria == 'laptops' ? 'selected' : '' ?>>Laptops</option>
                            <option value="computadoras" <?= isset($producto) && $producto->categoria == 'computadoras' ? 'selected' : '' ?>>Computadoras de Escritorio</option>
                            <option value="componentes" <?= isset($producto) && $producto->categoria == 'componentes' ? 'selected' : '' ?>>Componentes</option>
                            <option value="perifericos" <?= isset($producto) && $producto->categoria == 'perifericos' ? 'selected' : '' ?>>Periféricos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Precio</label>
                        <input type="number" name="precio" class="form-control" step="0.01" 
                               value="<?= isset($producto) ? $producto->precio : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" 
                               value="<?= isset($producto) ? $producto->stock : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Imagen del Producto</label>
                        <input type="file" name="imagen" class="form-control-file">
                        <?php if(isset($producto) && !empty($producto->imagen)): ?>
                            <small>Imagen actual: <?= $producto->imagen ?></small>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= isset($producto) ? 'Actualizar' : 'Agregar' ?> Producto
                    </button>
                    <a href="<?= site_url('admin/productos') ?>" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        <?php else: ?>
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
</body>
</html>
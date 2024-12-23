<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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

        /* Tabla de carrito */
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
            color: white;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-danger {
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
        }

        .btn-danger:hover {
            background-color: rgba(200, 0, 0, 0.9);
        }

        .btn-success {
            background-color: rgba(0, 255, 0, 0.7);
            color: white;
        }

        .btn-success:hover {
            background-color: rgba(0, 200, 0, 0.9);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .table th, .table td {
                padding: 10px;
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
            <a href="<?= site_url('dashboard/index') ?>">PRODUCTOS</a>
            <a href="<?= site_url('dashboard/dni') ?>">DNI</a>
            <a href="<?= site_url('dashboard/api') ?>">API</a>
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Contenedor del dashboard -->
    <div class="dashboard-container">
        <h2>Carrito de Compras</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items_carrito as $item): ?>
                <tr>
                    <td><?= $item->nombre ?></td>
                    <td><?= $item->cantidad ?></td>
                    <td>$<?= $item->precio ?></td>
                    <td>$<?= $item->precio * $item->cantidad ?></td>
                    <td>
                        <a href="<?= site_url('carrito/eliminar/' . $item->id_carrito) ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total:</td>
                    <td>$<?= $total ?></td>
                    <td>
                        <a href="<?= site_url('carrito/pagar') ?>" class="btn btn-success">Pagar</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
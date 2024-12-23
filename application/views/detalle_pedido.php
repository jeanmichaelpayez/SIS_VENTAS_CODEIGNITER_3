<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido</title>
    <style>
        /* Fondo gradiente interactivo */
        body {
            margin: 0;
            height: 100vh;
            overflow: hidden;
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
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.02);
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

        /* Tabla de detalles */
        .table {
            width: 100%;
            max-width: 600px;
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

        /* Botones */
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: rgba(0, 0, 255, 0.7);
            color: white;
        }

        .btn-primary:hover {
            background-color: rgba(0, 0, 200, 0.9);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 10px;
            }

            .card, .table {
                max-width: 100%;
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
        <div class="container">
            <h2>Detalle del Pedido #<?= $pedido->id_pedido ?></h2>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Información del Pedido</h5>
                    <p>Fecha: <?= date('d/m/Y', strtotime($pedido->fecha_pedido)) ?></p>
                    <p>Total: $<?= number_format($pedido->total, 2) ?></p>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($detalles as $detalle): ?>
                    <tr>
                        <td><?= $detalle->nombre ?></td>
                        <td><?= $detalle->cantidad ?></td>
                        <td>$<?= number_format($detalle->precio_unitario, 2) ?></td>
                        <td>$<?= number_format($detalle->cantidad * $detalle->precio_unitario, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="<?= site_url('pedidos') ?>" class="btn btn-primary">Volver a Mis Pedidos</a>
        </div>
    </div>
</body>
</html>
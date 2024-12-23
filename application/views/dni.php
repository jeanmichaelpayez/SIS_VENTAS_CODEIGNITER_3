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
            max-width: 400px;
            margin: auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
        }

        /* Texto y enlaces */
        h1, p {
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

        /* Formulario de consulta */
        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            width: 100%;
            max-width: 200px;
        }

        button {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: rgba(0, 0, 255, 0.7);
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: rgba(0, 0, 200, 0.9);
        }

        /* Resultados de la consulta */
        .resultados {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Tabla de resultados */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: rgba(0, 0, 255, 0.7);
            color: white;
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
        h3 { color: white; /* Cambia 'blue' por el color que prefieras */ }
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
            <a href="<?= site_url('dashboard/api') ?>">API</a>
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Contenedor del dashboard -->
    <div class="dashboard-container">


        <!-- Formulario de consulta de DNI -->
        <form action="<?php echo base_url('index.php/reniec/consultar'); ?>" method="post">
            <label for="dni"><h3 >DNI</h3></label>
            <input type="text" id="dni" name="dni" required>
            <button type="submit">Consultar</button>
        </form>

        <!-- Mostrar resultados o errores -->
        <?php if (isset($error)): ?>
            <div class="resultados">
                <p><?= $error; ?></p>
            </div>
        <?php elseif (isset($persona)): ?>
            <div class="resultados">
                <h2>Resultados de la Consulta</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Campo</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($persona as $key => $value): ?>
                            <tr>
                                <td><?= $key; ?></td>
                                <td><?= $value; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
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
            max-width: 1100px;
            margin: auto;
            position: relative;
            top: 55%;
            transform: translateY(-50%);
            text-align: center;
            display: flex;
            justify-content: space-between;
        }

        /* Texto y enlaces */
        h1, h3, p {
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

        /* Contenedor de código y token */
        .card {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px;
            border-radius: 0px;
            text-align: left;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .card pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            color: black;
            background: rgba(255, 255, 255, 0.7);
            padding: 1px;
            border-radius: 5px;
            overflow-x: auto;
        }

        .card p {
            font-size: 18px;
            font-weight: bold;
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
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
        </div>
    </div>

    <!-- Contenedor del dashboard -->
    <div class="dashboard-container">
        <!-- Contenedor de código PHP -->
        <div class="card">
            <h3>Código PHP</h3>
            <pre>
$token = 'ingrese su token generado aqui';
$url = 'http://13.59.114.15/login3/index.php/restserver/usuario/3';

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 2,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $token
    ),
));

$response = curl_exec($curl);

curl_close($curl);

if ($response) {
    $data = json_decode($response, true);
    print_r($data);
} else {
    echo 'Error al realizar la solicitud';
}
            </pre>
        </div>

        <!-- Contenedor de token generado -->
        <div class="card">
            <h3>Tokens</h3>
            <p>generar sus token</p>
            <?php if ($rol === '1. administrador'): ?>
                <form method="POST" action="<?= base_url('index.php/restserver/generar_token') ?>" id="tokenForm">
                    <label for="idusuario" class="hidden">ID de Usuario:</label>
                    <input type="number" name="idusuario" id="idusuario" value="<?= $idusuarios ?>" readonly required>
                    <button type="submit" >Generar Token</button>
                </form>
            <?php else: ?>
                <p>Es necesario ser usuario administrador para poder generar tokens.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
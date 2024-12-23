<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <!-- Incluir Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        body {
            background: linear-gradient(45deg, #000000, #4b0082, #0000ff, #00ffff);
            background-size: 300% 300%;
            animation: gradientAnimation 8s infinite ease-in-out;
            color: white;
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

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        .chat-item {
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .chat-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .last-message {
            font-size: 0.9rem;
            color: #ddd;
        }

        .badge-primary {
            background-color: rgba(0, 0, 255, 0.7);
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .modal-header, .modal-body, .modal-footer {
            border: none;
        }

        .modal-title {
            color: white;
        }

        .list-group-item {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: background-color 0.3s ease;
        }

        .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
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
        /* Texto y enlaces */
        h1, h2, h3, p {
            margin-bottom: 20px;
            color: white; /* Texto en blanco */
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
    </style>
</head>
<body>
    <!-- Fondo de ruido -->
    <div class="noise"></div>

    <!-- Barra superior -->
    <div class="top-bar">
        <div>
            Hola, Bienvenido <?=  $usuario_actual['nombre'];?> (<?= $usuario_actual['rol']; ?>)
        </div>
        <div>
            <a href="<?= site_url('dashboard/index') ?>">PRODUCTOS</a>
            <a href="<?= site_url('dashboard/dni') ?>">DNI</a>
            <a href="<?= site_url('dashboard/api') ?>">API</a>
            <a href="<?= site_url('auth/logout') ?>">Cerrar Sesión</a>
        </div>
    </div>

    <div class="dashboard-container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Conversaciones</h5>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#newChatModal">
                            Nueva conversación
                        </button>
                    </div>
                    <div class="card-body chat-list">
                        <?php if(empty($usuarios)): ?>
                            <p class="text-center text-muted">No hay conversaciones disponibles</p>
                        <?php else: ?>
                            <?php foreach($usuarios as $usuario): ?>
                                <div class="chat-item p-3 border-bottom" 
                                     onclick="window.location.href='<?= site_url('mensajes/chat/'.$usuario->idusuarios) ?>'">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?= $usuario->nombre ?></h6>
                                            <?php if(isset($usuario->ultimo_mensaje)): ?>
                                                <p class="last-message mb-0">
                                                    <?= $usuario->ultimo_mensaje ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <?php if($usuario->mensajes_no_leidos > 0): ?>
                                            <span class="badge badge-primary badge-pill">
                                                <?= $usuario->mensajes_no_leidos ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nueva conversación -->
    <div class="modal fade" id="newChatModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva conversación</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <?php foreach($todos_usuarios as $usuario): ?>
                            <?php if($usuario['idusuarios'] != $this->session->userdata('idusuarios')): ?>
                                <a href="<?= site_url('mensajes/chat/'.$usuario['idusuarios']) ?>" 
                                   class="list-group-item list-group-item-action">
                                    <?= $usuario['nombre'] ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir jQuery y Bootstrap JS desde CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
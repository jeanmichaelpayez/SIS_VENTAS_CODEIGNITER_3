<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            background: linear-gradient(45deg, #000000, #4b0082, #0000ff, #00ffff);
            background-size: 300% 300%;
            animation: gradientAnimation 8s infinite ease-in-out;
            color: white;
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

        .chat-container {
            height: 400px;
            overflow-y: auto;
            padding: 15px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 16px;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 70%;
            word-wrap: break-word;
            transition: background-color 0.3s ease;
        }

        .sent {
            background: #007bff;
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
        }

        .received {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            margin-right: auto;
            border-bottom-left-radius: 5px;
        }

        .message small {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .sent small {
            color: rgba(255, 255, 255, 0.8);
        }

        .card-header {
            background: rgba(255, 255, 255, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: bold;
            color: white;
        }

        .input-group .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .input-group .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .input-group .btn {
            background: #007bff;
            border: none;
            color: white;
            transition: background-color 0.3s ease;
        }

        .input-group .btn:hover {
            background: #0056b3;
        }

        .typing-indicator {
            padding: 5px 10px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            font-style: italic;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            margin-top: 10px;
            display: none;
        }

        @media (max-width: 768px) {
            .message {
                max-width: 85%;
            }

            .chat-container {
                height: 350px;
            }
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
            <a href="<?= site_url('mensajes') ?>">CHAT</a>
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
                        Chat con <?= $receptor['nombre'] ?>
                        <span class="badge bg-warning" id="connectionStatus">Conectando...</span>
                    </div>
                    <div class="card-body chat-container" id="chatContainer">
                        <?php foreach($mensajes as $mensaje): ?>
                            <div class="message <?= ($mensaje->emisor_id == $this->session->userdata('idusuarios')) ? 'sent' : 'received' ?>">
                                <?= htmlspecialchars($mensaje->mensaje) ?>
                                <small class="d-block text-muted"><?= date('H:i', strtotime($mensaje->fecha_envio)) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="typingIndicator" class="typing-indicator d-none">
                        El usuario está escribiendo...
                    </div>
                    <div class="card-footer">
                        <form id="messageForm" class="message-form">
                            <div class="input-group">
                                <input type="text" class="form-control" id="mensaje" 
                                       placeholder="Escribe un mensaje..." autocomplete="off">
                                <button class="btn btn-primary" type="submit" id="sendButton">
                                    Enviar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            let ws;
            let reconnectAttempts = 0;
            let isConnected = false;
            const maxReconnectAttempts = 5;
            const userId = <?= $this->session->userdata('idusuarios') ?>;
            const receptorId = <?= $receptor['idusuarios'] ?>;
            
            function initializeWebSocket() {
                try {
                    const wsProtocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
                    const wsURL = `${wsProtocol}//13.59.114.15:8080`;
                    
                    console.log('Conectando a:', wsURL);
                    ws = new WebSocket(wsURL);
                    
                    ws.onopen = function() {
                        console.log('WebSocket Conectado');
                        isConnected = true;
                        $('#connectionStatus').removeClass('bg-danger bg-warning').addClass('bg-success').text('Conectado');
                        reconnectAttempts = 0;
                        
                        // Registrar usuario
                        ws.send(JSON.stringify({
                            type: 'register',
                            userId: userId
                        }));
                    };
                    
                    ws.onmessage = function(e) {
                        const data = JSON.parse(e.data);
                        if (data.type === 'message') {
                            appendMessage(data.message, data.from === userId);
                        } else if (data.type === 'typing') {
                            handleTypingIndicator(data.userId, data.isTyping);
                        }
                    };
                    
                    ws.onclose = function() {
                        console.log('WebSocket Desconectado');
                        isConnected = false;
                        $('#connectionStatus').removeClass('bg-success bg-warning').addClass('bg-danger').text('Desconectado');
                        
                        if (reconnectAttempts < maxReconnectAttempts) {
                            setTimeout(function() {
                                reconnectAttempts++;
                                console.log('Intentando reconectar... Intento ' + reconnectAttempts);
                                initializeWebSocket();
                            }, 3000);
                        }
                    };

                    ws.onerror = function(err) {
                        console.error('Error de WebSocket:', err);
                        isConnected = false;
                    };
                } catch (error) {
                    console.error('Error al inicializar WebSocket:', error);
                }
            }
            
            // Iniciar conexión WebSocket
            initializeWebSocket();
            
            // Manejar envío de mensajes
            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                sendMessage();
            });

            // También permitir enviar con Enter
            $('#mensaje').on('keypress', function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            
            function sendMessage() {
                const mensaje = $('#mensaje').val().trim();
                if (!mensaje) return;
                
                if (!isConnected) {
                    alert('No hay conexión con el servidor. Por favor, espera a que se reconecte.');
                    return;
                }
                
                const messageData = {
                    type: 'message',
                    from: userId,
                    to: receptorId,
                    message: mensaje
                };
                
                try {
                    // Enviar por WebSocket
                    ws.send(JSON.stringify(messageData));
                    
                    // Guardar en la base de datos
                    $.ajax({
                        url: '<?= site_url('mensajes/enviar') ?>',
                        method: 'POST',
                        data: {
                            receptor_id: receptorId,
                            mensaje: mensaje
                        },
                        success: function() {
                            $('#mensaje').val('');
                            appendMessage(mensaje, true);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al guardar mensaje:', error);
                            alert('Error al enviar el mensaje. Por favor, intenta nuevamente.');
                        }
                    });
                } catch (error) {
                    console.error('Error al enviar mensaje:', error);
                    alert('Error al enviar el mensaje. Por favor, intenta nuevamente.');
                }
            }
            
            let typingTimer;
            $('#mensaje').on('input', function() {
                if (!isConnected) return;
                
                clearTimeout(typingTimer);
                sendTypingStatus(true);
                
                typingTimer = setTimeout(() => {
                    sendTypingStatus(false);
                }, 1000);
            });
            
            function sendTypingStatus(isTyping) {
                if (ws && ws.readyState === WebSocket.OPEN) {
                    ws.send(JSON.stringify({
                        type: 'typing',
                        userId: userId,
                        to: receptorId,
                        isTyping: isTyping
                    }));
                }
            }
            
            function handleTypingIndicator(typingUserId, isTyping) {
                if (typingUserId === receptorId) {
                    $('#typingIndicator').toggleClass('d-none', !isTyping);
                }
            }
            
            function appendMessage(message, sent) {
                const now = new Date();
                const time = now.getHours().toString().padStart(2, '0') + ':' + 
                            now.getMinutes().toString().padStart(2, '0');
                
                const messageDiv = $('<div>')
                    .addClass('message')
                    .addClass(sent ? 'sent' : 'received')
                    .html(
                        $('<div>').text(message).html() +
                        '<small class="d-block text-muted">' + time + '</small>'
                    );
                
                $('#chatContainer').append(messageDiv);
                $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
            }
            
            // Auto-scroll inicial
            $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
        });
    </script>
</body>
</html>
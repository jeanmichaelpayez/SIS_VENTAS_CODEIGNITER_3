// application/views/mensajes/chat.php
<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        .chat-container {
            height: 400px;
            overflow-y: auto;
        }
        .message {
            margin: 10px;
            padding: 10px;
            border-radius: 10px;
        }
        .message.sent {
            background-color: #e3f2fd;
            margin-left: 20%;
        }
        .message.received {
            background-color: #f5f5f5;
            margin-right: 20%;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Chat con <?= $receptor->nombre ?>
                    </div>
                    <div class="card-body chat-container" id="chatContainer">
                        <?php foreach($mensajes as $mensaje): ?>
                            <div class="message <?= ($mensaje->emisor_id == $this->session->userdata('idusuarios')) ? 'sent' : 'received' ?>">
                                <?= $mensaje->mensaje ?>
                                <small class="d-block text-muted"><?= date('H:i', strtotime($mensaje->fecha_envio)) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-footer">
                        <form id="messageForm">
                            <div class="input-group">
                                <input type="text" class="form-control" id="mensaje" placeholder="Escribe un mensaje...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script>
        $(document).ready(function() {
            const ws = new WebSocket('ws://tu_dominio:8080');
            const userId = <?= $this->session->userdata('idusuarios') ?>;
            const receptorId = <?= $receptor->idusuarios ?>;

            ws.onopen = function() {
                // Registrar usuario en el servidor WebSocket
                ws.send(JSON.stringify({
                    type: 'register',
                    userId: userId
                }));
            };

            ws.onmessage = function(e) {
                const data = JSON.parse(e.data);
                if (data.type === 'message') {
                    appendMessage(data.message, data.from === userId);
                }
            };

            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                const mensaje = $('#mensaje').val();
                if (mensaje.trim()) {
                    // Enviar por WebSocket
                    ws.send(JSON.stringify({
                        type: 'message',
                        from: userId,
                        to: receptorId,
                        message: mensaje
                    }));

                    // Guardar en la base de datos
                    $.post('<?= site_url('mensajes/enviar') ?>', {
                        receptor_id: receptorId,
                        mensaje: mensaje
                    });

                    $('#mensaje').val('');
                }
            });

            function appendMessage(message, sent) {
                const messageDiv = $('<div>')
                    .addClass('message')
                    .addClass(sent ? 'sent' : 'received')
                    .text(message);
                $('#chatContainer').append(messageDiv);
                $('#chatContainer').scrollTop($('#chatContainer')[0].scrollHeight);
            }
        });
    </script>
</body>
</html>
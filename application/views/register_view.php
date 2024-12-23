<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to bottom, blue, green);
            font-family: Arial, sans-serif;
        }
        .register-container {
            background-color: white;
            border: 1px solid black;
            border-radius: 8px;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .register-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Registro</h1>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" role="alert">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success" role="alert">
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= site_url('auth/register') ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de usuario" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>
        <p class="text-center mt-3">
            ¿Ya tienes una cuenta? <a href="<?= site_url('auth/login') ?>">Inicia sesión</a>
        </p>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

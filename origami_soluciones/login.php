<?php
session_start();  // Iniciar la sesión
include_once 'inc/functions.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <!-- Vincular Bootstrap desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Vincular el archivo CSS externo -->
    <link rel="stylesheet" href="resources/css/login.css">
</head>
<body>
<?php
// Comprobar si 'look' es igual a 'register' en la URL (con GET)
$showRegisterForm = isset($_GET['look']) && $_GET['look'] == 'register';
?>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="form-container">
            <!-- Formulario de Login -->
            <div id="login-form" class="form-box" style="display: <?php echo $showRegisterForm ? 'none' : 'block'; ?>;">
                <?php
                    // Verificar si hay un mensaje de error en la sesión
                    if (isset($_SESSION['login_error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
                        unset($_SESSION['login_error']);
                    }
                ?>
                <h2>Iniciar Sesión</h2>
                <form action="inc/login.php?action=login" method="POST">
                    <div class="mb-3">
                        <label for="login-email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="login-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="login-password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-custom">Iniciar sesión</button>
                    <p class="mt-3">¿No tienes cuenta? <button type="button" class="btn btn-link" id="switch-to-register">Registrate aquí</button></p>
                </form>
            </div>

            <!-- Formulario de Registro -->
            <div id="register-form" class="form-box" style="display: <?php echo $showRegisterForm ? 'block' : 'none'; ?>;">
                <h2>Registrarse</h2>
                <form action="inc/login.php?action=register" method="POST">
                    <?php
                    // Verificar si hay un mensaje de error en la sesión
                    if (isset($_SESSION['register_error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['register_error'] . '</div>';
                        unset($_SESSION['register_error']);
                    }
                    ?>
                    <div class="mb-3">
                        <label for="register-name" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="register-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="register-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="register-password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="register-password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-custom">Registrarse</button>
                    <p class="mt-3">¿Ya tienes cuenta? <button type="button" class="btn btn-link" id="switch-to-login">Inicia sesión aquí</button></p>
                </form>
            </div>
        </div>
    </div>
    <!-- Vincular los archivos JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Vincular el archivo JS externo -->
    <script src="resources/js/login.js"></script>

</body>
</html>

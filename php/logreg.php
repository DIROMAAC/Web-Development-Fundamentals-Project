<?php
require_once "cad.php";
session_start();

$loginError = "";
$registerMessage = "";

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cad = new CAD();

    // Procesar Login
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        if (!empty($correo) && !empty($contrasena)) {
            $usuario = $cad->verificaUsuario($correo, $contrasena);

            if ($usuario) {
                $_SESSION['idUsuario'] = $usuario['idUsuario'];
                $_SESSION['correo'] = $usuario['correo'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['Rol'] = $usuario['Rol'];
                header("Location: prin.php");
                exit();
            } else {
                $loginError = "Correo o contraseña incorrectos.";
            }
        } else {
            $loginError = "Por favor, completa todos los campos.";
        }
    }

    // Procesar Registro
    if (isset($_POST['action']) && $_POST['action'] === 'register') {
        $nombre = trim($_POST['nombre']);
        $correo = trim($_POST['correo']);
        $contrasena = trim($_POST['contrasena']);

        if (!empty($nombre) && !empty($correo) && !empty($contrasena)) {
            $resultado = $cad->agregaUsuario($nombre, $contrasena, $correo);
            if (strpos($resultado, 'correctamente') !== false) {
                $registerMessage = "Usuario registrado exitosamente. Ahora puedes iniciar sesión.";
            } else {
                $registerMessage = $resultado;
            }
        } else {
            $registerMessage = "Por favor, completa todos los campos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <title>Login y Registro</title>
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="../vid/fondo.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div class="login-register-container">
        <div class="form-wrapper">
            <!-- Login Section -->
            <div class="login-section">
                <h2>Inicio de Sesión</h2>
                <?php if (!empty($loginError)): ?>
                    <p style="color: red;"><?php echo $loginError; ?></p>
                <?php endif; ?>
                <form action="logreg.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    <input type="email" id="correo-login" name="correo" placeholder="Correo Electrónico" required>
                    <input type="password" id="password-login" name="contrasena" placeholder="Contraseña" required>
                    <button type="submit">Iniciar Sesión</button>
                </form>
                <a href="actualiza.php" class="forgot-password">Actualizar contraseña</a>
            </div>

            <!-- Registro Section -->
            <div class="register-section">
                <h2>Registro</h2>
                <form action="logreg.php" method="POST">
                    <input type="hidden" name="action" value="register">
                    <input type="text" id="nombre-register" name="nombre" placeholder="Nombre" required>
                    <input type="email" id="correo-register" name="correo" placeholder="Correo Electrónico" required>
                    <input type="password" id="password-register" name="contrasena" placeholder="Contraseña" required>
                    <button type="submit">Registrar</button>
                </form>

                <!-- Eliminar usuario (solo para administradores) -->
                <?php if ($_SESSION['Rol'] == 1): ?>
                    <a href="elimina.php" class="delete-user-button">Eliminar usuario</a>
                <?php else: ?>
                    <!-- <p style="color: gray;">Se necesita ser administrador.</p> -->
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

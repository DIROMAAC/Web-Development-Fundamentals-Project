<?php
require_once "cad.php";
session_start();

$datosModificar = "";
$bandContr = false;
$bandCorreo = false;
$bandNombre = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['contrasena'])) {
        $contrasena = $_POST['contrasena'];
        $datosModificar = "contrasena='$contrasena'";
        $bandContr = true;
    }

    if (!empty($_POST['correo'])) {
        $correo = $_POST['correo'];
        if ($bandContr) {
            $datosModificar = "correo='$correo', " . $datosModificar;
        } else {
            $datosModificar = "correo='$correo'";
        }
        $bandCorreo = true;
    }

    if (!empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        if ($bandContr || $bandCorreo) {
            $datosModificar = "nombre='$nombre', " . $datosModificar;
        } else {
            $datosModificar = "nombre='$nombre'";
        }
        $bandNombre = true;
    }

    if ($bandNombre || $bandCorreo || $bandContr) {
        $cad = new CAD();
        if ($cad->modificaUsuario($datosModificar, $_SESSION['idUsuario'])) {
            header("Location: logreg.php");
            exit();
        } else {
            $errorMsg = "Error al actualizar los datos.";
        }
    } else {
        $errorMsg = "No se han ingresado datos para actualizar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/actualiza.css">
    <title>Actualizar Datos</title>
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="../vid/fondo.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>

    <div class="login-register-container">
        <div class="form-wrapper">
            <div class="update-section">
                <h2>Actualizar Datos</h2>
                <?php if (!empty($errorMsg)) echo "<p style='color: red;'>$errorMsg</p>"; ?>
                <form action="actualiza.php" method="POST">
                    <input type="text" name="nombre" placeholder="Nuevo Nombre" value="">
                    <input type="email" name="correo" placeholder="Nuevo Correo" value="">
                    <input type="password" name="contrasena" placeholder="Nueva Contraseña" value="">
                    <button type="submit">Actualizar</button>
                </form>
                <a href="logreg.php" class="forgot-password">Regresar</a>
            </div>
        </div>
    </div>
</body>
</html>

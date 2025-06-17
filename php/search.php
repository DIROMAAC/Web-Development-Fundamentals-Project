<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../PROYECTO/php/logreg.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/search.css"/>
        <script defer src="../js/search.js"></script>
        <title>ConcertHub - Búsqueda</title>
    </head>
    <body>
        <div class="contenedor">
            <div class="menu">
                <video autoplay muted loop id="background-video">
                    <source src="../vid/fondo.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
                <div class="name">
                    <p>ConcertHub</p>
                </div>
                <div class="sections">
                    <a href="../php/prin.php">HOME</a>
                    <a href="../php/artistas.php">ARTISTAS</a>
                    <a href="../php/conciertos.php">CONCIERTOS</a>
                </div>
                <div class="icons">
                    <a href="../php/search.php"><img src="https://img.icons8.com/?size=100&id=7695&format=png&color=FFFFFF"></a>
                    <a href="../php/compras.php"><img src="https://img.icons8.com/?size=100&id=59997&format=png&color=FFFFFF"></a>
                    <a href="../php/logreg.php"><img src="https://img.icons8.com/?size=100&id=98957&format=png&color=FFFFFF"></a>
                </div>
            </div>

            <div class="contenido">
                <h1>Busca a tu artista favorito</h1>
                <div class="search-bar">
                    <input type="text" id="artist-search" placeholder="Escribe el nombre del artista">
                    <button id="search-btn">Buscar</button>
                </div>
                <div id="results-container" class="results-grid">
                    <!-- Aquí se mostrarán los álbumes y canciones -->
                </div>                
            </div>

            <div class="pie">
                <video autoplay muted loop id="pie-video">
                    <source src="../vid/fondo.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
                <a href="#"><img src="https://img.icons8.com/?size=100&id=32292&format=png&color=FFFFFF"></a>
                <a href="#"><p>ConcertHub</p></a>
                <a href="#"><img src="https://img.icons8.com/?size=100&id=435&format=png&color=FFFFFF"></a>
                <a href="#"><p>ConcertHub</p></a>
                <a href="#"><img src="https://img.icons8.com/?size=100&id=111056&format=png&color=FFFFFF"></a>
                <a href="#"><p>ConcertHub</p></a>
                <h2>ConcertHub &copy; 2022 Todos los derechos reservados.</h2>
            </div>
        </div>
    </body>
</html>

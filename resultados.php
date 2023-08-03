<!DOCTYPE html>
<html>
<head>
    <!--
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
-->

    <title>Sistema de Votación</title>
    
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Definición del conjunto de caracteres que se debe utilizar -->
    <meta charset="UTF-8">

    <!-- Asegura la correcta visualización en dispositivos móviles y la correcta funcionalidad del zoom -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Permite controlar cómo se debe indexar el contenido y seguir los enlaces -->
    <meta name="robots" content="index, follow">

    <!-- Una breve descripción del contenido de la página -->
    <meta name="description" content="Página de votación para las elecciones. Registra tu voto y conoce los resultados.">

    <!-- Palabras clave relevantes para los motores de búsqueda -->
    <meta name="keywords" content="votación, elecciones, registro de voto, resultados de votación">

    <!-- Autor del documento -->
    <meta name="author" content="Miguel González">

    <!-- Última vez que se modificó la página -->
    <meta http-equiv="last-modified" content="2023-08-03">
    
    <!-- Otros metadatos relacionados con Open Graph protocol para mejorar la integración con redes sociales -->
    <meta property="og:title" content="Sistema de Votación" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://127.0.0.1/ejemplo_votos" />
    <meta property="og:image" content="http://127.0.0.1/ejemplo_votos/imagen.png" />
    <meta property="og:description" content="Página de votación para las elecciones. Registra tu voto y conoce los resultados." />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
    <body>
    <h1>Resultados de la votación</h1>

    <p id="voterCount"></p>
    <p id="notificationCount"></p>
    <button id="inicio">Volver a Votar</button>
    <canvas id="votingResultsChart" style="max-width: 600px; max-height: 400px;"></canvas>
    <script>
        $(document).ready(function() {
            $('#inicio').click(function() {
                window.location.href = 'index.php';
            });
        });
    </script>
    <script src="resultados.js"></script>
</body>
</html>

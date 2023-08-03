<!DOCTYPE html>
<html>
<head>
<!------------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ------------------------------------------------------------>
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

    <style>
        .form-container {
            display: flex;  /* Alinea los elementos en línea en lugar de en columna */
            justify-content: left;  /* Alinea los elementos al inicio de la línea */
        }
        table {
            width: 600px;  /* Ancho de la tabla */
        }
        input[type="text"], select {
            width: 100%;  /* Ancho de los campos de texto y los selectores */
            box-sizing: border-box;  /* Asegura que padding y border no aumenten el tamaño total del elemento */
        }
        .checkbox-group {
            display: flex;  /* Alinea los checkboxes en línea en lugar de en columna */
            justify-content: space-between;  /* Distribuye el espacio restante entre los checkboxes */
        }
        input[type="submit"] {
            width: 80px;  /* Ancho del botón de envío */
        }
    </style>

    <!-- Incluir jQuery para manejo de eventos y manipulación del DOM -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Incluir un archivo de funciones JS personalizado -->
    <script src="js/funciones.js"></script>
</head>
<body>
    <h1>Formulario de Votación</h1>
    <div class="form-container">
        <!-- Inicio del formulario de votación -->
        <form id="votingForm" action="php/validaciones.php" method="post">
            <table>
                <!-- Cada fila (<tr>) contiene un campo del formulario -->
                <tr>
                    <td><label for="nombre_apellido">Nombre y Apellido</label></td>
                    <td><input type="text" name="nombre_apellido" id="nombre_apellido"></td>
                </tr>
                <tr>
                    <td><label for="alias">Alias</label></td>
                    <td><input type="text" name="alias" id="alias"></td>
                </tr>
                <tr>
                    <td><label for="rut">RUT</label></td>
                    <td><input type="text" name="rut" id="rut"></td>
                </tr>
                <tr>
                    <td><label for="email">Email</label></td>
                    <td><input type="text" name="email" id="email"></td>
                </tr>
                <tr>
                    <td><label for="region">Región</label></td>
                    <td>
                        <select id="region" name="region">
                        <option value="">Seleccione una Región</option>
                            <!-- Las opciones se llenarán desde la base de datos -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="provincia">Provincia</label></td>
                    <td>
                        <select name="provincia" id="provincia">
                        <option value="">Seleccione una provincia</option>
                            <!-- Las opciones se llenarán desde la base de datos -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="comuna">Comuna</label></td>
                    <td>
                        <select name="comuna" id="comuna">
                        <option value="">Seleccione una comuna</option>
                            <!-- Las opciones se llenarán desde la base de datos -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="candidato">Candidato</label></td>
                    <td>
                        <select name="candidato" id="candidato">
                        <option value="">Seleccione un candidato</option>
                            <!-- Las opciones se llenarán desde la base de datos -->
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>¿Cómo se enteró de nosotros?</label></td>
                    <td>
                        <div class="checkbox-group">
                            <label><input type="checkbox" name="notificado_por[]" value="WEB"> Web</label>
                            <label><input type="checkbox" name="notificado_por[]" value="TV"> TV</label>
                            <label><input type="checkbox" name="notificado_por[]" value="RED SOCIAL"> Red Social</label>
                            <label><input type="checkbox" name="notificado_por[]" value="AMIGO"> Amigo</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" style="margin-right: 10%; margin-top: 3%;">Votar</button>
                        <button id="resultados">Ver resultados</button>
                    </td>
                </tr>
            </table>
        </form>
        <!-- Fin del formulario de votación -->
    </div>

    <!-- Scripts de jQuery -->
    <script>
        $(document).ready(function() {
            // Cuando el usuario hace clic en el botón de "Ver resultados",
            // los redirige a la página de resultados
            $('#resultados').click(function() {
                window.location.href = 'resultados.php';
            });
        });
    </script>
</body>
</html>

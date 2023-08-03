<?php
/*
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
*/

// Definimos las variables que se utilizarán para la conexión a la base de datos.
$host = 'localhost'; // El host de la base de datos, normalmente es 'localhost'.
$db   = 'ejemploVotoBD'; // El nombre de la base de datos a la que queremos conectarnos.
$user = 'root'; // El nombre del usuario que utilizará para la conexión.
$pass = ''; // La contraseña del usuario que utilizará para la conexión.
$charset = 'utf8mb4'; // El conjunto de caracteres que se utilizará en la conexión.

// Definimos opciones para la conexión con la base de datos.
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Modo de manejo de errores. Lanzará excepciones.
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de fetch por defecto. Devuelve un array asociativo.
    PDO::ATTR_EMULATE_PREPARES   => false, // Deshabilita la emulación de consultas preparadas para mayor seguridad.
];

// Construimos el DSN (Data Source Name), que es la cadena de conexión.
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
     // Intentamos crear una nueva instancia del objeto PDO y establecer la conexión con la base de datos.
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Si algo sale mal (por ejemplo, no se puede establecer la conexión), se lanza una excepción.
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

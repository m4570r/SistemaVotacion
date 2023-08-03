<?php
/*
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
*/

// Incluir el archivo de conexión a la base de datos
include 'conexionDB.php';

// Recoger la acción del POST
$action = $_POST['action'];

// Según la acción, ejecutar una consulta a la base de datos
switch ($action) {

    // Obtener todas las regiones
    case 'get_regiones':
        $regiones = [];

        // Preparar la consulta SQL
        $stmt = $pdo->prepare("SELECT * FROM region_cl");
        $stmt->execute();

        // Obtener los resultados como array asociativo
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados en formato JSON
        echo json_encode($result);
        break;

    // Obtener las provincias de una región
    case 'get_provincias':
        $regionId = $_POST['id'];
        $provincias = [];

        // Preparar la consulta SQL
        $query = $pdo->prepare("SELECT * FROM provincia_cl WHERE id_rg = :regionId");
        $query->execute(['regionId' => $regionId]);

        // Recorrer los resultados y añadirlos al array de provincias
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $provincias[] = $row;
        }

        // Devolver los resultados en formato JSON
        echo json_encode($provincias);
        break;

    // Obtener las comunas de una provincia
    case 'get_comunas':
        $provinciaId = $_POST['id'];
        $comunas = [];

        // Preparar la consulta SQL
        $query = $pdo->prepare("SELECT * FROM comuna_cl WHERE id_pr = :provinciaId");
        $query->execute(['provinciaId' => $provinciaId]);

        // Recorrer los resultados y añadirlos al array de comunas
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $comunas[] = $row;
        }

        // Devolver los resultados en formato JSON
        echo json_encode($comunas);
        break;

    // Verificar si un RUT ya ha votado
    case 'check_rut':
        $rut = $_POST['rut'];

        // Preparar la consulta SQL
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM votar WHERE rut = :rut");
        $stmt->bindParam(':rut', $rut);
        $stmt->execute();

        // Obtener el resultado como un array asociativo
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comprobar si el RUT ya ha votado y devolver la respuesta en formato JSON
        if ($result['count'] > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
        break;

    // Enviar el voto
    case 'submit_vote':
        // Recoger las variables del POST
        $nombre = $_POST['nombre_apellido'];
        $alias = $_POST['alias'];
        $rut = $_POST['rut'];
        $email = $_POST['email'];
        $region = $_POST['region'];
        $provincia = $_POST['provincia'];
        $comuna = $_POST['comuna'];
        $candidato = $_POST['candidato'];
        $comoSeEntero = $_POST['notificado_por'];
        $success = false;

        try {
            // Preparar la consulta SQL para buscar el candidato
            $stmt = $pdo->prepare("SELECT id_candidato FROM candidato WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $candidato);
            $stmt->execute();

            // Si se encontró el candidato, guardar su ID
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_candidato = $row['id_candidato'];
            } else {
                throw new Exception("No se encontró el candidato con el nombre proporcionado.");
            }

            // Preparar la consulta SQL para insertar el voto
            $query = $pdo->prepare("INSERT INTO votar (nombre, alias, rut, email, id_rg, id_co, id_candidato) 
                                    VALUES (:nombre, :alias, :rut, :email, :id_rg, :id_co, :id_candidato)");
            $query->execute([
                'nombre' => $nombre,
                'alias' => $alias,
                'rut' => $rut,
                'email' => $email,
                'id_rg' => $region,
                'id_co' => $provincia,
                'id_candidato' => $id_candidato,
            ]);

            // Guardar el ID del voto insertado
            $id_voto = $pdo->lastInsertId();

            // Por cada descripción en comoSeEntero, preparar la consulta SQL y ejecutarla
            foreach ($comoSeEntero as $descripcion) {
                $stmt = $pdo->prepare("SELECT id_cse FROM como_se_entero WHERE UPPER(descripcion) = UPPER(:descripcion)");
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $stmt = $pdo->prepare("INSERT INTO voto_cse (id_voto, id_cse) VALUES (:id_voto, :id_cse)");
                    $stmt->execute(['id_voto' => $id_voto, 'id_cse' => $row['id_cse']]);
                } else {
                    throw new Exception("No se encontró la descripción '{$descripcion}' en la tabla como_se_entero.");
                }
            }

            // Si todo fue exitoso, poner success a true
            $success = true;
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo json_encode(['error' => 'Usted ya realizó el voto.']);
            } else {
                echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
            }
            exit;
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }

        // Devolver si el voto ha sido exitoso o no en formato JSON
        echo json_encode(['success' => $success]);
        break;

    // Obtener los candidatos
    case 'get_candidatos':
        $candidatos = [];

        try {
            // Preparar la consulta SQL
            $query = $pdo->prepare("SELECT * FROM candidato");
            $query->execute();

            // Recorrer los resultados y añadirlos al array de candidatos
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $candidatos[] = $row;
            }
        } catch (PDOException $e) {
            // Si ocurre algún error con la consulta SQL, devolverlo en formato JSON
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
            exit;
        }

        // Devolver los resultados en formato JSON
        echo json_encode($candidatos);
        break;

    // Si no se reconoce la acción
    default:
        echo json_encode(['error' => 'Accion desconocida']);
        break;
}
?>

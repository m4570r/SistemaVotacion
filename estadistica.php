<?php
/*
    ----------------------------------------------------------
    Nombre del proyecto: Sistema de votacion electronica
    Descripción: Este proyecto es un sistema de votación electrónica que permite a los usuarios emitir su voto para un candidato determinado. Está construido con MySQL para la gestión de la base de datos, PHP para el procesamiento en el lado del servidor, HTML para la estructura de la página web, y JavaScript para la funcionalidad en el lado del cliente.
    Autor: Miguel Gonzalez
    Email: mgonzalez.gnu@gmail.com
    ----------------------------------------------------------
*/
require 'php/conexionDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'get_voter_count') {
        $stmt = $pdo->query('SELECT COUNT(*) AS count FROM votar');
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row['count'];
    }

    elseif ($_POST['action'] === 'get_notification_data') {
        $stmt = $pdo->query("
        SELECT como_se_entero.descripcion, COUNT(*) AS count 
        FROM votar 
        INNER JOIN voto_cse ON votar.id = voto_cse.id_voto
        INNER JOIN como_se_entero ON voto_cse.id_cse = como_se_entero.id_cse
        GROUP BY como_se_entero.descripcion
        LIMIT 0, 25;        
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    }
    

    elseif ($_POST['action'] === 'get_voting_results') {
        try {
            $stmt = $pdo->prepare("
            SELECT candidato.nombre, COUNT(votar.id_candidato) AS votos 
            FROM votar 
            INNER JOIN candidato ON votar.id_candidato = candidato.id_candidato
            GROUP BY votar.id_candidato 
            ORDER BY votos DESC
            ");
            
            $stmt->execute();
    
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            echo json_encode(['success' => true, 'data' => $results]);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Hubo un error al recoger los resultados de la votación.']);
        }
    }
}
?>

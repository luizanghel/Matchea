<?php
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $project_id = intval($_GET['id']);

    try {
        // Obtener detalles del proyecto
        $query_project = "
            SELECT p.*, u.nombre AS creador_nombre
            FROM proyectos p
            LEFT JOIN usuarios u ON p.creador_id = u.id
            WHERE p.id = :project_id
        ";
        $stmt_project = $conn->prepare($query_project);
        $stmt_project->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt_project->execute();
        $project = $stmt_project->fetch(PDO::FETCH_ASSOC);

        if (!$project) {
            echo json_encode(['error' => 'Proyecto no encontrado']);
            exit;
        }

        // Obtener habilidades del proyecto
        $query_habilidades = "
            SELECT h.nombre
            FROM proyecto_habilidades ph
            INNER JOIN habilidades h ON ph.habilidad_id = h.id
            WHERE ph.proyecto_id = :project_id
        ";
        $stmt_habilidades = $conn->prepare($query_habilidades);
        $stmt_habilidades->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt_habilidades->execute();
        $habilidades = $stmt_habilidades->fetchAll(PDO::FETCH_COLUMN);

        // Obtener usuarios del proyecto
        $query_usuarios = "
            SELECT u.nombre
            FROM participantes_proyecto pp
            INNER JOIN usuarios u ON pp.usuario_id = u.id
            WHERE pp.proyecto_id = :project_id
        ";
        $stmt_usuarios = $conn->prepare($query_usuarios);
        $stmt_usuarios->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt_usuarios->execute();
        $usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_COLUMN);

        // Respuesta JSON
        echo json_encode([
            'project' => $project,
            'habilidades' => $habilidades,
            'usuarios' => $usuarios
        ]);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error al obtener los detalles del proyecto']);
    }
}

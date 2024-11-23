<?php
require '../connection.php';

if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'ID de proyecto no especificado']);
    exit;
}

$project_id = intval($_GET['id']);

try {
    // Obtener detalles del proyecto
    $query = "SELECT * FROM proyectos WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$project) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Proyecto no encontrado']);
        exit;
    }

    // Obtener habilidades asociadas al proyecto
    $query_habilidades = "
        SELECT h.nombre 
        FROM habilidades h
        INNER JOIN proyecto_habilidades ph ON h.id = ph.habilidad_id
        WHERE ph.proyecto_id = :project_id
    ";
    $stmt_habilidades = $conn->prepare($query_habilidades);
    $stmt_habilidades->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $stmt_habilidades->execute();
    $habilidades = $stmt_habilidades->fetchAll(PDO::FETCH_COLUMN); // Obtener nombres como un array simple

    // Obtener usuarios inscritos en el proyecto
    $query_usuarios = "
        SELECT u.nombre 
        FROM usuarios u
        INNER JOIN participantes_proyecto pp ON u.id = pp.usuario_id
        WHERE pp.proyecto_id = :project_id
    ";
    $stmt_usuarios = $conn->prepare($query_usuarios);
    $stmt_usuarios->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $stmt_usuarios->execute();
    $usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_COLUMN); // Obtener nombres como un array simple

    // Construir respuesta JSON
    $response = [
        'nombre' => $project['nombre'],
        'descripcion' => $project['descripcion'],
        'pais' => $project['pais'],
        'habilidades' => $habilidades,
        'usuarios' => $usuarios
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error del servidor: ' . $e->getMessage()]);
    exit;
}

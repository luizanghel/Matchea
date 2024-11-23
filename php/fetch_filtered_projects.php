<?php
session_start();
require '../connection.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

// Recibir los filtros
$data = json_decode(file_get_contents("php://input"), true);
$pais = $data['pais'] ?? '';
$habilidad = $data['habilidad'] ?? '';
$nombre = $data['nombre'] ?? '';
$usuario_id = $_SESSION['usuario_id'];

// Construir consulta dinámica
$query = "
    SELECT p.*, u.usuario AS creador_usuario
    FROM proyectos p
    LEFT JOIN usuarios u ON p.creador_id = u.id
    WHERE p.id NOT IN (
        SELECT proyecto_id
        FROM participantes_proyecto
        WHERE usuario_id = :usuario_id
    )
";
$params = [':usuario_id' => $usuario_id];

// Filtro por país
if (!empty($pais)) {
    $query .= " AND p.pais = :pais";
    $params[':pais'] = $pais;
}

// Filtro por habilidad
if (!empty($habilidad)) {
    $query .= " AND p.id IN (
        SELECT proyecto_id
        FROM proyecto_habilidades
        WHERE habilidad_id = :habilidad
    )";
    $params[':habilidad'] = $habilidad;
}

// Filtro por nombre
if (!empty($nombre)) {
    $query .= " AND p.nombre LIKE :nombre";
    $params[':nombre'] = "%$nombre%";
}

// Ordenar por nombre del proyecto
$query .= " ORDER BY p.nombre ASC";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Devolver los proyectos como JSON
    echo json_encode($proyectos);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al obtener proyectos", "error" => $e->getMessage()]);
}

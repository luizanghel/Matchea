<?php
session_start();
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$usuario_id = $_SESSION['usuario_id'];
$project_id = $data['project_id'] ?? null;

if (!$project_id) {
    echo json_encode(['success' => false, 'message' => 'ID del proyecto no proporcionado.']);
    exit;
}

try {
    $query = "INSERT INTO participantes_proyecto (proyecto_id, usuario_id, rol, fecha_union) VALUES (:project_id, :user_id, 'Miembro', NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':project_id', $project_id);
    $stmt->bindParam(':user_id', $usuario_id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Unido al proyecto exitosamente.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al unirse al proyecto: ' . $e->getMessage()]);
}

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
    $query = "DELETE FROM participantes_proyecto WHERE proyecto_id = :project_id AND usuario_id = :usuario_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Has salido del proyecto exitosamente.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al salir del proyecto: ' . $e->getMessage()]);
}

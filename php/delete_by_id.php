<?php
require '../connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    $table = $data['table'] ?? null;

    if (!$id || !$table) {
        echo json_encode(['success' => false, 'message' => 'ID o tabla no proporcionados.']);
        exit;
    }

    try {
        $query = "DELETE FROM $table WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Elemento eliminado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el elemento: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

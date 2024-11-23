<?php
session_start();
require '../connection.php';

header('Content-Type: application/json');

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "message" => "No estás autenticado."]);
    exit;
}

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
    exit;
}

// Decodificar el cuerpo de la solicitud
$input = json_decode(file_get_contents('php://input'), true);
$proyecto_id = $input['proyecto_id'] ?? null;

if (!$proyecto_id) {
    echo json_encode(["success" => false, "message" => "ID del proyecto no proporcionado."]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

try {
    // Verificar si ya es participante
    $checkQuery = "SELECT * FROM participantes_proyecto WHERE proyecto_id = :proyecto_id AND usuario_id = :usuario_id";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bindParam(':proyecto_id', $proyecto_id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Ya estás unido a este proyecto."]);
        exit;
    }

    // Insertar el nuevo participante
    $insertQuery = "INSERT INTO participantes_proyecto (proyecto_id, usuario_id, rol, fecha_union) VALUES (:proyecto_id, :usuario_id, 'Colaborador', NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bindParam(':proyecto_id', $proyecto_id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Te has unido al proyecto correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al unirse al proyecto."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $apiKey = '47ba1cbd3f5c9f43eb468b093398333a';

    // Validar el formato del email localmente antes de usar la API
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['valid' => false, 'message' => 'El formato del correo electrónico no es válido.']);
        exit;
    }

    // Generar URL de la API
    $url = "http://apilayer.net/api/check?access_key=$apiKey&email=" . urlencode($email) . "&smtp=1&format=1";

    $response = file_get_contents($url);
    if ($response === false) {
        echo json_encode(['valid' => false, 'message' => 'Error al conectar con la API.']);
        exit;
    }

    $data = json_decode($response, true);

    // Validar si hay un error en la respuesta de la API
    if (isset($data['error'])) {
        echo json_encode(['valid' => false, 'message' => 'Error de la API: ' . $data['error']['info']]);
        exit;
    }

    // Procesar la respuesta de la API
    if ($data['format_valid']) {
        echo json_encode(['valid' => true, 'message' => 'El correo electrónico es válido.']);
    } else {
        $reason = !$data['format_valid'] ? 'Formato inválido.' : 'Dominio no encontrado.';
        echo json_encode(['valid' => false, 'message' => $reason]);
    }
    
    exit;
} else {
    echo json_encode(['valid' => false, 'message' => 'No se recibió un email válido.']);
    exit;
}

<?php
session_start();
require '../connection.php'; 

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    // Verificar el token de reCAPTCHA
    $recaptchaSecret = '6Le2Z4UqAAAAAGYCXvK7cyGzTX1lyF5RZ_Mfq8eT';
    // $recaptchaSecret = '6LcmT4UqAAAAAFuHMWfH6e4UPDkgQdxfDChA2c3';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    if (empty($recaptchaResponse)) {
        die('Captcha no válido. Intenta de nuevo.');
    }

    $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($verifyURL . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        die('Captcha no válido. Intenta de nuevo.');
    }

    // Procesar datos del formulario
    $nombre = trim($_POST['first-name']);
    $apellido = trim($_POST['last-name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $pais = trim($_POST['country']);

    // Validación básica
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($pais)) {
        die('Por favor, completa todos los campos.');
    }

    // Validar formato del email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Correo electrónico no válido.');
    }

    // Generar un nombre de usuario único
    require 'autouser.php';
    $usuario = generateUniqueUsername($nombre, $apellido, $conn);

    // Cifrar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insertar en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email, usuario, contrasena, pais, tipo, estado) 
                VALUES (:nombre, :email, :usuario, :contrasena, :pais, 'usuario', 'activo')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->bindParam(':pais', $pais);
        $stmt->execute();

        // Iniciar sesión del usuario recién registrado
        $_SESSION['usuario_id'] = $conn->lastInsertId();
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['usuario'] = $usuario;

        // Redirigir al dashboard
        header("Location: ../dashboard.php");
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { // Error por clave duplicada
            die('El correo electrónico ya está registrado.');
        } else {
            die('Error: ' . $e->getMessage());
        }
    }
} else {
    die('Acceso no autorizado.');
}

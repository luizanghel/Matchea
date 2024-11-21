<?php
session_start();
require '../connection.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar datos del formulario
    if (empty($email) || empty($password)) {
        die('Por favor, completa todos los campos.');
    }

    // Consultar el usuario por correo electrónico
    $sql = "SELECT id, nombre, usuario, contrasena FROM usuarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['contrasena'])) {
        // Credenciales válidas, iniciar sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['usuario'] = $usuario['usuario'];

        // Redirigir al dashboard
        header("Location: ../dashboard.php");
        exit;
    } else {
        // Credenciales inválidas
        header("Location: ../index.php?login_error=1");
        exit;
    }
} else {
    // Método de solicitud no válido
    header("Location: ../index.php");
    exit;
}

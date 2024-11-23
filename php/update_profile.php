<?php
session_start();
require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['usuario_id'];
    $nombre = trim($_POST['nombre']);
    $password = trim($_POST['password']);
    $foto = $_FILES['foto'];

    try {
        // Actualizar nombre
        $query = "UPDATE usuarios SET nombre = :nombre WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();

        // Actualizar contraseña si no está vacía
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE usuarios SET contrasena = :contrasena WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':contrasena', $hashedPassword);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
        }

        // Procesar subida de imagen
        if ($foto['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/profile_pictures/';
            $fileName = uniqid() . '_' . basename($foto['name']);
            $uploadFile = $uploadDir . $fileName;

            // Validar tipo de archivo
            $fileType = mime_content_type($foto['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception("Formato de archivo no permitido. Solo se aceptan JPEG, PNG y GIF.");
            }

            // Verificar si existe una foto anterior
            $query = "SELECT foto FROM usuarios WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($user['foto'])) {
                $oldPhotoPath = $uploadDir . $user['foto'];
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath); // Borra la foto anterior
                }
            }

            // Mover el archivo al directorio de uploads
            if (!move_uploaded_file($foto['tmp_name'], $uploadFile)) {
                throw new Exception("Error al subir la foto.");
            }

            // Actualizar el campo de la foto en la base de datos
            $query = "UPDATE usuarios SET foto = :foto WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':foto', $fileName);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
        }

        $_SESSION['success_message'] = "Perfil actualizado correctamente.";
        header("Location: ../perfil.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: ../perfil.php");
        exit;
    }
}
?>

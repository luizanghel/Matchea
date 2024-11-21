<?php
function generateUniqueUsername($nombre, $apellido, $conn) {
    // Convertir a minúsculas y eliminar espacios
    $nombre = strtolower(trim($nombre));
    $apellido = strtolower(trim($apellido));

    // Generar el nombre de usuario inicial
    $username = substr($nombre, 0, 1) . $apellido; // Ejemplo: jdoe
    $originalUsername = $username;
    $counter = 1;

    // Verificar si el nombre de usuario ya existe
    while (true) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $username);
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        if ($exists == 0) {
            // Si no existe, es único
            return $username;
        }

        // Si existe, ampliar el username
        if ($counter <= strlen($nombre)) {
            $username = substr($nombre, 0, $counter) . $apellido;
        } else {
            $username = $originalUsername . $counter; // Agregar números al final
        }

        $counter++;
    }
}

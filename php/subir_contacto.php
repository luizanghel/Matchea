<?php
// submit_form.php

// Comprobar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Simular el procesamiento del formulario (ej: guardarlo en una base de datos, enviar un correo, etc.)
    // Este es un lugar para agregar lógica específica según lo que necesites hacer con la información enviada.

    // Redirigir al index.php con un mensaje de agradecimiento
    header("Location: ../gracias_form.php");
    exit();
}
?>

<!-- index.php -->
<?php
// index.php
// Comprobar si se ha enviado el formulario y mostrar un mensaje de agradecimiento si es así
if (isset($_GET['message']) && $_GET['message'] == 'gracias') {
    echo "<script>alert('Gracias por contactar con nosotros. Nos pondremos en contacto contigo pronto.');</script>";
}
?>
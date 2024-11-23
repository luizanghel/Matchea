<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LuizAnghel, EmersonC">
    <meta name="description" content="Web de Matchea">
    <meta name="keywords" content="Startup, Web, Empresa, Emprendimiento ">
    <meta name="copyright" content="Luiz_Anghel">
    <title>Sobre Nosotros - StartUP</title>
    <link rel="stylesheet" href="css/styles_2.css">
    <link rel="stylesheet" href="css/styles_3.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" >
    <link rel="stylesheet" href="css/signup_modal.css"> <!-- CSS adicional para el modal -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Header fijo con navegación -->
    <header class="header">
        <!-- HEADER -->
        <!-- Header fijo con navegación -->
        <?php include 'php/header.php'; ?> 
    </header>
    
    <main class="gracias-section">
        <div class="text-center">
            <h2>Gracias por conectarte con nosotros</h2>
            <p>Nos alegra que hayas visitado nuestra página. Esperamos que encuentres lo que buscas y disfrutes de nuestros servicios.</p>
            <form action="index.php" method="get">
                <button type="submit" class="btn btn-primary">Finalizar</button>
            </form>
        </div>
    </main>

    <?php include 'php/footer.php'; ?>
   
    <link rel="stylesheet" href="css/responsive.css">
</body>

<script defer src="js/signup_modal.js"></script>
<script src="js/menu_toggle.js" defer></script>
</html>

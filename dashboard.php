<?php
session_start();

// Redirigir si el usuario no está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

// Variables de sesión disponibles
$nombre = $_SESSION['nombre'];
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles_2.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'php/dashboard_header.php'; ?>  
    <main>
        <div id="dashboard" class="container">
            <section class="dashboardintro">
                <h1>¡Bienvenido(a) al Dashboard, <?php echo $_SESSION['nombre']; ?>!</h1>
                <p>Usuario: <?php echo $_SESSION['usuario']; ?></p>
            </section>

            <section class="dashboard-actions">
                <div class="action-card">
                    <h2>Explorar Proyectos</h2>
                    <p>Encuentra proyectos que se ajusten a tus intereses y habilidades.</p>
                    <a href="proyectos.php" class="btn">Ver Proyectos</a>
                </div>

                <div class="action-card">
                    <h2>Editar Perfil</h2>
                    <p>Actualiza tu información personal y habilidades para mejorar tu match.</p>
                    <a href="perfil.php" class="btn">Editar Perfil</a>
                </div>

                <div class="action-card">
                    <h2>Gestionar Habilidades</h2>
                    <p>Agrega o elimina habilidades relevantes para ti.</p>
                    <a href="habilidades.php" class="btn">Gestionar Habilidades</a>
                </div>
            </section>
        </div>
    </main>
    
    <?php include 'php/footer.php'; ?>
</body>




</html>

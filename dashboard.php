<?php
session_start();
require 'connection.php';

// Redirigir si el usuario no está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['usuario_id'];

// Obtén los datos del usuario, incluyendo la foto
$query = "SELECT nombre, foto FROM usuarios WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: index.php");
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
                <?php if (!empty($user['foto'])): ?>
                    <img src="/Matchea/uploads/profile_pictures/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto de perfil" class="foto-perfil">
                <?php endif; ?>
                <h1>¡Bienvenido(a) al Dashboard, <?php echo htmlspecialchars($user['nombre']); ?>!</h1>
                <p>Usuario: <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
            </section>

            <section class="dashboard-actions">
                <div class="action-card">
                    <h2>Explorar Proyectos</h2>
                    <p>Encuentra proyectos que se ajusten a tus intereses y habilidades.</p>
                    <a href="proyectos.php" class="btn">Ver Proyectos</a>
                </div>

                <div class="action-card">
                    <h2>Buscar CoFounder</h2>
                    <p>Explora entre los usuarios y encuentra tu match.</p>
                    <a href="perfil.php" class="btn">Empezar</a>
                </div>

                <div class="action-card">
                    <h2>Cursos</h2>
                    <p>Explora y Encuentra los cursos mas relevantes para ti.</p>
                    <a href="habilidades.php" class="btn">Buscar Cursos</a>
                </div>
            </section>
        </div>
    </main>
    
    <?php include 'php/footer.php'; ?>
</body>




</html>

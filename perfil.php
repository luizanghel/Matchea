<?php
session_start();
require 'connection.php'; // Asegúrate de que este archivo está en la ruta correcta.

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

// Obtén el ID del usuario desde la sesión
$user_id = $_SESSION['usuario_id'];

// Obtén los datos del usuario desde la tabla `usuarios`
$query_user = "SELECT * FROM usuarios WHERE id = :id";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: ../index.php");
    exit;
}

// Obtén las habilidades asociadas al usuario desde la tabla `usuario_habilidades`
$query_habilidades = "SELECT habilidades.id, habilidades.nombre 
                      FROM habilidades
                      INNER JOIN usuario_habilidades ON habilidades.id = usuario_habilidades.habilidad_id
                      WHERE usuario_habilidades.usuario_id = :usuario_id";
$stmt_habilidades = $conn->prepare($query_habilidades);
$stmt_habilidades->bindParam(':usuario_id', $user_id, PDO::PARAM_INT);
$stmt_habilidades->execute();
$habilidades = $stmt_habilidades->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/styles_2.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'php/dashboard_header.php'; ?>

    <main>
        <section id="dashboard" class="profile-container">
            <div class="dashboardintro">
                    <?php if (!empty($user['foto'])): ?>
                        <img src="/Matchea/uploads/profile_pictures/<?php echo htmlspecialchars($user['foto']); ?>" alt="Foto de perfil" class="foto-perfil">
                    <?php endif; ?>
                <h1><?php echo htmlspecialchars($user['nombre']); ?></h1>
                <?php echo htmlspecialchars($user['usuario']); ?>
            </div>
            

            <form action="./php/update_profile.php" method="POST" enctype="multipart/form-data" class="form-perfil">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Nueva contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Dejar en blanco para no cambiar">
                </div>
                
                <div class="form-group">
                    <label for="foto">Foto de perfil:</label>
                    <input type="file" id="foto" name="foto">
                    
                </div>
                
                <button type="submit" class="btn-actualizar">Actualizar</button>
            </form>

            <h2>Habilidades</h2>
            <?php if (!empty($habilidades)): ?>
                <ul class="lista-habilidades">
                    <?php foreach ($habilidades as $habilidad): ?>
                        <li><?php echo htmlspecialchars($habilidad['nombre']); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tienes habilidades asignadas.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include 'php/footer.php'; ?>
</body>
</html>

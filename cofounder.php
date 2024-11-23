<?php
session_start();
require 'connection.php';

// Redirigir si el usuario no está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

// Variables de sesión
$usuario_id = $_SESSION['usuario_id'];

try {
    // Obtener todos los usuarios excepto el usuario actual
    $queryUsuarios = "
        SELECT u.id, u.nombre, u.usuario, u.email, u.foto
        FROM usuarios u
        WHERE u.id != :usuario_id
        ORDER BY u.nombre ASC
    ";
    $stmtUsuarios = $conn->prepare($queryUsuarios);
    $stmtUsuarios->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtUsuarios->execute();
    $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

    // Obtener habilidades, proyectos y cursos relacionados con los usuarios
    foreach ($usuarios as &$usuario) {
        // Habilidades
        $queryHabilidades = "
            SELECT h.nombre
            FROM usuario_habilidades uh
            JOIN habilidades h ON uh.habilidad_id = h.id
            WHERE uh.usuario_id = :usuario_id
        ";
        $stmtHabilidades = $conn->prepare($queryHabilidades);
        $stmtHabilidades->bindParam(':usuario_id', $usuario['id'], PDO::PARAM_INT);
        $stmtHabilidades->execute();
        $usuario['habilidades'] = $stmtHabilidades->fetchAll(PDO::FETCH_COLUMN);

        // Proyectos
        $queryProyectos = "
            SELECT p.nombre
            FROM participantes_proyecto pp
            JOIN proyectos p ON pp.proyecto_id = p.id
            WHERE pp.usuario_id = :usuario_id
        ";
        $stmtProyectos = $conn->prepare($queryProyectos);
        $stmtProyectos->bindParam(':usuario_id', $usuario['id'], PDO::PARAM_INT);
        $stmtProyectos->execute();
        $usuario['proyectos'] = $stmtProyectos->fetchAll(PDO::FETCH_COLUMN);

        // Cursos
        $queryCursos = "
            SELECT c.titulo
            FROM usuario_cursos uc
            JOIN cursos c ON uc.curso_id = c.id
            WHERE uc.usuario_id = :usuario_id
        ";
        $stmtCursos = $conn->prepare($queryCursos);
        $stmtCursos->bindParam(':usuario_id', $usuario['id'], PDO::PARAM_INT);
        $stmtCursos->execute();
        $usuario['cursos'] = $stmtCursos->fetchAll(PDO::FETCH_COLUMN);
    }
} catch (Exception $e) {
    die("Error al obtener los usuarios: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cofundadores</title>
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
                <h1>Buscar Cofundadores</h1>
                <p>Conecta con otros usuarios para colaborar en proyectos.</p>
            </section>

            <section class="users-list">
                <div class="row">
                    <?php foreach ($usuarios as $usuario): ?>
                        <div class="col-md-4">
                            <div class="card cofounder-card">
                                <div class="card-body text-center">
                                    <?php if ($usuario['foto']): ?>
                                        <img src="uploads/profile_pictures/<?php echo htmlspecialchars($usuario['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($usuario['nombre']); ?>" class="user-photo img-fluid rounded-circle mb-3">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle user-icon"></i>
                                    <?php endif; ?>
                                    <h5 class="card-title"><?php echo htmlspecialchars($usuario['nombre']); ?></h5>
                                    <p class="card-text">
                                        <strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['usuario']); ?><br>
                                        <strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?><br>
                                        <strong>Habilidades:</strong>
                                        <ul>
                                            <?php foreach ($usuario['habilidades'] as $habilidad): ?>
                                                <li><?php echo htmlspecialchars($habilidad); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <strong>Proyectos:</strong>
                                        <ul>
                                            <?php foreach ($usuario['proyectos'] as $proyecto): ?>
                                                <li><?php echo htmlspecialchars($proyecto); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <strong>Cursos:</strong>
                                        <ul>
                                            <?php foreach ($usuario['cursos'] as $curso): ?>
                                                <li><?php echo htmlspecialchars($curso); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </p>
                                    <button class="btn btn-success">Match</button>
                                    <button class="btn btn-primary">Contactar</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </main>

    <?php include 'php/footer.php'; ?>
</body>
</html>

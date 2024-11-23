<?php
session_start();
require 'connection.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

// Variables de sesión
$usuario_id = $_SESSION['usuario_id'];

try {
    // Obtener proyectos donde el usuario es creador
    $queryCreador = "
        SELECT p.*, 
               GROUP_CONCAT(u.usuario SEPARATOR ', ') AS participantes
        FROM proyectos p
        LEFT JOIN participantes_proyecto pp ON p.id = pp.proyecto_id
        LEFT JOIN usuarios u ON pp.usuario_id = u.id
        WHERE p.creador_id = :usuario_id
        GROUP BY p.id
        ORDER BY p.nombre ASC
    ";
    $stmtCreador = $conn->prepare($queryCreador);
    $stmtCreador->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtCreador->execute();
    $proyectosCreados = $stmtCreador->fetchAll(PDO::FETCH_ASSOC);

    // Obtener proyectos donde el usuario es miembro (pero no creador)
    $queryMiembro = "
        SELECT p.*, 
               u.usuario AS creador_usuario, 
               GROUP_CONCAT(up.usuario SEPARATOR ', ') AS participantes
        FROM proyectos p
        LEFT JOIN participantes_proyecto pp ON p.id = pp.proyecto_id
        LEFT JOIN usuarios up ON pp.usuario_id = up.id
        LEFT JOIN usuarios u ON p.creador_id = u.id
        WHERE pp.usuario_id = :usuario_id AND p.creador_id != :creador_id
        GROUP BY p.id
        ORDER BY p.nombre ASC
    ";
    $stmtMiembro = $conn->prepare($queryMiembro);
    $stmtMiembro->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmtMiembro->bindParam(':creador_id', $usuario_id, PDO::PARAM_INT);
    $stmtMiembro->execute();
    $proyectosMiembro = $stmtMiembro->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die("Error al obtener los proyectos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Proyectos</title>
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
                <h1>Mis Proyectos</h1>
                <p>Aquí puedes gestionar tus proyectos.</p>
            </section>

            <!-- Proyectos Creados -->
            <section class="projects-section">
                <h2>Proyectos Creados</h2>
                <div class="row">
                    <?php if (empty($proyectosCreados)): ?>
                        <p>No has creado ningún proyecto.</p>
                    <?php else: ?>
                        <?php foreach ($proyectosCreados as $proyecto): ?>
                            <div class="col-md-4">
                                <div class="card project-card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($proyecto['nombre']); ?></h5>
                                        <p class="card-text">
                                            <strong>Descripción:</strong> <?php echo htmlspecialchars($proyecto['descripcion']); ?><br>
                                            <strong>País:</strong> <?php echo htmlspecialchars($proyecto['pais']); ?><br>
                                            <strong>Participantes:</strong> <?php echo htmlspecialchars($proyecto['participantes']); ?>
                                        </p>
                                        <button class="btn btn-danger delete-project-btn" data-id="<?php echo $proyecto['id']; ?>">Eliminar Proyecto</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Proyectos como Miembro -->
            <section class="projects-section">
                <h2>Proyectos como Miembro</h2>
                <div class="row">
                    <?php if (empty($proyectosMiembro)): ?>
                        <p>No estás unido a ningún proyecto.</p>
                    <?php else: ?>
                        <?php foreach ($proyectosMiembro as $proyecto): ?>
                            <div class="col-md-4">
                                <div class="card project-card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($proyecto['nombre']); ?></h5>
                                        <p class="card-text">
                                            <strong>Creador:</strong> <?php echo htmlspecialchars($proyecto['creador_usuario']); ?><br>
                                            <strong>Descripción:</strong> <?php echo htmlspecialchars($proyecto['descripcion']); ?><br>
                                            <strong>País:</strong> <?php echo htmlspecialchars($proyecto['pais']); ?><br>
                                            <strong>Participantes:</strong> <?php echo htmlspecialchars($proyecto['participantes']); ?>
                                        </p>
                                        <button class="btn btn-danger leave-project-btn" data-id="<?php echo $proyecto['id']; ?>">Salir del Proyecto</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </main>

    <?php include 'php/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Eliminar proyecto
            document.querySelectorAll('.delete-project-btn').forEach(button => {
                button.addEventListener('click', async () => {
                    const projectId = button.getAttribute('data-id');
                    if (confirm('¿Estás seguro de que deseas eliminar este proyecto?')) {
                        try {
                            const response = await fetch('php/delete_by_id.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ id: projectId, table: 'proyectos' }),
                            });
                            const result = await response.json();
                            if (result.success) {
                                alert('Proyecto eliminado exitosamente.');
                                location.reload();
                            } else {
                                alert(result.message || 'Error al eliminar el proyecto.');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                });
            });

            // Salir del proyecto
            document.querySelectorAll('.leave-project-btn').forEach(button => {
                button.addEventListener('click', async () => {
                    const projectId = button.getAttribute('data-id');
                    if (confirm('¿Estás seguro de que deseas salir de este proyecto?')) {
                        try {
                            const response = await fetch('php/leave_project.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ project_id: projectId }),
                            });
                            const result = await response.json();
                            if (result.success) {
                                alert('Has salido del proyecto exitosamente.');
                                location.reload();
                            } else {
                                alert(result.message || 'Error al salir del proyecto.');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>

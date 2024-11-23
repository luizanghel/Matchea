<?php
session_start();
require 'connection.php';

// Redirigir si el usuario no está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit;
}

// Variables de sesión disponibles
$nombre = $_SESSION['nombre'];
$usuario = $_SESSION['usuario'];
$usuario_id = $_SESSION['usuario_id'];

// Obtener proyectos (excluyendo los del usuario actual)
try {
    // Consulta para obtener proyectos en los que el usuario no participa
    $query = "
        SELECT p.*, u.usuario AS creador_usuario
        FROM proyectos p
        LEFT JOIN usuarios u ON p.creador_id = u.id
        WHERE p.id NOT IN (
            SELECT proyecto_id
            FROM participantes_proyecto
            WHERE usuario_id = :usuario_id
        )
        ORDER BY p.nombre ASC;
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error al obtener los proyectos: " . $e->getMessage());
}

// Obtener habilidades para el filtro
$query_habilidades = "SELECT * FROM habilidades";
$stmt_habilidades = $conn->prepare($query_habilidades);
$stmt_habilidades->execute();
$habilidades = $stmt_habilidades->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
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
                <h1>Explorador de Proyectos</h1>
                <p>Usuario: <?php echo htmlspecialchars($_SESSION['usuario']); ?></p>
            </section>

            <!-- Filtros -->
            <section class="filters">
                <form id="filter-form" method="GET" action="proyectos.php">
                    <div class="form-group">
                        <label>País:</label>
                        <select id="filter-project-country" name="filter-project-country" required><option value="">Todos los países</option></select>
                    </div>

                    <div class="form-group">
                        <label for="habilidad">Habilidad:</label>
                        <select id="habilidad" name="habilidad">
                            <option value="">Todas</option>
                            <?php foreach ($habilidades as $habilidad): ?>
                                <option value="<?php echo htmlspecialchars($habilidad['id']); ?>">
                                    <?php echo htmlspecialchars($habilidad['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nombre">Nombre del Proyecto:</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Buscar proyectos">
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </section>

            <!-- Listado de Proyectos -->
            <section class="projects-list">
                <div class="row">
                    <?php foreach ($proyectos as $proyecto): ?>
                        <div class="col-md-4">
                        <div class="card project-card" data-pais="<?php echo htmlspecialchars($proyecto['pais']); ?>" 
                        data-habilidades="<?php echo implode(',', $proyecto['habilidades'] ?? []); ?>">
                            
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($proyecto['nombre']); ?></h5>
                                    <p class="card-text">
                                        <strong>Usuario Principal:</strong> <?php echo htmlspecialchars($proyecto['creador_usuario']); ?><br>
                                        <strong>Descripción:</strong> <?php echo htmlspecialchars($proyecto['descripcion']); ?>
                                    </p>
                                    <button class="btn btn-info project-btn-detalle" 
                                            data-id="<?php echo $proyecto['id']; ?>">Ver Detalles</button>
                                    <button class="btn btn-success project-btn-match" 
                                            data-id="<?php echo $proyecto['id']; ?>">Match</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </main>

    <?php include 'php/footer.php'; ?>

    <!-- Modal de Detalles del Proyecto -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <span class="project-close-button">&times;</span>
            <h2 id="modal-title">Detalles del Proyecto</h2>
            <p id="modal-pais"></p>
            <p id="modal-description"></p>
            <div id="modal-habilidades"></div>
            <div id="modal-usuarios"></div>
            <div class="modal-navigation">
                <button id="prev-project" class="btn btn-secondary">Anterior</button>
                <button id="next-project" class="btn btn-secondary">Siguiente</button>
            </div>
            <button id="modal-match" class="btn btn-success">Match</button>
            <button id="close-modal" class="btn btn-danger">Cerrar</button>
        </div>
    </div>
    <script src="js/filter.js"></script>
    <script src="js/countries.js"></script>
    <script src="js/proyectos.js"></script>

</body>
</html>

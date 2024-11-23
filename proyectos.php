<?php
session_start();
require 'connection.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Variables de sesión
$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];

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
                <p>Bienvenido, <?php echo htmlspecialchars($nombre); ?></p>
            </section>

            <!-- Filtros -->
            <section class="filters">
                <form id="filter-form" method="POST">
                    <div class="form-group">
                        <label for="filter-project-country">País:</label>
                        <select id="filter-project-country" name="pais">
                            <option value="">Todos los países</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter-project-skill">Habilidad:</label>
                        <select id="filter-project-skill" name="habilidad">
                            <option value="">Todas</option>
                            <?php foreach ($habilidades as $habilidad): ?>
                                <option value="<?php echo htmlspecialchars($habilidad['id']); ?>">
                                    <?php echo htmlspecialchars($habilidad['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filter-project-name">Nombre del Proyecto:</label>
                        <input type="text" id="filter-project-name" name="nombre" placeholder="Buscar proyectos">
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </section>

            <!-- Listado de Proyectos -->
            <section class="projects-list">
                <div class="row">
                    <!-- Proyectos dinámicos cargados con AJAX -->
                </div>
            </section>
        </div>
    </main>

    <?php include 'php/footer.php'; ?>

    <!-- Modal -->
    <!-- Modal -->
    <!-- Modal -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <span class="project-close-button">&times;</span>
            <h2 id="modal-title">Detalles del Proyecto</h2>
            <p id="modal-pais"></p>
            <p id="modal-description"></p>
            <div id="modal-habilidades"></div>
            <div id="modal-usuarios"></div>

            <!-- Botón Match -->
            <div id="modal-match">
                <button id="match-project" class="btn btn-success" data-id="<?php echo $proyecto['id']; ?>">Match</button>
            </div>

            <div class="modal-navigation">
                <button id="prev-project" class="btn btn-secondary">Anterior</button>
                <button id="next-project" class="btn btn-secondary">Siguiente</button>
            </div>
            <button id="close-modal" class="btn btn-danger">Cerrar</button>
        </div>
    </div>



    <script src="js/paises_filtro.js"></script>
    <script src="js/filter.js"></script>
</body>
</html>

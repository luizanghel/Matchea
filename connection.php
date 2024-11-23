<?php
// Cargar el autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Verificar si el archivo .env existe
$dotenvPath = __DIR__ . '/.env';
if (!file_exists($dotenvPath)) {
    die('El archivo .env no existe. Asegúrate de que esté en la carpeta raíz del proyecto.');
}

// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Obtener las variables de conexión desde el archivo .env
$host = $_ENV['DB_HOST'] ?? 'localhost';
$port = $_ENV['DB_PORT'] ?? '3306';
$database = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';

// Construir el DSN (Data Source Name) para PDO
$link = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

try {
    // Crear la conexión con PDO
    $conn = new PDO($link, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Mensaje de éxito (opcional, solo para pruebas)
    //echo "Conexión exitosa a la base de datos: $database";
} catch (PDOException $e) {
    // Registrar el error en el log del servidor
    error_log("Error de conexión: " . $e->getMessage());
    
    // Mostrar un mensaje genérico al usuario
    die("No se pudo conectar a la base de datos. Intenta nuevamente más tarde.");
}


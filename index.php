<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: php/dashboard.php");
    exit;
}

if (isset($_GET['login_error']) && $_GET['login_error'] == 1) {
    $error_message = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
}


require 'connection.php'; // Conexión a la base de datos
require './php/autouser.php';   // Función para generar nombres de usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $nombre = trim($_POST['first-name']);
    $apellido = trim($_POST['last-name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $pais = trim($_POST['country']);

    // Validación básica
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
        die('Por favor, completa todos los campos obligatorios.');
    }

    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('El formato del correo electrónico no es válido.');
    }

    // Generar un username único
    $usuario = generateUniqueUsername($nombre, $apellido, $conn);

    // Cifrar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO usuarios (nombre, email, usuario, contrasena, pais) VALUES (:nombre, :email, :usuario, :contrasena, :pais)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':contrasena', $hashedPassword);
        $stmt->bindParam(':pais', $pais);

        $stmt->execute();
        echo "Usuario registrado con éxito. Tu username es: $usuario";
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') {
            die('El correo electrónico ya está en uso.');
        } else {
            die('Error: ' . $e->getMessage());
        }
    }
}


// Obtener todas las tareas
// $querySelectAll = "SELECT * FROM matchea";
// $sqlSelectAll = $conn->prepare($querySelectAll);
// $sqlSelectAll->execute();
// $resultado = $sqlSelectAll->fetchAll();



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LuizAnghel, EmersonC">
    <meta name="description" content="Web de Matchea">
    <meta name="keywords" content="Startup, Web, Empresa, Emprendimiento ">
    <meta name="copyright" content="Luiz_Anghel">
    <link rel="stylesheet" href="css/styles_2.css">
    <link rel="stylesheet" href="css/signup_modal.css"> <!-- CSS adicional para el modal -->
    <title>Matchea</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="imag/x-icon" >
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- HEADER -->
    <!-- Header fijo con navegación -->
    <?php include 'php/header.php'; ?>    

    <main>
        <!-- Sección de Introducción -->
        <section class="intro">
            <div class="container intro-grid">
                <div class="intro-text">
                    <h1>Bienvenido a Matchea</h1>
                    <p>Encuentra a tu equipo para emprender. Nostros te ayudamos a encontrar el match perfecto y hacer conexiones duraderas.</p>
                    <button class="signup-button" id="signupButtonIntro"> Registrate</button>
                </div>
                <div class="intro-image">
                    <img src="img/Intro.png" alt="Illustration of people connecting">
                </div>
            </div>

            <div class="wave-container">
                <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 500" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150">
                    <style>
                        .path-0 {
                            animation: pathAnim-0 4s linear infinite;
                        }
                        @keyframes pathAnim-0 {
                            0% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                            25% {
                                d: path("M 0,500 L 0,187 C 68.27179487179487,141.54102564102564 136.54358974358973,96.0820512820513 210,111 C 283.45641025641027,125.9179487179487 362.09743589743584,201.2128205128205 442,222 C 521.9025641025642,242.7871794871795 603.0666666666668,209.06666666666663 699,187 C 794.9333333333332,164.93333333333337 905.6358974358975,154.52051282051283 986,176 C 1066.3641025641025,197.47948717948717 1116.3897435897436,250.85128205128206 1187,258 C 1257.6102564102564,265.14871794871794 1348.8051282051283,226.07435897435897 1440,187 L 1440,500 L 0,500 Z");
                            }
                            50% {
                                d: path("M 0,500 L 0,187 C 97.03333333333333,207.8230769230769 194.06666666666666,228.64615384615382 277,259 C 359.93333333333334,289.3538461538462 428.76666666666665,329.2384615384616 495,281 C 561.2333333333333,232.76153846153844 624.8666666666667,96.40000000000002 696,100 C 767.1333333333333,103.59999999999998 845.7666666666667,247.16153846153844 928,266 C 1010.2333333333333,284.83846153846156 1096.0666666666666,178.95384615384614 1182,145 C 1267.9333333333334,111.04615384615384 1353.9666666666667,149.02307692307693 1440,187 L 1440,500 L 0,500 Z");
                            }
                            75% {
                                d: path("M 0,500 L 0,187 C 66.07179487179488,152.82820512820513 132.14358974358976,118.65641025641025 217,108 C 301.85641025641024,97.34358974358975 405.4974358974358,110.20256410256411 491,121 C 576.5025641025642,131.7974358974359 643.8666666666668,140.53333333333333 717,128 C 790.1333333333332,115.46666666666667 869.0358974358974,81.66410256410256 961,104 C 1052.9641025641026,126.33589743589744 1157.9897435897437,204.81025641025641 1240,228 C 1322.0102564102563,251.18974358974359 1381.0051282051281,219.09487179487178 1440,187 L 1440,500 L 0,500 Z");
                            }
                            100% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                        }
                    </style>
                    <path d="M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z" stroke="none" stroke-width="0" fill="#eef5ff" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
                </svg>
            </div>
            
        </section>
        
        <section class="cuerpo_celeste">
            <div class="container">
                <h2>Somos una Comunidad Global</h2>
                <p>Matchea es más que una plataforma: es el puente que conecta emprendedores apasionados de todo el mundo. Encuentra a tu cofundador ideal o forma el equipo emprendedor que hará realidad tus ideas. Juntos, creamos conexiones que transforman sueños en negocios exitosos.</p>
            </div>
            <div class="cuerpo-image">
                <img src="img/mallamatch.png" alt="Illustration of people connecting">
            </div>
            <div class="wave-container-cuerpo">
                <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 300" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150">
                    <style>
                        .path-0 {
                            animation: pathAnim-0 4s linear infinite;
                        }
                        @keyframes pathAnim-0 {
                            0% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                            25% {
                                d: path("M 0,500 L 0,187 C 68.27179487179487,141.54102564102564 136.54358974358973,96.0820512820513 210,111 C 283.45641025641027,125.9179487179487 362.09743589743584,201.2128205128205 442,222 C 521.9025641025642,242.7871794871795 603.0666666666668,209.06666666666663 699,187 C 794.9333333333332,164.93333333333337 905.6358974358975,154.52051282051283 986,176 C 1066.3641025641025,197.47948717948717 1116.3897435897436,250.85128205128206 1187,258 C 1257.6102564102564,265.14871794871794 1348.8051282051283,226.07435897435897 1440,187 L 1440,500 L 0,500 Z");
                            }
                            50% {
                                d: path("M 0,500 L 0,187 C 97.03333333333333,207.8230769230769 194.06666666666666,228.64615384615382 277,259 C 359.93333333333334,289.3538461538462 428.76666666666665,329.2384615384616 495,281 C 561.2333333333333,232.76153846153844 624.8666666666667,96.40000000000002 696,100 C 767.1333333333333,103.59999999999998 845.7666666666667,247.16153846153844 928,266 C 1010.2333333333333,284.83846153846156 1096.0666666666666,178.95384615384614 1182,145 C 1267.9333333333334,111.04615384615384 1353.9666666666667,149.02307692307693 1440,187 L 1440,500 L 0,500 Z");
                            }
                            75% {
                                d: path("M 0,500 L 0,187 C 66.07179487179488,152.82820512820513 132.14358974358976,118.65641025641025 217,108 C 301.85641025641024,97.34358974358975 405.4974358974358,110.20256410256411 491,121 C 576.5025641025642,131.7974358974359 643.8666666666668,140.53333333333333 717,128 C 790.1333333333332,115.46666666666667 869.0358974358974,81.66410256410256 961,104 C 1052.9641025641026,126.33589743589744 1157.9897435897437,204.81025641025641 1240,228 C 1322.0102564102563,251.18974358974359 1381.0051282051281,219.09487179487178 1440,187 L 1440,500 L 0,500 Z");
                            }
                            100% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                        }
                    </style>
                    <path d="M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z" stroke="none" stroke-width="0" fill="#fff" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
                </svg>
            </div>

            
        </section>

        <section class="cuerpo_blanco">
            <div class="container">
                <div class="platform-grid">
                    <!-- Descripción del servicio -->
                    <div class="platform-description">
                        <h2>Matchea hace tu búsqueda de socios lo más fácil y efectiva posible.</h2>
                        <p class="full-text">
                            Hemos creado nuestra plataforma y algoritmo de búsqueda para que encontrar una coincidencia sea lo más sencillo posible. 
                            Nuestro sistema de mensajería intuitivo proporciona comunicación rápida y sencilla entre cofundadores. 
                            Además, nuestros filtros te permiten refinar fácilmente el tipo de socio que estás buscando.
                        </p>
                        <p class="summary-text">
                            Encuentra fácilmente a tu socio ideal con nuestro sistema de búsqueda y mensajería.
                        </p>
                    </div>
        
                    <!-- Perfiles -->
                    <div class="profiles">
                        <!-- Perfil de Andrés -->
                        <div class="profile-card profile-andrew">
                            <img src="img/andrew.jpg" alt="Andrew" class="profile-img">
                            <h3>Andrés</h3>
                            <span class="role">Director de Marketing</span>
                            <p>
                                Más de 10 años de experiencia como director de marketing, 7 de los cuales 
                                se dedicaron a hacer crecer startups. Buscando colaborar con nuevas ideas.
                            </p>
                            <button class="quick-view-button">Ver más</button>
                        </div>
        
                        <!-- Perfil de Carlota -->
                        <div class="profile-card profile-carlota">
                            <img src="img/carlota1.jpg" alt="Charlotte" class="profile-img">
                            <h3>Carlota</h3>
                            <span class="role">Diseñadora y Desarrollo de Negocios</span>
                            <p>
                                Una nueva aplicación web que revolucionará la contratación remota. Actualmente está en desarrollo. 
                                Busca socios para lanzar el producto.
                            </p>
                            <button class="quick-view-button">Ver más</button>
                        </div>
                    </div>
        
                    <!-- Chat -->
                    <div class="chat">
                        <div class="chat-messages">
                            <div class="message">
                                <span class="sender">Andrés</span>
                                <span class="time">27/01/2023 20:46</span>
                                <p>Hola Carlota, ¡me interesa tu proyecto!</p>
                            </div>
                            <div class="message">
                                <span class="sender">Carlota</span>
                                <span class="time">27/01/2023 20:48</span>
                                <p>Gracias, Andrés. ¿Podrías agendar una reunión esta semana?</p>
                            </div>
                        </div>
                        <form class="chat-input">
                            <input type="text" placeholder="Escribe tu mensaje aquí..." />
                            <button type="submit">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="wave-container-cuerpo">
                <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 300" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150">
                    <style>
                        .path-0 {
                            animation: pathAnim-0 4s linear infinite;
                        }
                        @keyframes pathAnim-0 {
                            0% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                            25% {
                                d: path("M 0,500 L 0,187 C 68.27179487179487,141.54102564102564 136.54358974358973,96.0820512820513 210,111 C 283.45641025641027,125.9179487179487 362.09743589743584,201.2128205128205 442,222 C 521.9025641025642,242.7871794871795 603.0666666666668,209.06666666666663 699,187 C 794.9333333333332,164.93333333333337 905.6358974358975,154.52051282051283 986,176 C 1066.3641025641025,197.47948717948717 1116.3897435897436,250.85128205128206 1187,258 C 1257.6102564102564,265.14871794871794 1348.8051282051283,226.07435897435897 1440,187 L 1440,500 L 0,500 Z");
                            }
                            50% {
                                d: path("M 0,500 L 0,187 C 97.03333333333333,207.8230769230769 194.06666666666666,228.64615384615382 277,259 C 359.93333333333334,289.3538461538462 428.76666666666665,329.2384615384616 495,281 C 561.2333333333333,232.76153846153844 624.8666666666667,96.40000000000002 696,100 C 767.1333333333333,103.59999999999998 845.7666666666667,247.16153846153844 928,266 C 1010.2333333333333,284.83846153846156 1096.0666666666666,178.95384615384614 1182,145 C 1267.9333333333334,111.04615384615384 1353.9666666666667,149.02307692307693 1440,187 L 1440,500 L 0,500 Z");
                            }
                            75% {
                                d: path("M 0,500 L 0,187 C 66.07179487179488,152.82820512820513 132.14358974358976,118.65641025641025 217,108 C 301.85641025641024,97.34358974358975 405.4974358974358,110.20256410256411 491,121 C 576.5025641025642,131.7974358974359 643.8666666666668,140.53333333333333 717,128 C 790.1333333333332,115.46666666666667 869.0358974358974,81.66410256410256 961,104 C 1052.9641025641026,126.33589743589744 1157.9897435897437,204.81025641025641 1240,228 C 1322.0102564102563,251.18974358974359 1381.0051282051281,219.09487179487178 1440,187 L 1440,500 L 0,500 Z");
                            }
                            100% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                        }
                    </style>
                    <path d="M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z" stroke="none" stroke-width="0" fill="#eef5ff" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
                </svg>
            </div>

            
        </section>

        <section class="cuerpo_celeste">
            <div class="container text-center">
                <h2>¿Por qué asociarte con un cofundador?</h2>
                <p>Aquí tienes algunas buenas razones:</p>
        
                <div class="row mt-5">
                    <!-- Mitigar riesgos para inversores -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-box">
                            <i class="fas fa-shield-alt fa-3x mb-3"></i>
                            <h5>Mitigar riesgos para inversores</h5>
                            <p>
                                Contar con un cofundador reduce los riesgos para los inversores al evitar depender de una sola persona. Esto aumenta la confianza y seguridad de su inversión.
                            </p>
                        </div>
                    </div>
        
                    <!-- Apoyo estratégico -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-box">
                            <i class="fas fa-lightbulb fa-3x mb-3"></i>
                            <h5>Apoyo estratégico</h5>
                            <p>
                                Tomar decisiones clave puede ser más sencillo cuando tienes alguien con quien contrastar ideas y descubrir aspectos que podrías haber pasado por alto.
                            </p>
                        </div>
                    </div>
        
                    <!-- División de responsabilidades -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-box">
                            <i class="fas fa-balance-scale fa-3x mb-3"></i>
                            <h5>División de responsabilidades</h5>
                            <p>
                                Un cofundador puede aliviar el estrés y permitirte concentrarte en áreas clave mientras divide el trabajo diario de gestionar el negocio.
                            </p>
                        </div>
                    </div>
                </div>
        
                <div class="row">
                    <!-- Habilidades complementarias -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-box">
                            <i class="fas fa-tools fa-3x mb-3"></i>
                            <h5>Habilidades complementarias</h5>
                            <p>
                                Un cofundador puede aportar habilidades que complementen las tuyas, acelerando el éxito de tu negocio y llenando vacíos en tu equipo.
                            </p>
                        </div>
                    </div>
        
                    <!-- Tiempo más rápido para lanzar -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-box">
                            <i class="fas fa-rocket fa-3x mb-3"></i>
                            <h5>Lanzamiento más rápido</h5>
                            <p>
                                Dividir el trabajo permite acelerar los tiempos para desarrollar y lanzar un producto mínimo viable (MVP), logrando resultados más rápidos.
                            </p>
                        </div>
                    </div>
        
                    <!-- Reducción de gastos iniciales -->
                    <div class="col-md-4 mb-4">
                        <div class="icon-box">
                            <i class="fas fa-piggy-bank fa-3x mb-3"></i>
                            <h5>Reducción de gastos iniciales</h5>
                            <p>
                                Compartir los costos iniciales con un cofundador hace más accesible el desarrollo de un prototipo o producto funcional, aumentando las posibilidades de éxito.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wave-container-cuerpo">
                <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 300" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150">
                    <style>
                        .path-0 {
                            animation: pathAnim-0 4s linear infinite;
                        }
                        @keyframes pathAnim-0 {
                            0% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                            25% {
                                d: path("M 0,500 L 0,187 C 68.27179487179487,141.54102564102564 136.54358974358973,96.0820512820513 210,111 C 283.45641025641027,125.9179487179487 362.09743589743584,201.2128205128205 442,222 C 521.9025641025642,242.7871794871795 603.0666666666668,209.06666666666663 699,187 C 794.9333333333332,164.93333333333337 905.6358974358975,154.52051282051283 986,176 C 1066.3641025641025,197.47948717948717 1116.3897435897436,250.85128205128206 1187,258 C 1257.6102564102564,265.14871794871794 1348.8051282051283,226.07435897435897 1440,187 L 1440,500 L 0,500 Z");
                            }
                            50% {
                                d: path("M 0,500 L 0,187 C 97.03333333333333,207.8230769230769 194.06666666666666,228.64615384615382 277,259 C 359.93333333333334,289.3538461538462 428.76666666666665,329.2384615384616 495,281 C 561.2333333333333,232.76153846153844 624.8666666666667,96.40000000000002 696,100 C 767.1333333333333,103.59999999999998 845.7666666666667,247.16153846153844 928,266 C 1010.2333333333333,284.83846153846156 1096.0666666666666,178.95384615384614 1182,145 C 1267.9333333333334,111.04615384615384 1353.9666666666667,149.02307692307693 1440,187 L 1440,500 L 0,500 Z");
                            }
                            75% {
                                d: path("M 0,500 L 0,187 C 66.07179487179488,152.82820512820513 132.14358974358976,118.65641025641025 217,108 C 301.85641025641024,97.34358974358975 405.4974358974358,110.20256410256411 491,121 C 576.5025641025642,131.7974358974359 643.8666666666668,140.53333333333333 717,128 C 790.1333333333332,115.46666666666667 869.0358974358974,81.66410256410256 961,104 C 1052.9641025641026,126.33589743589744 1157.9897435897437,204.81025641025641 1240,228 C 1322.0102564102563,251.18974358974359 1381.0051282051281,219.09487179487178 1440,187 L 1440,500 L 0,500 Z");
                            }
                            100% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                        }
                    </style>
                    <path d="M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z" stroke="none" stroke-width="0" fill="#fff" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
                </svg>
            </div>

            
        </section>

        <section class="cuerpo_blanco">
            <div class="container text-center">
                <h2>¿CÓMO FUNCIONA?</h2>
                <div class="video-container">
                    <video controls>
                        <source src="video/Matchea.mp4" type="video/mp4">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                </div>
            </div>

            <div class="wave-container-cuerpo">
                <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 300" xmlns="http://www.w3.org/2000/svg" class="transition duration-300 ease-in-out delay-150">
                    <style>
                        .path-0 {
                            animation: pathAnim-0 4s linear infinite;
                        }
                        @keyframes pathAnim-0 {
                            0% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                            25% {
                                d: path("M 0,500 L 0,187 C 68.27179487179487,141.54102564102564 136.54358974358973,96.0820512820513 210,111 C 283.45641025641027,125.9179487179487 362.09743589743584,201.2128205128205 442,222 C 521.9025641025642,242.7871794871795 603.0666666666668,209.06666666666663 699,187 C 794.9333333333332,164.93333333333337 905.6358974358975,154.52051282051283 986,176 C 1066.3641025641025,197.47948717948717 1116.3897435897436,250.85128205128206 1187,258 C 1257.6102564102564,265.14871794871794 1348.8051282051283,226.07435897435897 1440,187 L 1440,500 L 0,500 Z");
                            }
                            50% {
                                d: path("M 0,500 L 0,187 C 97.03333333333333,207.8230769230769 194.06666666666666,228.64615384615382 277,259 C 359.93333333333334,289.3538461538462 428.76666666666665,329.2384615384616 495,281 C 561.2333333333333,232.76153846153844 624.8666666666667,96.40000000000002 696,100 C 767.1333333333333,103.59999999999998 845.7666666666667,247.16153846153844 928,266 C 1010.2333333333333,284.83846153846156 1096.0666666666666,178.95384615384614 1182,145 C 1267.9333333333334,111.04615384615384 1353.9666666666667,149.02307692307693 1440,187 L 1440,500 L 0,500 Z");
                            }
                            75% {
                                d: path("M 0,500 L 0,187 C 66.07179487179488,152.82820512820513 132.14358974358976,118.65641025641025 217,108 C 301.85641025641024,97.34358974358975 405.4974358974358,110.20256410256411 491,121 C 576.5025641025642,131.7974358974359 643.8666666666668,140.53333333333333 717,128 C 790.1333333333332,115.46666666666667 869.0358974358974,81.66410256410256 961,104 C 1052.9641025641026,126.33589743589744 1157.9897435897437,204.81025641025641 1240,228 C 1322.0102564102563,251.18974358974359 1381.0051282051281,219.09487179487178 1440,187 L 1440,500 L 0,500 Z");
                            }
                            100% {
                                d: path("M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z");
                            }
                        }
                    </style>
                    <path d="M 0,500 L 0,187 C 60.36153846153846,192.34358974358975 120.72307692307692,197.6871794871795 206,215 C 291.2769230769231,232.3128205128205 401.4692307692309,261.5948717948718 497,280 C 592.5307692307691,298.4051282051282 673.3999999999999,305.9333333333334 760,280 C 846.6000000000001,254.06666666666663 938.9307692307693,194.6717948717949 999,174 C 1059.0692307692307,153.3282051282051 1086.876923076923,171.37948717948717 1155,180 C 1223.123076923077,188.62051282051283 1331.5615384615385,187.81025641025641 1440,187 L 1440,500 L 0,500 Z" stroke="none" stroke-width="0" fill="#eef5ff" fill-opacity="1" class="transition-all duration-300 ease-in-out delay-150 path-0"></path>
                </svg>
            </div>

            
        </section>

    </main>

    
    <!-- TODO Cambiar el logotipo y mejorar los imagenes, verificar si estas quedaran -->

    <!-- FIXME NO PUEDO HACER EL BOTON TAL   -->

    <?php include 'php/footer.php'; ?>

</body>


<script src="js/wave.js"></script>
<script defer src="js/signup_modal.js"></script>
<script src="js/menu_toggle.js" defer></script>
<script src="js/chat-input.js"></script>



</html>
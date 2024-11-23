<!-- About.html -->
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
    <link rel="stylesheet" href="css/signup_modal.css"> <!-- CSS adicional para el modal -->
    <link rel="shortcut icon" href="img/favicon.ico" type="imag/x-icon" >
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
    
    <!-- Sección de Introducción -->
    <section class="hero">
        
            <div class="hero-content">
                <h1>Sobre Nosotros</h1>
                <p>Somos Matchea que es una plataforma global para emprendedores donde puedes encontrar tu equipo ideal para emprender y hacer realidad tus ideas. Conecta con cofundadores y forma asociaciones que trascienden fronteras, utilizando nuestro innovador sistema de coincidencias y mensajería intuitiva. Simplificamos la búsqueda de socios para crear empresas exitosas juntos.</p>
            </div>
            <div class="hero-image">
                <img src="https://services.meteored.com/img/article/rowing-team-crosses-the-atlantic-data-from-the-trek-lends-new-information-about-the-limits-of-the-human-body-1697070035671_1024.png" alt="Nuestro equipo trabajando juntos" >
        
            </div>
       
    </section>
    
    <!-- Sección de Misión -->
    <section class="mission">
        <div class="container">
            <h2>Nuestra Misión</h2>
            <p>Nuestra misión es conectar emprendedores apasionados de todo el mundo, ayudándoles a encontrar cofundadores y formar equipos sólidos que impulsen la creación de nuevas empresas y proyectos innovadores. Matchea busca ser un puente para transformar ideas en realidades, fomentando conexiones significativas y colaboraciones duraderas</p>
        </div>
    </section>
    
    <!-- Sección del Equipo -->
    <section class="team">
        <div class="container">
            <h2>Nuestro Equipo</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="img/Luis.jpg" alt="Desarrollador" style="width: 50%;">
                    <h3>Luis Escobar</h3>
                    <p>Desarrollador Full Stack</p>
                </div>
                <div class="team-member">
                    <img src="img/Jazmin.jpg" alt="Estratega"style="width: 50%;">
                    <h3>Jazmin Rios</h3>
                    <p>Estratega </p>
                </div>
                <div class="team-member">
                    <img src="img/Emerson.jpg" alt="Desarrollador"style="width: 50%;">
                    <h3>Emerson Cuadros</h3>
                    <p>Desarrollador web</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Sección de Valores -->
    <section class="values">
        
            <div>
           
            <h2>Nuestros Valores</h2>
            <ul class="values-list">
                <li><strong>Innovación:</strong> Siempre buscamos nuevas formas de hacer las cosas mejor.</li>
                <li><strong>Compromiso:</strong> Estamos dedicados al éxito de nuestros clientes y proyectos.</li>
                <li><strong>Transparencia:</strong> Creemos en la comunicación abierta y honesta con nuestros clientes.</li>
                <li><strong>Trabajo en Equipo:</strong> Valoramos la colaboración interna y externa para lograr los mejores resultados.</li>
            </ul>

            </div>

            <div>
            <img src="https://concepto.de/wp-content/uploads/2015/06/valor-e1546822604479-800x400.jpg" alt="Valores" >
            
            </div>
       
    </section>
    
    <!-- Sección de Historia -->
    <section class="history">
        <div class="container">
            <h2>Nuestra Historia</h2>
            <p>Fundada en 2020, StartUP nació con la visión de ayudar a las empresas emergentes a prosperar en el entorno digital. Desde nuestros comienzos, hemos trabajado con múltiples startups para llevar sus ideas al siguiente nivel, siempre con un enfoque personalizado y adaptado a cada cliente.</p>
        </div>

        <div>
        <img src=" https://webcorp.ec/images/historia-del-diseno-web.jpg" alt="Valores" >      
        </div>
    </section>

<section>
    <!-- Modal Sign Up Form -->
  <div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <img src="img/logo.png" alt="LOGO" class="modal-logo">
        <h2>Join the community</h2>
        <form action="" method="post">
            <input type="text" id="first-name" name="first-name" placeholder="First Name" required>
            <input type="text" id="last-name" name="last-name" placeholder="Last Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="newsletter"> Please send me the occasional newsletter
                </label>
                <label>
                    <input type="checkbox" name="privacy-policy" required> I agree to the privacy policy and terms of service
                </label>
            </div>
            <a href="#">Read our privacy policy</a><br>
            <a href="#">Read our terms of service</a>
            <button type="submit" class="submit-button">Find me a co-founder!</button>
        </form>
    </div>
</div>

 <!-- Modal Sign In Form -->
 <div id="signinModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <img src="img/logo.png" alt="LOGO" class="modal-logo">
        <h2>Welcome Back</h2>
        <form action="" method="post">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="remember-me"> Remember me
                </label>
            </div>
            <a href="#">Forgot your password?</a><br>
            <button type="submit" class="submit-button">Sign In</button>
        </form>
    </div>
</div>

</section>
   
  
    <?php include 'php/footer.php'; ?>
   
    <link rel="stylesheet" href="css/responsive.css">
</body>

<script defer src="js/signup_modal.js"></script>
<script src="js/menu_toggle.js" defer></script>
</html>

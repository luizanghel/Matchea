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
    <link rel="stylesheet" href="css/styles_3.css">
    <link rel="stylesheet" href="css/signup_modal.css"> <!-- CSS adicional para el modal -->
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
    
    <!-- Sección de Servicios -->
    <section class="services">
        <div class="container">
            <div class="services-header">
                <h1>Nuestros Servicios</h1>
                <p>Proporcionamos una variedad de servicios adaptados a las necesidades de tu startup.</p>
            </div>
            <div class="services-grid">
                <div class="service-item">
                    <div class="service-image-wrapper">
                        <img src="https://tekla.io/wp-content/uploads/2022/03/DesarrolloWeb-1920x732-1.jpg" alt="Desarrollo Web">
                    </div>
                    <div class="service-content">
                        <h2>Desarrollo Web</h2>
                        <p>Creamos páginas web optimizadas y atractivas para que tu negocio tenga una presencia efectiva en línea.</p>
                        <a href="contact.php" class="service-link">Saber más</a>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-image-wrapper">
                        <img src="https://www.novatechlanzarote.com/wp-content/uploads/2016/09/Novatech-Tecnolog%C3%ADas-de-la-Informaci%C3%B3n-Lanzarote-.jpg" alt="Consultoría Tecnológica">
                    </div>
                    <div class="service-content">
                        <h2>Consultoría Tecnológica</h2>
                        <p>Te ayudamos a tomar las mejores decisiones tecnológicas para hacer crecer tu negocio.</p>
                        <a href="contact.php" class="service-link">Saber más</a>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-image-wrapper">
                        <img src="https://www.mdmarketingdigital.com/blog/wp-content/uploads/2024/01/que-es-el-marketing-digital-1-800x500.jpg" alt="Marketing Digital">
                    </div>
                    <div class="service-content">
                        <h2>Marketing Digital</h2>
                        <p>Desarrollamos estrategias de marketing digital para aumentar la visibilidad y el alcance de tu empresa.</p>
                        <a href="contact.php" class="service-link">Saber más</a>
                    </div>
                </div>
                <div class="service-item">
                    <div class="service-image-wrapper">
                        <img src="https://www.prosperitydigital.es//storage/information-pages/June2022/UX-UI%20Visualisation.png" alt="Diseño UI/UX">
                    </div>
                    <div class="service-content">
                        <h2>Diseño UI/UX</h2>
                        <p>Diseñamos interfaces de usuario atractivas y funcionales para mejorar la experiencia de tus clientes.</p>
                        <a href="contact.php" class="service-link">Saber más</a>
                    </div>
                </div>
            </div>
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
                <a href="contact.php">Read our privacy policy</a><br>
                <a href="contact.php">Read our terms of service</a>
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
                <a href="contact.php">Forgot your password?</a><br>
                <button type="submit" class="submit-button">Sign In</button>
            </form>
        </div>
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
            <a href="contact.php">Read our privacy policy</a><br>
            <a href="contact.php">Read our terms of service</a>
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
            <a href="contact.php">Forgot your password?</a><br>
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

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
    <section class="contact">
        <div class="container">
            <h1>Contacta con nosotros</h1>
            <p>Cuéntanos, ¿en qué podemos ayudarte?</p>
            <div class="contact-methods">
                <div class="contact-method">
                    <h2>Telefonos</h2>
                    <p>Tu soporte listo para escucharte. Llámanos al <strong>91 593 00 00</strong>, opción 2, de lunes a viernes, de 08:00 a 19:00. También está disponible el número gratuito <strong>900 909 111</strong>.</p>
                </div>
                <div class="contact-method">
                    <h2>Redes Sociales</h2>
                    <p>Escríbenos lo que necesites en nuestro perfil oficial de Facebook de Banco Pichincha España. Tus comentarios y consultas son bienvenidas todos los días, las 24 horas.</p>
                    <a href="https://www.facebook.com/bancopichinchaES" target="_blank">Visítanos en Facebook</a>
                </div>
                <div class="contact-method">
                    <h2>Oficinas</h2>
                    <p>¡Visítanos! Acércate a cualquiera de nuestras 10 oficinas en España. Estamos en las provincias de Madrid, Barcelona, Valencia, Murcia, Alicante y Zaragoza.</p>
                    <a href="offices.html">Ubica tu oficina más cercana</a>
                </div>
            </div>
            <div class="contact-form">
                <h2>Te ayudamos</h2>
                <p>¿Tienes alguna duda sobre nuestros productos o servicios? Deja que te asesoremos. Rellena el siguiente formulario y en breve nos pondremos en contacto contigo para responder a tu consulta.</p>
                <form action="submit_form.php" method="post">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="message">Mensaje:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                    
                    <button type="submit">Enviar</button>
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

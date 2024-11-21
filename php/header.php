<header class="header">
    <div class="container">
        <nav class="navbar-dos">
            <a href="index.php" class="logo">
                <img src="img/MatcheasinFondo2.png" alt="LOGO" style="width: 15%;">
            </a>
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>   
                <li><a href="javascript:void(0)" id="signupButton">SignUp</a></li>
                <li><a href="javascript:void(0)" id="signinButton">Login</a></li>
            </ul>
            <!-- Botón de menú hamburguesa -->
            <button class="menu-toggle" aria-label="Toggle menu">
                <i class="fa fa-bars menu-icon"></i>
            </button>   
        </nav>

        <!-- Menú móvil -->
        <nav class="mobile-menu">
            <ul class="nav-menudos">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="javascript:void(0)" id="signupButtonMobile">SignUp</a></li>
                <li><a href="javascript:void(0)" id="signinButtonMobile">Login</a></li>
                <li><button class="close-menu">Close menu</button></li>
            </ul>
        </nav>
    </div>

    <!-- Modal para Sign Up y Sign in -->
    <section>
        <div id="signupModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <img src="img/logo.png" alt="LOGO" class="modal-logo">
                <h2>Join the community</h2>
                
                <form action="php/submit_form.php" method="POST">
                <input type="text" id="first-name" name="first-name" placeholder="First Name" required>
                <input type="text" id="last-name" name="last-name" placeholder="Last Name" required>
                <input type="email" id="email" name="email" placeholder="Email" required>
                <span id="email-validation-message" style="font-size: 12px; color: red; display: none;"></span>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <div class="g-recaptcha" data-sitekey="6Le2Z4UqAAAAAJQHSvug5XVxiAZa6Q4dKkLmkKS_"></div>
                <select id="country" name="country" required>
                    <option value="">Select your country</option>
                </select>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="privacy-policy" required> I agree to the privacy policy and terms of service
                        </label>
                    </div>
                    <a href="#">Read our privacy policy</a><br>
                    <a href="#">Read our terms of service</a>
                    <button type="submit" name="signup" class="submit-button">Registrarme!</button>
                </form>
            </div>
        </div>
        <!-- Modal Sign In Form -->
        <div id="signinModal" class="modal">
                <div class="modal-content">
                    <span class="close-button">&times;</span>
                    <img src="img/logo.png" alt="LOGO" class="modal-logo">
                    <h2>Welcome Back</h2>
                    <form action="php/login_handler.php" method="post">
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

    
</header>

<!-- Incluir script externo para cargar países -->
<script src="js/countries.js"></script>
<script src="js/menu_toggle.js"></script>
<script src="js/signup_modal.js"></script>
<script src="js/email_validation.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
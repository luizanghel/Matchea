<header class="header">
    <div class="container">
        <nav class="navbar-dos">
            <a href="index.html" class="logo">
                <img src="img/MatcheasinFondo2.png" alt="LOGO" style="width: 15%;">
              </a>
            <ul class="nav-menu">
                <li><a href="index.html">Home</a></li>
                <li><a href="About.html">About</a></li>
                <li><a href="Services.html">Services</a></li>
                <li><a href="Contact.html">Contact</a></li>   
                <li><a href="javascript:void(0)" id="signupButton">SignUp</a></li>
                <li><a href="javascript:void(0)" id="signinButton">Login</a></li>
            </ul>
                    <!-- Botón de menú hamburguesa -->
            <button class="menu-toggle" aria-label="Toggle menu">
                <i class="fa fa-bars menu-icon"></i> <!-- Ícono de menú hamburguesa -->
            </button>   
        </nav>

            <!-- Menú móvil -->
        <nav class="mobile-menu">
            <ul class="nav-menudos">
                <li><a href="index.html">Home</a></li>
                <li><a href="About.html">About</a></li>
                <li><a href="Services.html">Services</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="javascript:void(0)" id="signupButtonMobile">SignUp</a></li>
                <li><a href="javascript:void(0)" id="signinButtonMobile">Login</a></li>
                <li><button class="close-menu">Close menu</button></li>
            </ul>
        </nav>

    </div>

    <script>
        function toggleMenu() {
            var menu = document.querySelector('.nav-menu');
            menu.classList.toggle('active');
        }
    </script>
    
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
</header>
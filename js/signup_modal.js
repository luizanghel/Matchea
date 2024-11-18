document.addEventListener('DOMContentLoaded', function () {
    // Botones y modales
    const signupButton = document.getElementById('signupButton'); // Botón de la barra de navegación
    const signupButtonMobile = document.getElementById('signupButtonMobile'); // Botón del menú móvil
    const signupButtonIntro = document.getElementById('signupButtonIntro'); // Botón de la sección Intro
    const signupModal = document.getElementById('signupModal');
    const signinButton = document.getElementById('signinButton');
    const signinButtonMobile = document.getElementById('signinButtonMobile'); // Botón de Login en móvil
    const signinModal = document.getElementById('signinModal');
    const closeButtons = document.querySelectorAll('.close-button');

    // Función para abrir el modal de Sign Up
    function openSignupModal(event) {
        event.preventDefault(); // Evita el comportamiento predeterminado
        signupModal.style.display = 'block'; // Muestra el modal
    }

    // Abrir el modal de Sign Up desde la barra de navegación
    if (signupButton && signupModal) {
        signupButton.addEventListener('click', openSignupModal);
    }

    // Abrir el modal de Sign Up desde el menú móvil
    if (signupButtonMobile && signupModal) {
        signupButtonMobile.addEventListener('click', openSignupModal);
    }

    // Abrir el modal de Sign Up desde el botón "Sign up free" en la sección Intro
    if (signupButtonIntro && signupModal) {
        signupButtonIntro.addEventListener('click', openSignupModal);
    }

    // Abrir el modal de Sign In desde la barra de navegación
    if (signinButton && signinModal) {
        signinButton.addEventListener('click', function (event) {
            event.preventDefault();
            signinModal.style.display = 'block';
        });
    }

    // Abrir el modal de Sign In desde el menú móvil
    if (signinButtonMobile && signinModal) {
        signinButtonMobile.addEventListener('click', function (event) {
            event.preventDefault();
            signinModal.style.display = 'block';
        });
    }

    // Cerrar el modal cuando se haga clic en la 'x'
    closeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (signupModal) signupModal.style.display = 'none';
            if (signinModal) signinModal.style.display = 'none';
        });
    });

    // Cerrar el modal cuando se haga clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === signupModal) {
            signupModal.style.display = 'none';
        }
        if (event.target === signinModal) {
            signinModal.style.display = 'none';
        }
    });
});

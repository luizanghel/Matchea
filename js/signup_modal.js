document.addEventListener('DOMContentLoaded', function () {
    // Botones y modales
    const signupButton = document.getElementById('signupButton');
    const signupModal = document.getElementById('signupModal');
    const signinButton = document.getElementById('signinButton');
    const signinModal = document.getElementById('signinModal');
    const closeButtons = document.querySelectorAll('.close-button');

    // Abrir el modal de Sign Up
    if (signupButton && signupModal) {
        signupButton.addEventListener('click', function (event) {
            event.preventDefault(); // Evitar navegación por defecto
            signupModal.style.display = 'block'; // Mostrar modal de Sign Up
        });
    }

    // Abrir el modal de Sign In
    if (signinButton && signinModal) {
        signinButton.addEventListener('click', function (event) {
            event.preventDefault(); // Evitar navegación por defecto
            signinModal.style.display = 'block'; // Mostrar modal de Sign In
        });
    }

    // Cerrar el modal cuando se haga clic en la 'x' de cualquier modal
    closeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            if (signupModal) signupModal.style.display = 'none'; // Ocultar modal de Sign Up
            if (signinModal) signinModal.style.display = 'none'; // Ocultar modal de Sign In
        });
    });

    // Cerrar el modal cuando se haga clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === signupModal) {
            signupModal.style.display = 'none'; // Ocultar modal de Sign Up
        }
        if (event.target === signinModal) {
            signinModal.style.display = 'none'; // Ocultar modal de Sign In
        }
    });
});

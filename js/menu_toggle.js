document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const closeMenuButton = document.querySelector('.close-menu');

    // Abre el menú móvil
    menuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('active'); // Activa o desactiva el menú móvil
    });

    // Cierra el menú móvil
    closeMenuButton.addEventListener('click', function () {
        mobileMenu.classList.remove('active'); // Cierra el menú móvil
    });

    // Cierra el menú al hacer clic fuera de él
    window.addEventListener('click', function (event) {
        if (event.target === mobileMenu) {
            mobileMenu.classList.remove('active');
        }
    });
});

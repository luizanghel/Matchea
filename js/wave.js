// Función para cambiar el atributo viewBox del SVG según el tamaño de la pantalla
function updateViewBox() {
    const wave = document.querySelector('.wave-container svg'); // Selecciona el SVG de la ola
    if (wave) {
        if (window.innerWidth >= 400 && window.innerHeight <= 600) {
            wave.setAttribute('viewBox', '0 0 1440 280'); // Cambia el viewBox para pantallas pequeñas
        } else {
            wave.setAttribute('viewBox', '0 0 1440 350'); // Cambia el viewBox para pantallas grandes
        }
    }
}

window.addEventListener('resize', updateViewBox);
window.addEventListener('DOMContentLoaded', updateViewBox);

document.addEventListener("DOMContentLoaded", function () {
    const filterForm = document.getElementById('filter-form');
    const projectsContainer = document.querySelector('.projects-list .row');

    filterForm.addEventListener('input', function () {
        const formData = new FormData(filterForm);

        const filters = {
            pais: formData.get('pais').toLowerCase(),
            habilidad: formData.get('habilidad'),
            nombre: formData.get('nombre').toLowerCase()
        };

        Array.from(projectsContainer.children).forEach(card => {
            const pais = card.dataset.pais.toLowerCase();
            const habilidades = card.dataset.habilidades;
            const nombre = card.querySelector('.card-title').textContent.toLowerCase();

            const matchesPais = !filters.pais || pais === filters.pais;
            const matchesHabilidad = !filters.habilidad || habilidades.includes(filters.habilidad);
            const matchesNombre = !filters.nombre || nombre.includes(filters.nombre);

            if (matchesPais && matchesHabilidad && matchesNombre) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

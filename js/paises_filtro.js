document.addEventListener('DOMContentLoaded', async () => {
    async function loadFilterCountries() {
        const select = document.getElementById('filter-project-country');
        if (!select) {
            console.error('El elemento con ID "filter-project-country" no existe en el DOM.');
            return;
        }
        try {
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();

            // Ordenar alfabéticamente
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

            // Agregar los países al select
            select.innerHTML = '<option value="">Todos los países</option>';
            countries.forEach(country => {
                select.innerHTML += `<option value="${country.name.common}">${country.name.common}</option>`;
            });
        } catch (error) {
            console.error('Error cargando países para el filtro:', error);
            select.innerHTML = '<option value="">Error cargando países</option>';
        }
    }

    await loadFilterCountries();
});

document.addEventListener('DOMContentLoaded', async () => {
    async function loadCountries(selectId, defaultOptionText) {
        const select = document.getElementById(selectId);
        try {
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();

            // Ordenar alfabéticamente
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

            // Agregar los países al select
            select.innerHTML = `<option value="">${defaultOptionText}</option>`;
            countries.forEach(country => {
                select.innerHTML += `<option value="${country.name.common}">${country.name.common}</option>`;
            });
        } catch (error) {
            console.error(`Error cargando países para ${selectId}:`, error);
            select.innerHTML = `<option value="">Error cargando países</option>`;
        }
    }

    await loadCountries('country', 'Select your country');
    await loadCountries('filter-project-country', 'Todos los países');
});

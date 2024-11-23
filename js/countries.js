document.addEventListener('DOMContentLoaded', async () => {
    async function loadCountries() {
        const select = document.getElementById('country');
        if (!select) {
            console.error('El elemento con ID "country" no existe en el DOM.');
            return;
        }
        try {
            const response = await fetch('https://restcountries.com/v3.1/all');
            const countries = await response.json();

            // Ordenar alfabéticamente
            countries.sort((a, b) => a.name.common.localeCompare(b.name.common));

            // Agregar los países al select
            select.innerHTML = '<option value="">Select your country</option>';
            countries.forEach(country => {
                select.innerHTML += `<option value="${country.name.common}">${country.name.common}</option>`;
            });
        } catch (error) {
            console.error('Error cargando países:', error);
            select.innerHTML = '<option value="">Error loading countries</option>';
        }
    }

    await loadCountries();
});

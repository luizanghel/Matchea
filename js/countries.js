
async function loadCountries() {
    const select = document.getElementById('country');
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
        console.error('Error loading countries:', error);
        select.innerHTML = '<option value="">Error loading countries</option>';
    }
}

document.addEventListener('DOMContentLoaded', loadCountries);

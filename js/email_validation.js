document.addEventListener('DOMContentLoaded', () => {
    const emailInput = document.getElementById('email');
    const validationMessage = document.getElementById('email-validation-message');

    emailInput.addEventListener('input', async () => {
        const email = emailInput.value.trim();
        validationMessage.style.display = 'none';

        if (email) {
            try {
                const response = await fetch('php/validate_email.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}`,
                });

                const data = await response.json();
                if (data.valid) {
                    validationMessage.style.color = 'green';
                    validationMessage.textContent = 'El correo electrónico es válido.';
                } else {
                    validationMessage.style.color = 'red';
                    validationMessage.textContent = data.message || 'El correo electrónico no es válido.';
                }
                validationMessage.style.display = 'block';
            } catch (error) {
                console.error('Error validando el email:', error);
                validationMessage.style.color = 'red';
                validationMessage.textContent = 'No se pudo validar el correo electrónico.';
                validationMessage.style.display = 'block';
            }
        }
    });
});

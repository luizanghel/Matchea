document.querySelector('.chat-input').addEventListener('submit', function (e) {
    e.preventDefault();
    const input = this.querySelector('input');
    const message = input.value.trim();

    if (message) {
        const chatMessages = document.querySelector('.chat-messages');
        const newMessage = document.createElement('div');
        newMessage.classList.add('message');
        newMessage.innerHTML = `
            <span class="sender">Tú</span>
            <span class="time">${new Date().toLocaleString()}</span>
            <p>${message}</p>
        `;
        chatMessages.appendChild(newMessage);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        input.value = '';
    }
});

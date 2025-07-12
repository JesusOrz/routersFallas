document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('user-input');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;

        appendMessage("Tú", message);
        input.value = "";

        fetch(CHATBOT_RESPONSE, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ message })
        })
        .then(response => response.json())
        .then(data => appendMessage("Bot", data.reply))
        .catch(() => appendMessage("Bot", "Hubo un error al procesar tu mensaje."));
    });
});

function appendMessage(sender, text) {
    const chatWindow = document.getElementById('chat-window');
    const div = document.createElement('div');
    div.innerHTML = `<strong>${sender}:</strong> ${text}`;
    chatWindow.appendChild(div);
    chatWindow.scrollTop = chatWindow.scrollHeight;
}

function toggleChatbot() {
    const container = document.getElementById('chatbot-container');
    const input = document.getElementById('user-input');

    container.classList.toggle('hidden');

    // Si se muestra el chatbot, enfoca el input
    if (!container.classList.contains('hidden')) {
        setTimeout(() => input.focus(), 100);
    }
}

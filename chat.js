// chat.js

// Initialize WebSocket connection
const socket = new WebSocket('ws://yourserver.com');

// DOM elements
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');
const chatMessages = document.getElementById('chat-messages');

// Event listener for form submission
chatForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const message = chatInput.value.trim();
    if (message) {
        socket.send(JSON.stringify({ type: 'message', text: message }));
        chatInput.value = '';
    }
});

// Listen for incoming messages
socket.addEventListener('message', (event) => {
    const data = JSON.parse(event.data);
    if (data.type === 'message') {
        const messageElement = document.createElement('div');
        messageElement.textContent = data.text;
        chatMessages.appendChild(messageElement);
    }
});

// Handle WebSocket errors
socket.addEventListener('error', (error) => {
    console.error('WebSocket error:', error);
});

// Handle WebSocket connection close
socket.addEventListener('close', () => {
    console.log('WebSocket connection closed');
});
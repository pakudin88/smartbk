<?= $this->extend('layouts/minimal_layout') ?>

<?= $this->section('title') ?>
Konsul Cepat & Anonim - Safe Space
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    /* Chat container */
    .chat-container {
        max-width: 800px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px 20px 0 0;
        box-shadow: 0 10px 30px rgba(76, 175, 80, 0.15);
        border: 1px solid rgba(76, 175, 80, 0.1);
        height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .chat-header {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: white;
        padding: 1.5rem;
        text-align: center;
        border-radius: 20px 20px 0 0;
        flex-shrink: 0;
    }

    .chat-header h3 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .chat-header p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        margin: 0 0 1rem 0;
    }

    .mode-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .mode-label {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .mode-label.active {
        color: white;
        font-weight: 700;
    }

    .mode-switch {
        position: relative;
        width: 60px;
        height: 30px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.4);
    }

    .mode-switch.anonymous {
        background: rgba(255, 255, 255, 0.6);
    }

    .mode-switch::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 22px;
        height: 22px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .mode-switch.anonymous::after {
        transform: translateX(30px);
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 255, 0.8) 100%);
        margin-bottom: 0;
    }

    .message {
        margin-bottom: 1rem;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message.bot .message-content {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 20px 20px 20px 5px;
        margin-right: 20%;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
    }

    .message.user .message-content {
        background: linear-gradient(135deg, #2196f3 0%, #42a5f5 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 20px 20px 5px 20px;
        margin-left: 20%;
        text-align: right;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
    }

    .message-time {
        font-size: 0.7rem;
        opacity: 0.7;
        margin-top: 0.5rem;
        text-align: center;
    }

    /* Fixed Chat Input */
    .chat-input {
        position: fixed;
        bottom: 70px;
        left: 0;
        right: 0;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-top: 1px solid rgba(76, 175, 80, 0.1);
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .input-group {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .message-input {
        flex: 1;
        border: 2px solid rgba(76, 175, 80, 0.2);
        border-radius: 25px;
        padding: 0.8rem 1.2rem;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .message-input:focus {
        outline: none;
        border-color: #4caf50;
        background: white;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .btn-send {
        background: linear-gradient(135deg, #4caf50 0%, #66bb6a 100%);
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
    }

    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
    }

    .btn-send:active {
        transform: translateY(0);
    }

    /* Welcome message */
    .welcome-message {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .welcome-message .emoji {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }

    .welcome-message h4 {
        color: #2e7d32;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .welcome-message p {
        font-size: 0.9rem;
        line-height: 1.6;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Quick replies */
    .quick-replies {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
        justify-content: center;
    }

    .quick-reply {
        background: rgba(76, 175, 80, 0.1);
        border: 1px solid rgba(76, 175, 80, 0.3);
        color: #2e7d32;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quick-reply:hover {
        background: rgba(76, 175, 80, 0.2);
        transform: translateY(-1px);
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .chat-container {
            margin: 0;
            border-radius: 0;
            height: calc(100vh - 160px);
        }

        .chat-header {
            padding: 1rem;
            border-radius: 0;
        }

        .chat-header h3 {
            font-size: 1.2rem;
        }

        .chat-messages {
            padding: 1rem;
        }

        .message.bot .message-content {
            margin-right: 10%;
        }

        .message.user .message-content {
            margin-left: 10%;
        }

        .chat-input {
            padding: 1rem;
            bottom: 60px;
        }

        .btn-send {
            width: 45px;
            height: 45px;
            font-size: 1rem;
        }
    }

    /* Scrollbar styling */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: rgba(76, 175, 80, 0.1);
        border-radius: 3px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: rgba(76, 175, 80, 0.3);
        border-radius: 3px;
    }

    .chat-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(76, 175, 80, 0.5);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Chat Container -->
    <div class="chat-container">
        <!-- Chat Header -->
        <div class="chat-header">
            <h3>
                <i class="fas fa-comments me-2"></i>Konsul Cepat & Anonim
            </h3>
            <p id="status-text">Online - Guru BK tersedia</p>
            
            <div class="mode-toggle">
                <span class="mode-label active" id="identifiedLabel">Teridentifikasi</span>
                <div class="mode-switch" id="modeSwitch" onclick="toggleMode()"></div>
                <span class="mode-label" id="anonymousLabel">Anonim</span>
            </div>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages" id="chatMessages">
            <!-- Welcome Message -->
            <div class="welcome-message">
                <span class="emoji">💬</span>
                <h4>Selamat datang di Konsul Cepat!</h4>
                <p>Saya di sini untuk mendengarkan dan membantu Anda. Ceritakan apa yang ingin Anda bicarakan hari ini. Anda bisa memilih mode anonim jika merasa lebih nyaman.</p>
                
                <div class="quick-replies">
                    <span class="quick-reply" onclick="sendQuickReply('Saya merasa stress dengan tugas')">😰 Stress tugas</span>
                    <span class="quick-reply" onclick="sendQuickReply('Saya memiliki masalah dengan teman')">👥 Masalah pertemanan</span>
                    <span class="quick-reply" onclick="sendQuickReply('Saya butuh motivasi belajar')">📚 Motivasi belajar</span>
                    <span class="quick-reply" onclick="sendQuickReply('Saya merasa cemas')">😟 Perasaan cemas</span>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input">
            <div class="input-group">
                <input type="text" 
                       class="message-input" 
                       id="messageInput" 
                       placeholder="Ketik pesan Anda..." 
                       onkeypress="handleKeyPress(event)">
                <button class="btn-send" id="sendBtn" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let isAnonymous = false;

function toggleMode() {
    isAnonymous = !isAnonymous;
    const modeSwitch = document.getElementById('modeSwitch');
    const identifiedLabel = document.getElementById('identifiedLabel');
    const anonymousLabel = document.getElementById('anonymousLabel');
    const statusText = document.getElementById('status-text');
    
    if (isAnonymous) {
        modeSwitch.classList.add('anonymous');
        identifiedLabel.classList.remove('active');
        anonymousLabel.classList.add('active');
        statusText.textContent = 'Mode Anonim - Identitas disembunyikan';
    } else {
        modeSwitch.classList.remove('anonymous');
        identifiedLabel.classList.add('active');
        anonymousLabel.classList.remove('active');
        statusText.textContent = 'Online - Guru BK tersedia';
    }
}

function sendQuickReply(message) {
    const messageInput = document.getElementById('messageInput');
    messageInput.value = message;
    sendMessage();
}

function addMessage(type, content) {
    const chatMessages = document.getElementById('chatMessages');
    const welcomeMessage = chatMessages.querySelector('.welcome-message');
    
    // Remove welcome message on first user message
    if (type === 'user' && welcomeMessage) {
        welcomeMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    
    const timeString = new Date().toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
    
    messageDiv.innerHTML = `
        <div class="message-content">
            ${content}
        </div>
        <div class="message-time">${timeString}</div>
    `;
    
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (message) {
        addMessage('user', message);
        messageInput.value = '';
        
        // Simulate bot response
        setTimeout(() => {
            const responses = [
                'Terima kasih sudah berbagi. Bagaimana perasaan Anda sekarang?',
                'Saya mendengarkan Anda. Ceritakan lebih detail jika Anda mau.',
                'Itu terdengar sulit. Apa yang bisa membantu Anda merasa lebih baik?',
                'Anda tidak sendirian. Kami di sini untuk mendukung Anda.',
                'Bagaimana jika kita coba mencari solusi bersama-sama?'
            ];
            const randomResponse = responses[Math.floor(Math.random() * responses.length)];
            addMessage('bot', randomResponse);
        }, 1000 + Math.random() * 2000);
    }
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    const messageInput = document.getElementById('messageInput');
    if (messageInput) {
        messageInput.focus();
    }
});
</script>
<?= $this->endSection() ?>

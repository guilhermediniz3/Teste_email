<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Envio de E-mail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos CSS */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        h2 { color: #333; }
        form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="email"], input[type="text"], input[type="number"], input[type="password"], textarea {
            width: calc(100% - 12px); padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;
        }
        textarea { height: 100px; }
        button { background-color: #28a745; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #218838; }
        .gear-button { background: none; border: none; cursor: pointer; font-size: 24px; color: #007bff; margin-right: 10px; }
        .modal { display: none; position: fixed; top: 20%; left: 0; width: 100%; height: auto; background-color: rgba(0,0,0,0.5); z-index: 1000; }
        .modal-content { background-color: white; margin: auto; padding: 20px; border: 1px solid #888; border-radius: 8px; width: 300px; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; }
        .close:hover, .close:focus { color: black; text-decoration: none; cursor: pointer; }
        .checkbox-group { display: flex; gap: 10px; align-items: center; margin-bottom: 10px; }
        .hidden { display: none; }
    </style>
</head>
<body>

<h2>Testar E-mail</h2>
<form id="emailForm" action="send_email.php" method="POST">
    <label for="to">Para:</label>
    <input type="email" id="to" name="to" required>

    <label for="subject">Assunto:</label>
    <input type="text" id="subject" name="subject" required>

    <label for="message">Mensagem:</label>
    <textarea id="message" name="message" required></textarea>

    <div class="checkbox-group">
        <label><input type="checkbox" id="useConfig" name="useConfig" onclick="toggleCheckbox(this)"> Configurações de E-mail</label>
        <i class="fas fa-exclamation-circle" title="Configuração manual para testar o email do usuário."></i>

        <label><input type="checkbox" id="useDefault" name="useDefault" onclick="toggleCheckbox(this)" checked> Configuração Padrão</label>
        <i class="fas fa-exclamation-circle" title="Configuração estática para comparação."></i>
    </div>

    <!-- Campos do modal ocultos -->
    <input type="text" id="smtp" name="smtp" class="hidden">
    <input type="email" id="email" name="email" class="hidden">
    <input type="password" id="password" name="password" class="hidden">
    <input type="number" id="port" name="port" class="hidden">

    <button type="button" class="gear-button" onclick="openModal()">
        <i class="fas fa-cog"></i>
    </button>
    <button type="submit">Enviar</button>
</form>

<!-- Modal -->
<div id="smtpModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Configurações SMTP</h2>
        <label for="modalSmtp">SMTP:</label>
        <input type="text" id="modalSmtp" required>

        <label for="modalEmail">E-mail:</label>
        <input type="email" id="modalEmail" required>

        <label for="modalPassword">Senha:</label>
        <input type="text" id="modalPassword" required>

        <label for="modalPort">Porta:</label>
        <input type="number" id="modalPort" required>
        
        <button onclick="saveSettings()">Salvar</button>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('smtpModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('smtpModal').style.display = 'none';
}

function saveSettings() {
    document.getElementById('smtp').value = document.getElementById('modalSmtp').value;
    document.getElementById('email').value = document.getElementById('modalEmail').value;
    document.getElementById('password').value = document.getElementById('modalPassword').value;
    document.getElementById('port').value = document.getElementById('modalPort').value;
    closeModal();
}

function toggleCheckbox(checkbox) {
    if (checkbox.id === 'useConfig') {
        document.getElementById('useDefault').checked = false;
        document.getElementById('smtp').required = true;
        document.getElementById('email').required = true;
        document.getElementById('password').required = true;
        document.getElementById('port').required = true;
    } else {
        document.getElementById('useConfig').checked = false;
        document.getElementById('smtp').required = false;
        document.getElementById('email').required = false;
        document.getElementById('password').required = false;
        document.getElementById('port').required = false;
    }
}
</script>

</body>
</html>
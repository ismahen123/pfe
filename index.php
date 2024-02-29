
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Client</title>
</head>
<body>
    <h1>WebSocket Client</h1>
    <div id="receivedMessages"></div>
    <div id="sentMessages"></div>
    <form id="messageForm">
        <input type="text" id="messageInput" placeholder="Entrez votre message...">
        <button type="submit">Envoyer</button>
    </form>
    <script>

        const ws = new WebSocket('ws://localhost:8080');
    
        ws.onopen = function() {
           console.log('Connexion WebSocket ouverte');
        };

        ws.onmessage = function(event) {
           const receivedMessagesDiv = document.getElementById('receivedMessages');
            receivedMessagesDiv.innerHTML += '<div>Message received: ' + event.data + '</div>';

        };

        document.getElementById('messageForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;
           ws.send(message);

           const sentMessagesDiv = document.getElementById('sentMessages');
           sentMessagesDiv.innerHTML += '<div>Message sent: ' + message + '</div>';
            messageInput.value = '';
        });
       
    </script>
</body>
</html>
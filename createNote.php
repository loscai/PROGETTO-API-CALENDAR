<?php
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\Keep;
use Google\Service\Keep\Note;
use Google\Service\Keep\ListContent;

// Funzione per ottenere il client Google
function getClient(): Client {
    $client = new Client();
    $client->setAuthConfig('service-account-credentials.json');
    // Fix: Use the correct scope for Google Keep API
    $client->addScope('https://www.googleapis.com/auth/keep.readonly');
    $client->addScope('https://www.googleapis.com/auth/keep');
    $client->setAccessType('offline');
    return $client;
}

// Gestione del form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    try {
        $client = getClient();
        $service = new Keep($client);

        // Crea una nuova nota
        $note = new Note([
            'title' => $title,
            'body' => $content,
            'listContent' => new ListContent([
                'items' => []
            ])
        ]);

        // Inserisci la nota
        $createdNote = $service->notes->create($note);
        $message = "Nota creata con successo!";
    } catch (Exception $e) {
        $error = "Errore: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Nota Rapida</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <button onclick="window.location.href='index.php'" class="nav-button">HOME</button>
        </nav>
        
        <div class="note-form">
            <h2>Nuova Nota Rapida</h2>
            
            <?php if (isset($message)): ?>
                <div class="success-message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="content">Contenuto</label>
                    <textarea id="content" name="content" rows="4" required></textarea>
                </div>

                <button type="submit">Salva Nota</button>
            </form>
        </div>
    </div>
</body>
</html>
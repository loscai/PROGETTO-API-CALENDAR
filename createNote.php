<?php
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\Keep;
use Google\Service\Keep\Note;
use Google\Service\Keep\ListContent;

// Funzione per ottenere il client Google
function getClient(): Client
{
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
                //necessario per la creazione di una nota (anche se vuoto)
            ])
        ]);

        // Inserisci la nota
        $createdNote = $service->notes->create($note);
        $message = "Nota creata con successo!";
        header("Location: index.php?message=" . $message);
        exit;
    } catch (Exception $e) {
        $error = "Errore: " . $e->getMessage();
        header("Location: index.php?message=" . $error);
        exit;
    }
}
?>
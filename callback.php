<?php
require_once 'vendor/autoload.php';

if (!isset($_SESSION)) session_start();

// Debug completo (solo in sviluppo)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inizializza il client Google
$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->setRedirectUri('http://localhost/PERSONALE/PROGETTO%20API%20UNIFICATO/callback.php');
$client->setAccessType('offline'); // Necessario per ottenere il refresh_token
$client->setPrompt('consent');     // Garantisce che venga chiesto il consenso ogni volta (utile per refresh_token)

// Aggiungi gli scope per entrambe le API
$client->addScope([
    Google_Service_Calendar::CALENDAR,
    'https://www.googleapis.com/auth/keep'
]);

// Opzionale: Debug HTTP tramite Guzzle (solo per sviluppo)
$client->setHttpClient(new GuzzleHttp\Client([
    'verify' => false,
    'debug' => false, // metti true per loggare le richieste HTTP
    'timeout' => 60
]));

try {
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (isset($token['error'])) {
            echo "Errore durante l'autenticazione: " . htmlspecialchars($token['error_description']);
            exit;
        }

        // Salva il token in sessione (o eventualmente su file/database)
        $_SESSION['access_token'] = $token;

        // Reindirizza a una pagina protetta che usa le API
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Codice di autorizzazione non trovato.";
    }
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
    echo "<br><br>Trace completo:<br>";
    echo nl2br($e->getTraceAsString());
}
?>

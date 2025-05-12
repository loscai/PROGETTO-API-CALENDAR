<?php
require_once 'vendor/autoload.php';
if(!isset($_SESSION)) 
    session_start();

// Abilita error reporting completo
error_reporting(E_ALL);
ini_set('display_errors', 1);

$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->setRedirectUri('http://localhost/PERSONALE/PROGETTO%20API%20CALENDAR/callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);

// Aggiungi opzioni di debug per Guzzle
$client->setHttpClient(
    new GuzzleHttp\Client([
        'verify' => false, // Disabilita la verifica SSL (solo per debug)
        'debug' => true,   // Attiva output di debug
        'timeout' => 60,   // Aumenta il timeout
    ])
);

try {
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (isset($token['error'])) {
            echo "Errore durante l'ottenimento del token: " . $token['error_description'];
            exit;
        }
        
        $_SESSION['access_token'] = $token;
        header('Location: addEvent.php');
        exit;
    } else {
        echo "Nessun codice di autorizzazione ricevuto.";
    }
} catch (Exception $e) {
    echo "Si è verificato un errore: " . $e->getMessage();
    echo "<br><br>Trace completo:<br>";
    echo nl2br($e->getTraceAsString());
}
?>
<?php
require_once 'vendor/autoload.php';

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Google Calendar API PHP');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    
    // Usa la chiave di servizio. Dovrai creare un file JSON di credenziali del service account
    // dalla console Google Cloud e salvarlo come service-account-credentials.json
    $client->setAuthConfig('service-account-credentials.json');
    $client->setAccessType('offline');
    
    return $client;
}

// Ottieni il client
$client = getClient();

try {
    $token = $client->fetchAccessTokenWithAssertion();
    echo "<pre>";
    print_r($token);
    echo "</pre>";
} catch (Exception $e) {
    echo "Errore nel recupero del token: " . $e->getMessage();
}


// Imposta l'account email dell'utente di cui vuoi impersonare l'identità
// Questo è necessario solo se usi un service account e devi accedere ai dati di un utente specifico
// $client->setSubject('user-email@example.com');

// Crea il servizio Calendar
$service = new Google_Service_Calendar($client);

// Crea un nuovo evento
$event = new Google_Service_Calendar_Event([
    'summary' => 'Google I/O 2025',
    'location' => '800 Howard St., San Francisco, CA 94103',
    'description' => 'A chance to hear more about Google\'s developer products.',
    'start' => [
        'dateTime' => '2025-05-28T09:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ],
    'end' => [
        'dateTime' => '2025-05-28T17:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ],
    'attendees' => [
        ['email' => 'lpage@example.com'],
        ['email' => 'sbrin@example.com'],
    ],
    'reminders' => [
        'useDefault' => false,
        'overrides' => [
            ['method' => 'email', 'minutes' => 24 * 60],
            ['method' => 'popup', 'minutes' => 10],
        ],
    ],
]);

try {
    // Inserisci l'evento
    // Utilizza l'ID del calendario che vuoi usare
    $calendarId = 'christiancolombo2k5@gmail.com';
    $event = $service->events->insert($calendarId, $event);
    echo "Evento creato: " . $event->htmlLink;
} catch (Exception $e) {
    echo "Si è verificato un errore: " . $e->getMessage();
}
?>
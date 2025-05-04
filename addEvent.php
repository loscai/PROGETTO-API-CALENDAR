<?php
require_once 'vendor/autoload.php';

use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;

function getClient(): GoogleClient
{
    $client = new GoogleClient();
    $client->setAuthConfig('service-account-credentials.json');
    $client->addScope(Calendar::CALENDAR);
    $client->setAccessType('offline');
    return $client;
}

// Ottieni il client
$client = getClient();

// DEBUG: Recupera e stampa il token
try {
    $token = $client->fetchAccessTokenWithAssertion();
    if (!isset($token['access_token'])) {
        echo "<pre>Token assente o errore:\n";
        print_r($token);
        echo "</pre>";
        exit;
    }
} catch (Exception $e) {
    echo "Errore nel recupero del token: " . $e->getMessage();
    exit;
}

// ✅ Recupera i dati dal form
$titolo = $_GET['titolo'] ?? 'Evento senza titolo';
$descrizione = $_GET['descrizione'] ?? '';
$data_inizio = $_GET['data_inizio'] ?? '';
$ora_inizio = $_GET['ora_inizio'] ?? '';
$data_fine = $_GET['data_fine'] ?? '';
$ora_fine = $_GET['ora_fine'] ?? '';

if (!$data_inizio || !$ora_inizio || !$data_fine || !$ora_fine) {
    echo "❌ Dati mancanti: controlla di aver compilato tutti i campi.";
    exit;
}

// ✨ Combina data e ora per Google Calendar (RFC3339)
$startDateTime = $data_inizio . 'T' . $ora_inizio . ':00';
$endDateTime = $data_fine . 'T' . $ora_fine . ':00';

// Crea il servizio Calendar
$calendarService = new Calendar($client);

// Crea un nuovo evento dinamico
$event = new Event([
    'summary'     => $titolo,
    'description' => $descrizione,
    'start'       => new EventDateTime([
        'dateTime' => $startDateTime,
        'timeZone' => 'Europe/Rome',
    ]),
    'end'         => new EventDateTime([
        'dateTime' => $endDateTime,
        'timeZone' => 'Europe/Rome',
    ]),
    'reminders'   => [
        'useDefault' => false,
        'overrides' => [
            ['method' => 'email', 'minutes' => 24 * 60],
            ['method' => 'popup', 'minutes' => 10],
        ],
    ],
]);

// Inserisci l'evento
try {
    $calendarId = 'christiancolombo2k5@gmail.com'; // ID calendario
    $event = $calendarService->events->insert($calendarId, $event);
    echo "✅ Evento creato: <a href='{$event->htmlLink}' target='_blank'>{$event->htmlLink}</a>";
} catch (Exception $e) {
    echo "❌ Si è verificato un errore nell'inserimento dell'evento: " . $e->getMessage();
}
?>

<?php
require_once 'vendor/autoload.php';

use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;

//Funzione per ottenere il GoogleClient
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

// Recupera i dati dal form
$titolo = $_GET['titolo'];
$descrizione = $_GET['descrizione'];
$data_inizio = $_GET['data_inizio'];
$ora_inizio = $_GET['ora_inizio'];
$data_fine = $_GET['data_fine'];
$ora_fine = $_GET['ora_fine'];

if (!$data_inizio || !$ora_inizio || !$data_fine || !$ora_fine) {
    echo "Dati mancanti: controlla di aver compilato tutti i campi.";
    exit;
}

// ✨ Combina data e ora per Google Calendar
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
            ['method' => 'popup', 'minutes' => 10],
        ],
    ],
]);

// Inserisci l'evento
try {
    $calendarId = 'christiancolombo2k5@gmail.com'; // ID calendario
    $event = $calendarService->events->insert($calendarId, $event);
    header("location: index.php?message=Evento creato con successo! ID: " . $event->getId());
    exit;
} catch (Exception $e) {
    echo "Si è verificato un errore nell'inserimento dell'evento: " . $e->getMessage();
}
?>

<?php
require_once 'vendor/autoload.php';

session_start(); // Importante per memorizzare il token

$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setRedirectUri('http://localhost/PERSONALE/PROGETTO%20API%20CALENDAR/callback.php');

// Se non abbiamo un token memorizzato o è scaduto
if (!isset($_SESSION['access_token']) || (isset($_SESSION['access_token']) && $client->isAccessTokenExpired())) {
    // Se abbiamo un codice di autorizzazione nella query string
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    } else {
        // Altrimenti reindirizza per ottenere l'autorizzazione
        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }
}

// Imposta il token di accesso
$client->setAccessToken($_SESSION['access_token']);

// Rinnova il token se è scaduto
if ($client->isAccessTokenExpired()) {
    if ($client->getRefreshToken()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        $_SESSION['access_token'] = $client->getAccessToken();
    }
}

$service = new Google_Service_Calendar($client);

// Ora puoi procedere con la creazione dell'evento
$event = new Google_Service_Calendar_Event([
    'summary' => 'Google I/O 2015',
    'location' => '800 Howard St., San Francisco, CA 94103',
    'description' => 'A chance to hear more about Google\'s developer products.',
    'start' => [
        'dateTime' => '2015-05-28T09:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ],
    'end' => [
        'dateTime' => '2015-05-28T17:00:00-07:00',
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

$calendarId = 'primary';
$event = $service->events->insert($calendarId, $event);
printf('Event created: %s\n', $event->htmlLink);
?>
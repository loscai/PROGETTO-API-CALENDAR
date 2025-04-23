
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

// Initialize the Google Client
$client = new Client();
$client->setAuthConfig(__DIR__ . '/credentials.json');
$client->setScopes([Calendar::CALENDAR]);
$client->setAccessType('offline');

// Create Calendar Service
$service = new Calendar($client);



$event = new Google_Service_Calendar_Event(array(
    'summary' => 'Google I/O 2015',
    'location' => '800 Howard St., San Francisco, CA 94103',
    'description' => 'A chance to hear more about Google\'s developer products.',
    'start' => array(
        'dateTime' => '2015-05-28T09:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ),
    'end' => array(
        'dateTime' => '2015-05-28T17:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ),
    'recurrence' => array(
        'RRULE:FREQ=DAILY;COUNT=2'
    ),
    'attendees' => array(
        array('email' => 'lpage@example.com'),
        array('email' => 'sbrin@example.com'),
    ),
    'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
            array('method' => 'email', 'minutes' => 24 * 60),
            array('method' => 'popup', 'minutes' => 10),
        ),
    ),
));

$calendarId = 'primary';
$event = $service->events->insert($calendarId, $event);
printf('Event created: %s\n', $event->htmlLink);



?>
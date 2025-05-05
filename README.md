# Calendario Scolastico

Un'applicazione web per visualizzare e gestire eventi di un calendario scolastico attraverso l'API di Google Calendar.

## Caratteristiche

- Visualizzazione del calendario Google integrato
- Aggiunta di nuovi eventi al calendario
- Autenticazione sicura con Google OAuth 2.0
- Supporto per account di servizio Google

## Requisiti di Sistema

- PHP 7.4 o superiore
- Composer per la gestione delle dipendenze
- Server web (Apache/Nginx)
- Account Google con Calendar API abilitata

## Installazione

1. Clona la repository:
   ```
   git clone https://github.com/username/calendario-scolastico.git
   cd calendario-scolastico
   ```

2. Installa le dipendenze con Composer:
   ```
   composer install
   ```

3. Configura le credenziali Google:
   - Crea un progetto nella [Google Cloud Console](https://console.cloud.google.com/)
   - Abilita l'API di Google Calendar
   - Crea credenziali OAuth 2.0 e scarica il file `credentials.json`
   - Crea un account di servizio e scarica il file `service-account-credentials.json`
   - Posiziona entrambi i file nella cartella root del progetto

4. Configura l'URL di reindirizzamento nel file `credentials.json` per puntare a:
   ```
   http://localhost/path-to-your-project/callback.php
   ```

5. Condividi il tuo calendario Google con l'email dell'account di servizio per consentire l'accesso programmatico

## Struttura del Progetto

```
.
├── addEvent.php            # Script per l'inserimento degli eventi
├── callback.php            # Gestione del callback OAuth
├── composer.json           # Configurazione dipendenze
├── credentials.json        # Credenziali OAuth (non incluse nel repository)
├── index.php               # Pagina principale con visualizzazione calendario
├── preparaEvento.php       # Form per la creazione di un nuovo evento
├── README.md               # Questo file
├── service-account-credentials.json # Credenziali account di servizio (non incluse)
├── immagini_documentazione # Cartella per le immagini della documentazione
│   └── home.png            # Screenshot della home
├── js
│   └── script.js           # File JavaScript per la logica client-side
└── style
    ├── stile_form.css      # Stili per il form di creazione eventi
    └── style.css           # Stili generali dell'applicazione
```

## Utilizzo

1. Apri `index.php` nel tuo browser
2. Visualizza il calendario e gli eventi esistenti
3. Clicca su "INSERISCI NUOVO EVENTO" per creare un nuovo evento
4. Compila il form con i dettagli dell'evento e invia

## Sicurezza

**Importante**: I file di credenziali (`credentials.json` e `service-account-credentials.json`) contengono informazioni sensibili e non devono essere inclusi nel repository Git. Questi file sono già aggiunti al `.gitignore`.

## Problemi Noti

- La verifica SSL è disabilitata in modalità debug nel callback.php
- Il calendario è attualmente impostato su un indirizzo email specifico


## Contributi

Contributi e segnalazioni di bug sono benvenuti. Si prega di aprire una issue per discutere di modifiche importanti prima di inviare una pull request.
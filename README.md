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
- XAMPP o ambiente di sviluppo simile

## Installazione di Composer

1. **Windows**:
   - Scarica l'installer di Composer da [getcomposer.org](https://getcomposer.org/download/)
   - Esegui l'installer e segui le istruzioni
   - Assicurati che PHP sia nel PATH di sistema
   - Verifica l'installazione aprendo il terminale e digitando:
     ```bash
     composer --version
     ```

2. **Linux/Mac**:
   ```bash
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   php composer-setup.php
   php -r "unlink('composer-setup.php');"
   sudo mv composer.phar /usr/local/bin/composer
   ```

## Installazione Progetto

1. Clona la repository:
   ```
   git clone https://github.com/username/calendario-scolastico.git
   cd calendario-scolastico
   ```

2. Installa le dipendenze con Composer (nella directory del progetto):
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


### 1. Creazione Progetto Google Cloud

1. Vai su [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuovo progetto o seleziona uno esistente
3. Dal menu laterale, vai su "APIs & Services" > "Library"
4. Cerca "Google Calendar API" e abilitala

### 2. Configurazione Credenziali

1. Vai su "APIs & Services" > "Credentials"
2. Clicca su "Create Credentials" > "OAuth client ID"
3. Configura la schermata di consenso OAuth:
   - User Type: External
   - App Name: Il nome della tua applicazione
   - Email di supporto: La tua email
   - Domini autorizzati: Il tuo dominio

4. Crea credenziali OAuth:
   - Application type: Web application
   - Nome: Nome della tua app
   - Authorized redirect URIs: 
     ```
     http://localhost/path-to-your-project/callback.php
     ```
   - Scarica il file JSON delle credenziali e rinominalo in `credentials.json`

### 3. Configurazione Account di Servizio

1. In "Credentials", clicca "Create Credentials" > "Service Account"
2. Compila i dettagli dell'account di servizio
3. Scarica la chiave privata in formato JSON e rinominala in `service-account-credentials.json`

### 4. Personalizzazione Calendario

1. Sostituisci l'iframe in `index.php`:
   - Vai su [Google Calendar](https://calendar.google.com/)
   - Clicca sull'ingranaggio delle impostazioni
   - Seleziona il tuo calendario
   - "Integra calendario" > "Personalizza"
   - Copia il codice dell'iframe e sostituiscilo in index.php

2. Aggiorna il CalendarID in `addEvent.php`:
   ```php
   $calendarId = 'il-tuo-indirizzo@gmail.com';
   ```

### 5. Condivisione Calendario

1. Vai nelle impostazioni del tuo calendario Google
2. "Condividi con persone specifiche"
3. Aggiungi l'email dell'account di servizio
4. Assegna i permessi "Apporta modifiche e gestisci la condivisione"

## Configurazione Ambiente di Sviluppo

1. **Configura XAMPP**:
   - Installa XAMPP da [apachefriends.org](https://www.apachefriends.org/)
   - Avvia Apache dal pannello di controllo XAMPP
   - Posiziona il progetto in: `C:\xampp\htdocs\your-project-folder`

2. **Permessi file**:
   - Assicurati che i file di credenziali abbiano i permessi corretti
   - Windows: tasto destro > Proprietà > Sicurezza
   - Linux/Mac: `chmod 600` per i file di credenziali

## Utilizzo

// ...existing code...

## Risoluzione Problemi

- **Errore SSL**: Se riscontri errori SSL in ambiente di sviluppo, puoi temporaneamente disabilitare la verifica SSL nel callback.php (non raccomandato in produzione)
- **Errori CORS**: Assicurati che il dominio sia autorizzato nella Console Google Cloud
- **Errori di Autenticazione**: Verifica che i file di credenziali siano corretti e che il calendario sia condiviso con l'account di servizio


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

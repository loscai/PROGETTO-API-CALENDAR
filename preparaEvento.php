<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuovo Evento</title>
    <link rel="stylesheet" href="./style/stile_form.css">

</head>

<body>
    <nav class="navbar">
        <button onclick="window.location.href='index.php'" class="nav-button">HOME</button>
    </nav>
    <div class="event-form">
        <h2>Nuovo Evento</h2>
        <form action="addEvent.php" method="GET">       
            <div class="form-group">
                <label for="titolo">Titolo</label>
                <input type="text" id="titolo" name="titolo" value="titolo_test"required>
            </div>

            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <!--<input type="text" id="descrizione" required>-->
                <textarea id="descrizione" name="descrizione" rows="4" cols="68"></textarea>

            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="data_inizio">Data Inizio</label>
                    <input type="date" id="data_inizio" name="data_inizio" required>
                </div>

                <div class="form-group">
                    <label for="ora_inizio">Ora Inizio</label>
                    <input type="time" id="ora_inizio" name="ora_inizio" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="data_fine">Data Fine</label>
                    <input type="date" id="data_fine" name="data_fine" required>
                </div>

                <div class="form-group">
                    <label for="ora_fine">Ora Fine</label>
                    <input type="time" id="ora_fine" name="ora_fine" required>
                </div>
            </div>

            <button type="submit">Crea Evento</button>
        </form>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Nota Rapida</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <button onclick="window.location.href='index.php'" class="nav-button">HOME</button>
        </nav>
        
        <div class="note-form">
            <h2>Nuova Nota Rapida</h2>
            
            <?php if (isset($message)): ?>
                <div class="success-message"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="content">Contenuto</label>
                    <textarea id="content" name="content" rows="4" required></textarea>
                </div>

                <button type="submit">Salva Nota</button>
            </form>
        </div>
    </div>
</body>
</html>
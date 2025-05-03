<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Errore cURL: " . curl_error($ch);
} else {
    echo "Successo: risposta ricevuta";
}
curl_close($ch);
?>
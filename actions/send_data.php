<?php
// Daten aus dem Kontakt-Formular sammeln und in der Datenbank speichern

header('Content-Type: application/json'); // JSON Header setzen

require_once('../config.php'); // Config werte laden
require_once('../library/database.php'); // DB Funktionen laden

$data = json_decode(file_get_contents('php://input'), true); // JSON Daten auslesen

function desinfect($str): string {
    $str1 = strip_tags($str); // entfernt HTML/PHP-Tags 
    $str2 = preg_replace('/\x00|<[^>]*>?/', '', $str1); // entfernt NULL-Zeichen
    $str3 = str_replace(["'", '"'], ['&#39;', '&#34;'], $str2); // ersetzt Anführungszeichen
    $str4 = htmlspecialchars($str3); // konvertiert HTML-Tags in HTML-Code
    $str5 = trim($str4); // entfernt alle Leerzeichen am Anfang und am Ende eines Strings
    return $str5;
}

$errors = [];

// Felder noch mal serverseitig validieren
if (empty($data['title'])) {
    $errors['title'] = 'Das Feld ist erforderlich.';
}
if (empty($data['firstName'])) {
    $errors['firstName'] = 'Das Feld ist erforderlich.';
}
if (empty($data['lastName'])) {
    $errors['lastName'] = 'Das Feld ist erforderlich.';
}
if (empty($data['email'])) {
    $errors['email'] = 'Das Feld ist erforderlich.';
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Die E-Mail Adresse ist ungültig.';
}

// Fehler abfangen
if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

// Daten bereinigen
$firstName = desinfect($data['firstName']);
$lastName = desinfect($data['lastName']);
$city = isset($data['place']) ? desinfect($data['place']) : '';
$street = isset($data['address']) ? desinfect($data['address']) : '';
$postalCode = isset($data['postalCode']) ? desinfect($data['postalCode']) : '';
$email = desinfect($data['email']);
$message = isset($data['message']) ? desinfect($data['message']) : '';

try {
    $db = db_connect();
    $query = $db->prepare("INSERT INTO Users (title, first_name, last_name, city, street, postcode, email, message) VALUES (:title, :first_name, :last_name, :city, :street, :postcode, :email, :message)");

    $query->bindParam(':title', $data['title']);
    $query->bindParam(':first_name', $firstName);
    $query->bindParam(':last_name', $lastName);
    $query->bindParam(':city', $city);
    $query->bindParam(':street', $street);
    $query->bindParam(':postcode', $postalCode);
    $query->bindParam(':email', $email);
    $query->bindParam(':message', $message);
    
    $query->execute();
    
    echo json_encode(['success' => true]); // Erfolgreich gesendet
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'errors' => ['database' => 'Fehler beim Speichern der Daten in der Datenbank: ' . $e->getMessage()]]); // Daten konnten nicht gespeichert werden
}
?>

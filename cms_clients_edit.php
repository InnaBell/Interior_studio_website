<?php
require_once( 'config.php' ); // Config werte laden
require_once( 'library/database.php' ); // DB Funktionen laden
require_once( 'library/session.php' ); // Session Funktionen laden

session_name( md5(SESSION_NAME) );
session_start();

// Überprüfen, ob die Sitzung aktiv ist
$isLoggedIn = check_usersession(); 

$db = db_connect();

ob_start(); // Starte den Outputbuffering (Header-Fehler vermeiden)

$titlePage = 'Kunden';
$textButton = 'Speichern';

require ('functions.php');
require('partials/head.php');
require('partials/aside.php');

require("classes/validation_input.php");


$validation = new Validation(); // Felder validieren
$errors = []; // Input Fehler

$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // ID des Users wird aus URL mitgegeben (GET)

$query = $db->prepare("SELECT * FROM Users WHERE id = :id");
$query->bindParam(':id', $userId, PDO::PARAM_INT); // integer 
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// print_r($user);
// echo '</pre>'; 

if (!$user) {
    echo 'User wurde nicht gefunden.';
    exit();
}	


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Felder validieren
	$title = $_POST['title'];
	$firstName = $validation->validate('first-name', 'notEmpty', 'validUsername', $_POST['first-name']);
	$lastName = $validation->validate('last-name', 'notEmpty', 'validUsername', $_POST['last-name']);
	$city = $validation->desinfect($_POST['city']);
	$street = $validation->desinfect($_POST['street']);
	$postcode = $validation->desinfect($_POST['postcode']);
	$email = $validation->validate('email', 'notEmpty', 'validMail', $_POST['email']);

	$errors = $validation->errorsArr;

	// Wenn keine Fehler vorhanden, Daten in Datenbank schreiben
	if(empty($errors)) {
	// Daten in Datenbank aktualisieren
	try {
		// prepare - Abfrage vorbereiten (SQL Injection vermeiden)
		$query = $db->prepare("UPDATE Users SET title = :title, first_name = :first_name, last_name = :last_name, city = :city, street = :street, postcode = :postcode, email = :email WHERE id = :id"); 
		$query->bindParam(':title', $title); // Parameter zuweisen
		$query->bindParam(':first_name', $firstName);
		$query->bindParam(':last_name', $lastName);
		$query->bindParam(':city', $city);
		$query->bindParam(':street', $street);
		$query->bindParam(':postcode', $postcode);
		$query->bindParam(':email', $email);
		$query->bindParam(':id', $userId, PDO::PARAM_INT); 
		$query->execute(); // execute - Abfrage ausführen
	} catch (PDOException $e) {
		echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
	}

	// Benutzer weiterleiten
	header("location: cms_clients.php?editing_success=true"); 
	ob_end_flush(); // Outputbuffer flushen (Header-Fehler vermeiden)
	exit();
	}
}

?>


<main class="main-content">

	<section class="create-form">

		<div class="create-form__header">
			<p>Einen Kunden-Eintrag bearbeiten</p>
		</div>

		<form class="create-form__body" id="form-03" method="POST" enctype="multipart/form-data" action="#">

			<div class="create-form__lines">

			<div class="create-form__line">
					<label class="create-form__label" for="title-04">Anrede *</label>
					<select class="create-form__input" id="title-04" name="title" value="" autocomplete="off"
						type="text">
						<option value="1" <?php if ($user['title'] == 1) echo 'selected'; ?>
							>Herr</option>
						<option value="2" <?php if ($user['title'] == 2) echo 'selected'; ?>
							>Frau</option>
						<option value="3" <?php if ($user['title'] == 3) echo 'selected'; ?>
							>Divers</option>
					</select>
				</div>

				<div class="create-form__line">
					<label class="create-form__label" for="first-name-04">Vorname *</label>
					<input class="create-form__input" id="first-name-04" name="first-name"
						value="<?= htmlspecialchars($user['first_name']); ?>" autocomplete="off"
						type="text" placeholder="Vorname hinzufügen" />
					<?php if (isset($validation->errorsArr['first-name'])): ?>
					<p class="registration__error">
						<?= $validation->errorsArr['first-name'][0] ?>
					</p>
					<?php endif; ?>
				</div>

				<div class="create-form__line">
					<label class="create-form__label" for="last-name-04">Nachname *</label>
					<input class="create-form__input" id="last-name-04" name="last-name"
						value="<?= htmlspecialchars($user['last_name']); ?>" autocomplete="off"
						type="text" placeholder="Nachname hinzufügen" />
					<?php if (isset($validation->errorsArr['last-name'])): ?>
					<p class="registration__error">
						<?= $validation->errorsArr['last-name'][0] ?>
					</p>
					<?php endif; ?>
				</div>

				<div class="create-form__line">
					<label class="create-form__label" for="city-04">Stadt</label>
					<input class="create-form__input" id="city-04" name="city"
						value="<?= htmlspecialchars($user['city']); ?>" autocomplete="off" type="text"
						placeholder="Stadt hinzufügen" />
					<?php if (isset($validation->errorsArr['city'])): ?>
					<p class="registration__error">
						<?= $validation->errorsArr['city'][0] ?>
					</p>
					<?php endif; ?>
				</div>

				<div class="create-form__line">
					<label class="create-form__label" for="street-04">Adresse</label>
					<input class="create-form__input" id="street-04" name="street"
						value="<?= htmlspecialchars($user['street']); ?>" autocomplete="off" type="text"
						placeholder="Strasse und Hausnummer hinzufügen" />
					<?php if (isset($validation->errorsArr['street'])): ?>
					<p class="registration__error">
						<?= $validation->errorsArr['street'][0] ?>
					</p>
					<?php endif; ?>
				</div>

				<div class="create-form__line">
					<label class="create-form__label" for="postcode-04">Postleitzahl</label>
					<input class="create-form__input" id="postcode-04" name="postcode"
						value="<?= htmlspecialchars($user['postcode']); ?>" autocomplete="off"
						type="text" placeholder="PLZ hinzufügen" />
					<?php if (isset($validation->errorsArr['postcode'])): ?>
					<p class="registration__error">
						<?= $validation->errorsArr['postcode'][0] ?>
					</p>
					<?php endif; ?>
				</div>

				<div class="create-form__line">
					<label class="create-form__label" for="email-04">E-Mail-Adresse *</label>
					<input class="create-form__input" id="email-04" name="email"
						value="<?= htmlspecialchars($user['email']); ?>" autocomplete="off" type="text"
						placeholder="E-Mail-Adresse hinzufügen" />
					<?php if (isset($validation->errorsArr['email'])): ?>
					<p class="registration__error">
						<?= $validation->errorsArr['email'][0] ?>
					</p>
					<?php endif; ?>
				</div>

			</div>

			<div class="button-container">
			<a href = "cms_clients.php"><button class="create-form__button cancel-button" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M6.75781 17.2431L12.0008 12.0001L17.2438 17.2431M17.2438 6.75708L11.9998 12.0001L6.75781 6.75708" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>Abbrechen</button></a>
			<button class="create-form__button" id="submit-03" type="submit" name="create-button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M20.7806 12.5306L14.0306 19.2806C13.8899 19.4213 13.699 19.5003 13.5 19.5003C13.301 19.5003 13.1101 19.4213 12.9694 19.2806C12.8286 19.1398 12.7496 18.949 12.7496 18.7499C12.7496 18.5509 12.8286 18.36 12.9694 18.2193L18.4397 12.7499H3.75C3.55109 12.7499 3.36032 12.6709 3.21967 12.5303C3.07902 12.3896 3 12.1988 3 11.9999C3 11.801 3.07902 11.6103 3.21967 11.4696C3.36032 11.3289 3.55109 11.2499 3.75 11.2499H18.4397L12.9694 5.78055C12.8286 5.63982 12.7496 5.44895 12.7496 5.24993C12.7496 5.05091 12.8286 4.86003 12.9694 4.7193C13.1101 4.57857 13.301 4.49951 13.5 4.49951C13.699 4.49951 13.8899 4.57857 14.0306 4.7193L20.7806 11.4693C20.8504 11.539 20.9057 11.6217 20.9434 11.7127C20.9812 11.8038 21.0006 11.9014 21.0006 11.9999C21.0006 12.0985 20.9812 12.1961 20.9434 12.2871C20.9057 12.3782 20.8504 12.4609 20.7806 12.5306Z" fill="white"/>
</svg>
					<?=$textButton?>
				</button>
			</div>

		</form>

	</section>

</main>


</div>

</div>

<script>

const inputElement = document.querySelector(".create-form__img");
inputElement.addEventListener("change", handleFiles, false);

const dropzone = document.querySelector(".create-form__container");
dropzone.addEventListener('dragenter', highlightDropzone, false);
dropzone.addEventListener('dragover', highlightDropzone, false);
dropzone.addEventListener('dragleave', unhighlightDropzone, false);
dropzone.addEventListener('drop', dropFunction, false);

function highlightDropzone(event) {
    dropzone.classList.add('highlight')
    event.preventDefault();
    event.stopPropagation();
}

function unhighlightDropzone(event) {
    dropzone.classList.remove('highlight')
    event.preventDefault();
    event.stopPropagation();
}

function dropFunction(event) {
    dropzone.classList.remove('highlight')
    event.preventDefault();
    event.stopPropagation();

    if (event.dataTransfer.items.length > 1) {
        alert("Sie können nur eine Datei auf's Mal hochladen");
    }
    else {
        let mime = event.dataTransfer.items[0].type;
        if (mime.startsWith("image/")) {
            let dt = event.dataTransfer;
            let filesFromTransfer = dt.files;
            // Hier findet die "Übergabe" an das Upload-Form statt
            inputElement.files = filesFromTransfer;
            handleFiles();
        }
        else {
            alert("Unerlaubter Dateityp, bitte wählen Sie ein Bild aus");
        }
    }
}

function handleFiles() {
    const fileList = inputElement.files;
    const myFile = fileList[0];

    if (myFile.type.startsWith("image/")) {
    }
    else {
        alert("Unerlaubter Dateityp, bitte wählen Sie ein Bild aus");
    }
}

</script>

</body>

</html>
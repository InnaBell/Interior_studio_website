<?php
require_once('config.php'); // Datenbank Credentials laden
require_once('library/database.php'); // DB Funktion laden
require( 'library/session.php' ); // Session Funktionen laden

session_name( md5(SESSION_NAME) );
session_start();

// Überprüfen, ob die Sitzung aktiv ist
$isLoggedIn = check_usersession();

$db = db_connect(); // Datenbankverbindung herstellen

ob_start(); // Starte den Outputbuffering (Header-Fehler vermeiden)

require("classes/validation_input.php");

$validation = new Validation(); // Felder validieren
$errors = []; // Input Fehler

// prüfen, ob die Daten angekommen sind
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Abfragen ob User schon existiert
	if(!empty($_POST["email"])) {
		$query = "SELECT * FROM `Administrators` WHERE `email` = :email";
		$statement = $db->prepare( $query );
		$statement->execute( array( 'email' => $_POST['email']) );
		$userCount = $statement->rowCount(); // Anzahl der Zeilen mit der E-Mail
		
		if ($userCount > 0) { // User existiert bereits
			$validation->addError("email", "Ein Benutzer mit dieser E-Mail-Adresse existiert bereits.");
		}
	}

	  if (empty($_POST["password-repeat"])) {
		$validation->addError("password-repeat", "Wiederholen Sie bitte Ihr Passwort.");
	} elseif ($_POST["password-repeat"] !== $_POST["password"]) {
		$validation->addError("password-repeat", "Passwort ist nicht identisch.");
	  } 

	if(!isset($_POST["terms"])) {
		$validation->addError("terms", "Man muss zustimmen, um fortzufahren.");
	}


	// Felder validieren
	$firstName = $validation->validate('first-name', 'notEmpty', 'validUsername', $_POST['first-name']);
	$email = $validation->validate('email', 'notEmpty', 'validMail', $_POST['email']);
	$password = $validation->validate('password', 'notEmpty', 'validPassword', $_POST['password']);
	$password = password_hash($password, PASSWORD_DEFAULT); // Passwort verschlüsseln
	$passwordRepeat = $validation->desinfect($_POST['password-repeat']);
	
	$errors = $validation->errorsArr;

	// Wenn keine Fehler vorhanden, Daten in Datenbank schreiben
	if(empty($errors)) {
		// Daten in Datenbank schreiben
		try {
			// prepare - Abfrage vorbereiten (SQL Injection vermeiden)
			$query = $db->prepare("INSERT INTO Administrators (name, email, password) VALUES(:firstName, :email, :password)"); 
			$query->bindParam(':firstName', $firstName); // Parameter zuweisen
			$query->bindParam(':email', $email);
			$query->bindParam(':password', $password);
			$query->execute(); // execute - Abfrage ausführen
		} catch (PDOException $e) {
			echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
		}
	
		// Benutzer weiterleiten
		header("location: sign_in.php?registration_success=true"); 
		ob_end_flush(); // Outputbuffer flushen (Header-Fehler vermeiden)
		exit();
		}
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://use.typekit.net/hwv6nai.css">
	<title>ID:studio</title>
</head>

<body class="dark-background">
	<div class="wrapper">


		<header class="header sticky dark-background">
			<div class="header__container">
				<a class="logo-small white-font" href="index.html">id<span class="accent-color">:</span>studio</a>
			</div>
		</header>

		<main class="page">

			<section class="page__registration">
				<div class="registration__container">

					<div class="registration__header">
						<h5>ERSTELLEN SIE IHREN ACCOUNT</h5>
					</div>

					<form class="registration__form" id="form-02" method="POST" action="">

						<div class="registration__lines">

							<div class="registration__line">
								<label class="registration__label" for="first-name-02"></label>
								<input class="registration__input" id="first-name-02" name="first-name" value = "<?php if (isset($_POST['first-name'])) { echo $firstName; } ?>"
									autocomplete="off" type="text" placeholder="Name *" />
									<?php if (isset($validation->errorsArr['first-name'])): ?>
										<p class="registration__error">
									<?= $validation->errorsArr['first-name'][0] ?>
										</p>
									<?php endif; ?>
								</div>

							<div class="registration__line">
								<label class="registration__label" for="email-02"></label>
								<input class="registration__input" id="email-02" name="email" value="<?php if (isset($_POST['email'])) { echo $email; } ?>"
									autocomplete="off" type="email" placeholder="E-Mail *" />
									<?php if (isset($validation->errorsArr['email'])): ?>
										<p class="registration__error">
									<?= $validation->errorsArr['email'][0] ?>
										</p>
									<?php endif; ?>
								</div>

							<div class="registration__line">
								<label class="registration__label" for="password-02"></label>
								<input class="registration__input" id="password-02" name="password" value=""
									autocomplete="off" type="password" placeholder="Passwort *" />
									<?php if (isset($validation->errorsArr['password'])): ?>
										<p class="registration__error">
									<?= $validation->errorsArr['password'][0] ?>
										</p>
									<?php endif; ?>
								</div>

								<div class="registration__line">
								<label class="registration__label" for="password-repeat-02"></label>
								<input class="registration__input" id="password-repeat-02" name="password-repeat" value=""
									autocomplete="off" type="password" placeholder="Passwort wiederholen *" />
									<?php if (isset($validation->errorsArr['password-repeat'])): ?>
										<p class="registration__error">
									<?= $validation->errorsArr['password-repeat'][0] ?>
										</p>
									<?php endif; ?>
								</div>


							<div class="registration__line">
								<div class="checkbox">
								<input id="terms-02" class="checkbox__input" autocomplete="off" value="yes"
									name="terms" type="checkbox" checked >
									<label class="checkbox__label" for="terms-02">Ich stimme der <a
											href="#">Datenschutzerklärung</a> zu</label>
								</div>
								<?php if (!empty($validation->errorsArr['terms'])): ?>
										<p class="registration__error">
									<?= $validation->errorsArr['terms'][0] ?>
										</p>
									<?php endif; ?>
							</div>

						</div>

						<button class="main__button center button-new" id="submit" type="submit">Erstellen</button>

						<p class = "registration-link">Haben Sie schon ein Konto? <a href="sign_in.php">Anmelden</a></p>

					</form>
				</div>

			</section>

		</main>

	</div>
</body>

</html>
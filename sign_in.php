<?php
require( 'config.php' ); // Config werte laden
require( 'library/database.php' ); // DB Funktionen laden
require( 'library/session.php' ); // DB Funktionen laden

// Sessionnamen ändern (Sicherheitsschutz), default "PHPSESSID"
session_name( md5(SESSION_NAME) );
session_start();

$db = db_connect();


if (isset($_POST['email']) && isset($_POST['password'])) {
	  // existiert die angegebene E-Mail?
	  $query = "SELECT * FROM `Administrators` WHERE `email` = :email LIMIT 1"; //LIMIT 1 - nur eine Zeile 
	  $statement = $db->prepare( $query );
	  $statement->execute( array( 'email' => $_POST['email']) );
	  $userdaten = $statement->fetch();
  
	  // wenn der User gefunden, Passwort vergleichen
	  if($userdaten !== false){
		  $passwordKorrekt = password_verify($_POST['password'], $userdaten['password']);
  
		  if($passwordKorrekt == true){
			  create_usersession();
			  $_SESSION['user_id'] = $userdaten['ID'];
			  header("location: cms_dashboard.php"); // Weiterleitung zum geschützten Bereich
		  } else {
			$errorMessage = 'E-Mail oder Passwort ist nicht korrekt';
		}
	  } else {
		$errorMessage = 'E-Mail oder Passwort ist nicht korrekt';
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
				<a class="back-link" href="sign_up.php">Zurück</a>
				<a class="logo-small white-font" href="index.html">id<span class="accent-color">:</span>studio</a>
			</div>
		</header>

		<main class="page">

			<section class="page__registration">
				<div class="registration__container">

					<div class="registration__header margin-bottom-xs">
						<h5>ANMELDEN</h5>
					</div>

					<?php
					if (isset($_GET['registration_success']) && $_GET['registration_success'] === 'true') {
						echo '<p class="registration__success">Danke für Ihre Registrierung! Sie können sich jetzt einloggen.</p>';
					}
					?>

					<form class="registration__form" id="form-02" method="POST" action="">

						<div class="registration__lines">

							<div class="registration__line">
								<label class="registration__label" for="email-02"></label>
								<input class="registration__input" id="email-02" name="email" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>"
									autocomplete="off" type="email" placeholder="E-Mail *" />
								</div>

							<div class="registration__line">
								<label class="registration__label" for="password-02"></label>
								<input class="registration__input" id="password-02" name="password" value="<?php if (isset($_POST['password'])) { echo $_POST['password']; } ?>"
									autocomplete="off" type="password" placeholder="Passwort *" />
									<?php
									if(isset($errorMessage)){
										echo '<p class = "registration__error">'.$errorMessage.'</p>';
									}
									?>						
								</div>

						</div>

						<p class = "registration-link">Passwort <a href="#">vergessen</a>?</p>

						<button class="main__button center button-new gap-small" id="submit" type="submit">Anmelden</button>

						<p class = "registration-link">Haben Sie noch kein Konto? <a href="sign_up.php">Registrieren</a></p>

					</form>
				</div>

			</section>

		</main>

	</div>
</body>

</html>

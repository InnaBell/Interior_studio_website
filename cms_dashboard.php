<?php
require( 'config.php' ); // Config werte laden
require( 'library/database.php' ); // DB Funktionen laden
require( 'library/session.php' ); // Session Funktionen laden


session_name( md5(SESSION_NAME) );
session_start();

// Überprüfen, ob die Sitzung aktiv ist
$isLoggedIn = check_usersession();

$db = db_connect();

$titlePage = 'Dashboard';
$heading = 'Möchten Sie Ihre Webseite besuchen?';
$subHeading = 'Schauen Sie sich Ihre Website an'; 
$textButton = 'Ansehen';
$textNotification = 'Der User';

require ('functions.php');
require('partials/head.php');
require('partials/aside.php');

// Name des Admins aus der Datenbank abfragen
$userdaten = false;

if (isset($_SESSION['user_id'])) {
	$query = "SELECT * FROM `Administrators` WHERE `ID` = :id";
	$statement = $db->prepare( $query );
	$statement->execute( array( 'id' => $_SESSION['user_id']) );
	$userdaten = $statement->fetch( PDO::FETCH_ASSOC );
}

?>


<main class="main-content">
	<div class="main-content-sticky">

	<div class="main-header__head">
		<h3 class="head__title"><?= $titlePage ?></h3>
		<h5 class="head__subtitle">Willkommen
			<?= !$userdaten ? 'Account' : $userdaten['name']; // Name des Admins anzeigen
							?>!
		</h5>
	</div>

	<div class="main-header-container">
		
	<div class="main-header cards">
		<div class="main-header__body card">
			<div class="main-header__text">
				<h5 class="main-header__title">
				<?= $heading ?>
				</h5>
				<p class="main-header__subtitle">
				<?= $subHeading ?>
				</p>
			</div>

			<a href = "index.html">
			<button class="main-header__button" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  <path d="M20.7806 12.5306L14.0306 19.2806C13.8899 19.4213 13.699 19.5003 13.5 19.5003C13.301 19.5003 13.1101 19.4213 12.9694 19.2806C12.8286 19.1398 12.7496 18.949 12.7496 18.7499C12.7496 18.5509 12.8286 18.36 12.9694 18.2193L18.4397 12.7499H3.75C3.55109 12.7499 3.36032 12.6709 3.21967 12.5303C3.07902 12.3896 3 12.1988 3 11.9999C3 11.801 3.07902 11.6103 3.21967 11.4696C3.36032 11.3289 3.55109 11.2499 3.75 11.2499H18.4397L12.9694 5.78055C12.8286 5.63982 12.7496 5.44895 12.7496 5.24993C12.7496 5.05091 12.8286 4.86003 12.9694 4.7193C13.1101 4.57857 13.301 4.49951 13.5 4.49951C13.699 4.49951 13.8899 4.57857 14.0306 4.7193L20.7806 11.4693C20.8504 11.539 20.9057 11.6217 20.9434 11.7127C20.9812 11.8038 21.0006 11.9014 21.0006 11.9999C21.0006 12.0985 20.9812 12.1961 20.9434 12.2871C20.9057 12.3782 20.8504 12.4609 20.7806 12.5306Z" fill="white"/>
</svg>
				<?=$textButton?>
			</button>
			</a>
		</div>

	</div>

	<div class="main-header cards">
		<div class="main-header__body card">
			<div class="main-header__text">
				<h5 class="main-header__title">
				Möchten Sie einen neuen Kunden hinzufügen?
				</h5>
				<p class="main-header__subtitle">
				Lege einen Benutzer an
				</p>
			</div>

			<a href = "cms_clients_add.php">
			<button class="main-header__button" type="button"><svg
					xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path
						d="M11.883 3.007L12 3C12.2449 3.00003 12.4813 3.08996 12.6644 3.25272C12.8474 3.41547 12.9643 3.63975 12.993 3.883L13 4V11H20C20.2449 11 20.4813 11.09 20.6644 11.2527C20.8474 11.4155 20.9643 11.6397 20.993 11.883L21 12C21 12.2449 20.91 12.4813 20.7473 12.6644C20.5845 12.8474 20.3603 12.9643 20.117 12.993L20 13H13V20C13 20.2449 12.91 20.4813 12.7473 20.6644C12.5845 20.8474 12.3603 20.9643 12.117 20.993L12 21C11.7551 21 11.5187 20.91 11.3356 20.7473C11.1526 20.5845 11.0357 20.3603 11.007 20.117L11 20V13H4C3.75507 13 3.51866 12.91 3.33563 12.7473C3.15259 12.5845 3.03566 12.3603 3.007 12.117L3 12C3.00003 11.7551 3.08996 11.5187 3.25272 11.3356C3.41547 11.1526 3.63975 11.0357 3.883 11.007L4 11H11V4C11 3.75507 11.09 3.51866 11.2527 3.33563C11.4155 3.15259 11.6397 3.03566 11.883 3.007Z"
						fill="white" />
				</svg>
				Hinzufügen
			</button>
			</a>
		</div>

	</div>

	<div class="main-header cards">
		<div class="main-header__body card">
			<div class="main-header__text">
				<h5 class="main-header__title">
				Möchten Sie einen neuen Beitrag hinzufügen?
				</h5>
				<p class="main-header__subtitle">
				Hier können Sie einen neuen Beitrag hinzufügen
				</p>
			</div>

			<a href = "cms_posts_add.php">
			<button class="main-header__button" type="button"><svg
					xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path
						d="M11.883 3.007L12 3C12.2449 3.00003 12.4813 3.08996 12.6644 3.25272C12.8474 3.41547 12.9643 3.63975 12.993 3.883L13 4V11H20C20.2449 11 20.4813 11.09 20.6644 11.2527C20.8474 11.4155 20.9643 11.6397 20.993 11.883L21 12C21 12.2449 20.91 12.4813 20.7473 12.6644C20.5845 12.8474 20.3603 12.9643 20.117 12.993L20 13H13V20C13 20.2449 12.91 20.4813 12.7473 20.6644C12.5845 20.8474 12.3603 20.9643 12.117 20.993L12 21C11.7551 21 11.5187 20.91 11.3356 20.7473C11.1526 20.5845 11.0357 20.3603 11.007 20.117L11 20V13H4C3.75507 13 3.51866 12.91 3.33563 12.7473C3.15259 12.5845 3.03566 12.3603 3.007 12.117L3 12C3.00003 11.7551 3.08996 11.5187 3.25272 11.3356C3.41547 11.1526 3.63975 11.0357 3.883 11.007L4 11H11V4C11 3.75507 11.09 3.51866 11.2527 3.33563C11.4155 3.15259 11.6397 3.03566 11.883 3.007Z"
						fill="white" />
				</svg>
				Hinzufügen
			</button>
			</a>
		</div>

	</div>
	</div>

	<script>
		function redirectToPage() {
			window.location.href = 'cms_clients_add.php';
		}
	</script>


	</div>

	<div class="clients-header">
		<h5 class="clients-header__title">Meine Kunden</h5>
	</div>

	<div class="clients">

		<?php
		if (isset($_GET['adding_success']) && $_GET['adding_success'] === 'true') {
		echo '<p class="registration__success left-align">'. $textNotification .' wurde erfolgleich hinzugefügt.</p>';
		}
		if (isset($_GET['editing_success']) && $_GET['editing_success'] === 'true') {
			echo '<p class="registration__success left-align">'. $textNotification .' wurde erfolgleich bearbeitet.</p>';
		}
		if (isset($_GET['deletion_success']) && $_GET['deletion_success'] === 'true') {
			echo '<p class="registration__success left-align">'. $textNotification .' wurde erfolgleich gelöscht.</p>';
		}
	?>

		<table class="clients__table">
			<thead class="clients__thead">
				<tr class="clients__row">
					<th class="clients__header"></th>
					<th class="clients__header">Vorname</th>
					<th class="clients__header">Nachname</th>
					<th class="clients__header">Anrede</th>
					<th class="clients__header">Stadt</th>
					<th class="clients__header">Adresse</th>
					<th class="clients__header">PLZ</th>
					<th class="clients__header">E-Mail</th>
					<th class="clients__header">Nachricht</th>
				</tr>
			</thead>
			<tbody class="clients__tbody">
			<?php 
				// Abfrage erstellen und in die Tabelle schreiben 
				try {
					// prepare - Abfrage vorbereiten (SQL Injection vermeiden)
					$query = $db->prepare("SELECT * FROM `Users`"); 
					$query->execute();
					$users = $query -> fetchAll( PDO::FETCH_ASSOC );
				} catch (PDOException $e) {
					echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
				}

				// Category abfragen
				foreach ($users as $user) {

					?>
					<tr class="clients__row">
					<td class="clients__actions">
						<a class="clients__edit" href="cms_clients_edit.php?id=<?= $user['ID'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
								viewBox="0 0 24 24" fill="none">
								<path
									d="M15.4721 3.12C16.1903 2.40206 17.1643 1.99883 18.1798 1.99902C19.1953 1.9992 20.1691 2.40279 20.8871 3.121C21.605 3.83921 22.0083 4.8132 22.0081 5.82871C22.0079 6.84422 21.6043 7.81806 20.8861 8.536L20.4181 9.004L15.0041 3.59L15.4721 3.12ZM13.5901 5.004L3.30008 15.292C3.16119 15.4315 3.06657 15.6089 3.02808 15.802L2.02008 20.802C1.9872 20.9636 1.99479 21.1308 2.04218 21.2888C2.08957 21.4467 2.17528 21.5905 2.29169 21.7073C2.4081 21.8241 2.5516 21.9103 2.70939 21.9583C2.86718 22.0062 3.03438 22.0143 3.19608 21.982L8.20408 20.982C8.39738 20.943 8.57482 20.8476 8.71408 20.708L19.0041 10.418L13.5901 5.004Z"
									fill="#434040" />
							</svg></a>

						<a class="clients__delete" href="cms_clients_delete.php?id=<?= $user['ID'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
								viewBox="0 0 24 24" fill="none">
								<path
									d="M7 21C6.45 21 5.97933 20.8043 5.588 20.413C5.19667 20.0217 5.00067 19.5507 5 19V6H4V4H9V3H15V4H20V6H19V19C19 19.55 18.8043 20.021 18.413 20.413C18.0217 20.805 17.5507 21.0007 17 21H7ZM9 17H11V8H9V17ZM13 17H15V8H13V17Z"
									fill="#434040" />
							</svg></a>

					</td>
					<td class="clients__cell"><?= $user['first_name'] ?></td>
					<td class="clients__cell"><?= $user['last_name'] ?></td>
					<td class="clients__cell"><?= $user['title'] ?></td>
					<td class="clients__cell"><?= $user['city'] ?></td>
					<td class="clients__cell street-field"><?= $user['street'] ?></td>
					<td class="clients__cell"><?= $user['postcode'] ?></td>
					<td class="clients__cell"><?= $user['email'] ?></td>
					<td class="clients__cell"><?= $user['message'] ?></td>
				</tr>
					<?php
				}
				?>
		
			</tbody>
		</table>

	</div>

</main>



<?php require('partials/footer.php') ?>
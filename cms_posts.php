<?php
require_once( 'config.php' ); // Config werte laden
require_once( 'library/database.php' ); // DB Funktionen laden
require_once( 'library/session.php' ); // Session Funktionen laden


session_name( md5(SESSION_NAME) );
session_start();

// Überprüfen, ob die Sitzung aktiv ist
$isLoggedIn = check_usersession();

$db = db_connect();

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

$titlePage = 'Posts';
$heading = 'Möchten Sie einen neuen Beitrag hinzufügen?';
$subHeading = 'Hier können Sie einen neuen Beitrag eines Kunden hinzufügen'; 
$textButton = 'Hinzufügen';
$textNotification = 'Der Beitrag';

require ('functions.php');
require('partials/head.php');
require('partials/aside.php');

?>


<main class="main-content">

	<?php require('partials/header.php') ?>

	<script>
		function redirectToPage() {
			window.location.href = 'cms_posts_add.php';
		}
	</script>

	<div class="clients">

		<?php
		if (isset($_GET['adding_success']) && $_GET['adding_success'] === 'true') {
		echo '<p class="registration__success left-align">'. $textNotification .' wurde erfolgleich hinzugefügt. Auf der Webseite <a href="feedback.php">ansehen</a></p>';
		}
		if (isset($_GET['editing_success']) && $_GET['editing_success'] === 'true') {
			echo '<p class="registration__success left-align">'. $textNotification .' wurde erfolgleich bearbeitet. Auf der Webseite <a href="feedback.php">ansehen</a></p>';
		}
		if (isset($_GET['deletion_success']) && $_GET['deletion_success'] === 'true') {
			echo '<p class="registration__success left-align">'. $textNotification .' wurde erfolgleich gelöscht. Auf der Webseite <a href="feedback.php">ansehen</a></p>';
		}
	?>

		<table class="clients__table">
			<thead class="clients__thead">
				<tr class="clients__row">
					<th class="clients__header-edit"></th>
					<th class="clients__header">Titel</th>
					<th class="clients__header">Autor(in)</th>
					<th class="clients__header">Kategorie</th>
					<th class="clients__header text-field">Text</th>
					<th class="clients__header">Bildpfad</th>
					<th class="clients__header">Datum</th>
				</tr>
			</thead>
			<tbody class="clients__tbody">

				<?php 
				// Abfrage erstellen und in die Tabelle schreiben 
				try {
					// prepare - Abfrage vorbereiten (SQL Injection vermeiden)
					$query = $db->prepare("SELECT * FROM `Posts`"); 
					$query->execute();
					$posts = $query -> fetchAll( PDO::FETCH_ASSOC );
				} catch (PDOException $e) {
					echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
				}

					// echo '<pre>';
					// print_r($posts);
					// echo '</pre>';

				// Category abfragen
				foreach ($posts as $post) {

					try {
						$query = $db->prepare("SELECT * FROM `Posts_category` WHERE `id` = :id"); 
						$query->execute(['id' => $post['category_id']]);
						$category = $query -> fetchAll( PDO::FETCH_ASSOC );
					} catch (PDOException $e) {
						echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
					}
					?>
				<tr class="clients__row">
					<td class="clients__actions">
						<a class="clients__edit" href="cms_posts_edit.php?id=<?= $post['ID'] ?>"><svg
								xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none">
								<path
									d="M15.4721 3.12C16.1903 2.40206 17.1643 1.99883 18.1798 1.99902C19.1953 1.9992 20.1691 2.40279 20.8871 3.121C21.605 3.83921 22.0083 4.8132 22.0081 5.82871C22.0079 6.84422 21.6043 7.81806 20.8861 8.536L20.4181 9.004L15.0041 3.59L15.4721 3.12ZM13.5901 5.004L3.30008 15.292C3.16119 15.4315 3.06657 15.6089 3.02808 15.802L2.02008 20.802C1.9872 20.9636 1.99479 21.1308 2.04218 21.2888C2.08957 21.4467 2.17528 21.5905 2.29169 21.7073C2.4081 21.8241 2.5516 21.9103 2.70939 21.9583C2.86718 22.0062 3.03438 22.0143 3.19608 21.982L8.20408 20.982C8.39738 20.943 8.57482 20.8476 8.71408 20.708L19.0041 10.418L13.5901 5.004Z"
									fill="#434040" />
							</svg></a>

						<a class="clients__delete" href="cms_posts_delete.php?id=<?= $post['ID'] ?>"><svg
								xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
								fill="none">
								<path
									d="M7 21C6.45 21 5.97933 20.8043 5.588 20.413C5.19667 20.0217 5.00067 19.5507 5 19V6H4V4H9V3H15V4H20V6H19V19C19 19.55 18.8043 20.021 18.413 20.413C18.0217 20.805 17.5507 21.0007 17 21H7ZM9 17H11V8H9V17ZM13 17H15V8H13V17Z"
									fill="#434040" />
							</svg></a>

					</td>
					<td class="clients__cell clients__cell--padding">
						<?= $post['title'] ?>
					</td>
					<td class="clients__cell clients__cell--padding">
						<?= $post['author'] ?>
					</td>
					<td class="clients__cell clients__cell--padding">
						<?= $category[0]['label'] ?>
					</td>
					<td class="clients__cell clients__cell--padding">
						<?= $post['text'] ?>
					</td>
					<td class="clients__cell clients__cell--padding">
						<?= $post['image'] ?>
					</td>
					<td class="clients__cell clients__cell--padding">
						<?= $post['created_at'] ?>
					</td>
				</tr>

				<?php
				}
				?>
			</tbody>
		</table>

	</div>

</main>



<?php require('partials/footer.php') ?>
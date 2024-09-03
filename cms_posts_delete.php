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

$titlePage = 'Posts';
$textButton = 'Löschen';

require ('functions.php');
require('partials/head.php');
require('partials/aside.php');

$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0; // ID des Blogposts wird aus URL mitgegeben (GET)

$query = $db->prepare("SELECT * FROM Posts WHERE id = :id");
$query->bindParam(':id', $postId, PDO::PARAM_INT); // integer 
$query->execute();
$post = $query->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// print_r($post);
// echo '</pre>'; 

if (!$post) {
    echo 'Post wurde nicht gefunden.';
    exit();
}

// Beitrag löschen
if (isset($_POST['delete-button'])) {
    try {
		$imageName = $post['image']; // Dateiname des Bildes aus der Datenbank abfragen
		
        $query = $db->prepare("DELETE FROM Posts WHERE id = :id");
        $query->bindParam(':id', $postId, PDO::PARAM_INT); // integer 
        $query->execute();

		// Bild aus dem Verzeichnis löschen
		if ($imageName && file_exists($imageName)) {
            unlink($imageName);
        }
        
        header("Location: cms_posts.php?deletion_success=true");
        exit();
    } catch (PDOException $e) {
        echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
    }

}	

?>


<main class="main-content">

	<section class="create-form">

		<div class="create-form__header">
			<p>Sind Sie sicher, dass Sie diesen Beitrag löschen möchten?</p>
		</div>

		<form class="create-form__body" id="form-03" method="POST" enctype="multipart/form-data" action="#">

			<div class="button-container button-container--left">
				
				<a href="cms_posts.php"><button class="create-form__button cancel-button" type="button"><svg
							xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<path
								d="M6.75781 17.2431L12.0008 12.0001L17.2438 17.2431M17.2438 6.75708L11.9998 12.0001L6.75781 6.75708"
								stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
						</svg>Abbrechen</button></a>

				<button class="create-form__button" id="submit-05" type="submit" name="delete-button"><svg
						xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<path
							d="M20.7806 12.5306L14.0306 19.2806C13.8899 19.4213 13.699 19.5003 13.5 19.5003C13.301 19.5003 13.1101 19.4213 12.9694 19.2806C12.8286 19.1398 12.7496 18.949 12.7496 18.7499C12.7496 18.5509 12.8286 18.36 12.9694 18.2193L18.4397 12.7499H3.75C3.55109 12.7499 3.36032 12.6709 3.21967 12.5303C3.07902 12.3896 3 12.1988 3 11.9999C3 11.801 3.07902 11.6103 3.21967 11.4696C3.36032 11.3289 3.55109 11.2499 3.75 11.2499H18.4397L12.9694 5.78055C12.8286 5.63982 12.7496 5.44895 12.7496 5.24993C12.7496 5.05091 12.8286 4.86003 12.9694 4.7193C13.1101 4.57857 13.301 4.49951 13.5 4.49951C13.699 4.49951 13.8899 4.57857 14.0306 4.7193L20.7806 11.4693C20.8504 11.539 20.9057 11.6217 20.9434 11.7127C20.9812 11.8038 21.0006 11.9014 21.0006 11.9999C21.0006 12.0985 20.9812 12.1961 20.9434 12.2871C20.9057 12.3782 20.8504 12.4609 20.7806 12.5306Z"
							fill="white" />
					</svg>
					<?=$textButton?>
				</button>

			</div>

		</form>

	</section>

</main>


</div>

</div>

</body>

</html>
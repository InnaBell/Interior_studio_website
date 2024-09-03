<?php
require_once( 'config.php' ); // Config werte laden
require_once( 'library/database.php' ); // DB Funktionen laden
require_once( 'library/session.php' ); // Session Funktionen laden

session_name( md5(SESSION_NAME) );
session_start();

$db = db_connect();
?>


<!DOCTYPE html>
<html lang="de">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/burger_menu.js" defer></script>
	<!-- <script src="js/feedback.js" defer></script> -->
	<link rel="stylesheet" href="https://use.typekit.net/hwv6nai.css">
	<link rel="apple-touch-icon" sizes="180x180" href="img/icons/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="img/icons/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/icons/favicon//favicon-16x16.png">
	<link rel="manifest" href="img/icons/favicon/site.webmanifest">
	<link rel="mask-icon" href="img/icons/favicon/safari-pinned-tab.svg" color="#434040">
	<meta name="msapplication-TileColor" content="#434040">
	<meta name="theme-color" content="#434040">
	<title>ID:studio</title>
</head>

<body>
	<div class="wrapper">
		<header class="header sticky white-overlay">
			<div class="header__container">
				<a class="logo black-font" href="index.html">id<span class="accent-color">:</span>studio</a>

				<div class="header__navigation black-font">

					<div class="header__menu-container">

						<nav class="header__menu">
							<menu class="menu__list">
								<li class="menu__item">
									<a href="index.html" class="menu__link">Startseite</a>
								</li>
								<li class="menu__item">
									<a href="projects.html" class="menu__link">Projekte</a>
								</li>
								<li class="menu__item">
									<a href="services.html" class="menu__link">Services</a>
								</li>
								<li class="menu__item">
									<a href="about.html" class="menu__link">Team</a>
								</li>
								<li class="menu__item">
									<a href="feedback.php" class="menu__link active">Feedback</a>
								</li>
								<li class="menu__item">
									<a href="contacts.html" class="menu__link">Kontakt</a>
								</li>
							</menu>

						</nav>

						<div class="header__socials">
							<span>Folgen Sie uns</span>
							<a href="#" class="header__social">INSTAGRAM</a>
							<a href="#" class="header__social">FACEBOOK</a>
							<a href="#" class="header__social">LINKEDIN</a>
						</div>

					</div>

					<div class="header__actions">

						<div class="header__language black-font">
							<button class="header__lang">ENG</button>
						</div>

						<a href="#" class="header__search" aria-label="Suchen"><svg xmlns="http://www.w3.org/2000/svg"
								width="26" height="26" viewBox="0 0 26 26" fill="none">
								<path
									d="M24.25 24.25L16.75 16.75M1.75 10.5C1.75 11.6491 1.97633 12.7869 2.41605 13.8485C2.85578 14.9101 3.5003 15.8747 4.31282 16.6872C5.12533 17.4997 6.08992 18.1442 7.15152 18.5839C8.21312 19.0237 9.35093 19.25 10.5 19.25C11.6491 19.25 12.7869 19.0237 13.8485 18.5839C14.9101 18.1442 15.8747 17.4997 16.6872 16.6872C17.4997 15.8747 18.1442 14.9101 18.5839 13.8485C19.0237 12.7869 19.25 11.6491 19.25 10.5C19.25 9.35093 19.0237 8.21312 18.5839 7.15152C18.1442 6.08992 17.4997 5.12533 16.6872 4.31282C15.8747 3.5003 14.9101 2.85578 13.8485 2.41605C12.7869 1.97633 11.6491 1.75 10.5 1.75C9.35093 1.75 8.21312 1.97633 7.15152 2.41605C6.08992 2.85578 5.12533 3.5003 4.31282 4.31282C3.5003 5.12533 2.85578 6.08992 2.41605 7.15152C1.97633 8.21312 1.75 9.35093 1.75 10.5Z"
									stroke="#434040" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg></a>

						<button class="header__burger">
							<span></span>
						</button>

					</div>

				</div>
			</div>
		</header>

		<main class="page">

			<section class="page__head margin-bottom-sm">
				<div class="head__container">

					<div class="head__wrapper background-change-feedback">
						<div class="body__wrapper">
							<div class="head__body">
								<h2>FEEDBACK</h2>
								<h6 class="head__text">Was sagen unsere Kunden.</h6>
							</div>
						</div>
					</div>

				</div>
			</section>

			<section class="page__testimonials">
				<div class="testimonials__container">
					<div class="article__title-block title-block margin-bottom-sm">
						<h5 class="accent-color">Professionell, kreativ, zuvorkommend.</h5>
						<h4>“Das Innenarchitekturbüro hat unseren Raum in eine stilvolle Umgebung verwandelt. Wir sind
							begeistert!”</h4>
					</div>

					<div class="testimonials">
						
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

				// Daten in die Tabelle schreiben
				foreach ($posts as $post) {
					try {
						$query = $db->prepare("SELECT * FROM `Posts_category` WHERE `id` = :id"); 
						$query->execute(['id' => $post['category_id']]);
						$category = $query -> fetchAll( PDO::FETCH_ASSOC );
					} catch (PDOException $e) {
						echo 'Fehler beim Ausführen der Abfrage: ' . $e->getMessage();
					}
					?>

						<div class="testimonials__item">

							<div class="testimonials__image">
								<img src="<?= $post['image'] ?>" alt="Foto des Kunden">
							</div>

							<div class="testimonials__text-side">

								<div class="testimonials__quote-left"><svg xmlns="http://www.w3.org/2000/svg" width="42"
										height="32" viewBox="0 0 42 32" fill="none">
										<path
											d="M0.45459 32V23.2727C0.45459 20.697 0.939438 17.9849 1.90914 15.1364C2.87883 12.2879 4.22732 9.56061 5.95459 6.95455C7.68186 4.34849 9.71217 2.12122 12.0455 0.272736L18.7728 5.09091C16.9243 7.78788 15.3485 10.6061 14.0455 13.5455C12.7425 16.4849 12.091 19.6818 12.091 23.1364V32H0.45459ZM23.6364 32V23.2727C23.6364 20.697 24.1213 17.9849 25.091 15.1364C26.0607 12.2879 27.4091 9.56061 29.1364 6.95455C30.8637 4.34849 32.894 2.12122 35.2273 0.272736L41.9546 5.09091C40.1061 7.78788 38.5304 10.6061 37.2273 13.5455C35.9243 16.4849 35.2728 19.6818 35.2728 23.1364V32H23.6364Z"
											fill="#E06337" fill-opacity="0.95" />
									</svg></div>

								<div class="testimonials__body">
									<h5 class="text-side__title"><?= $post['title'] ?></h5>
									<h6 class="text-side__autor"><?= $post['author'] ?> <span><?= $category[0]['label'] ?></span></h6>
									<p class="text-side__comment"><?= $post['text'] ?></p>
								</div>

								<div class="testimonials__quote-right"><svg xmlns="http://www.w3.org/2000/svg"
										width="42" height="33" viewBox="0 0 42 33" fill="none">
										<path
											d="M18.8181 0.909058V9.63633C18.8181 12.2121 18.3333 14.9242 17.3636 17.7727C16.4242 20.5909 15.0909 23.303 13.3636 25.9091C11.6363 28.5151 9.60602 30.7575 7.27268 32.6363L0.54541 27.8181C2.33329 25.2121 3.87874 22.4394 5.18177 19.5C6.51511 16.5606 7.18177 13.3181 7.18177 9.7727V0.909058H18.8181ZM41.9545 0.909058V9.63633C41.9545 12.2121 41.4697 14.9242 40.5 17.7727C39.5606 20.5909 38.2272 23.303 36.5 25.9091C34.7727 28.5151 32.7424 30.7575 30.409 32.6363L23.6818 27.8181C25.4697 25.2121 27.0151 22.4394 28.3181 19.5C29.6515 16.5606 30.3181 13.3181 30.3181 9.7727V0.909058H41.9545Z"
											fill="#E06337" fill-opacity="0.95" />
									</svg></div>
							</div>
						</div>
						<?php
				}
				?>

					</div>

					<button class="projects__button main__button">Entdecke mehr</button>

				</div>

			</section>

			<section class="page__promo margin-bottom-sm promo ">
				<div class="promo__container">
					<div class="promo__text">
						<h3>Gerne stehen wir Ihnen als kreative Interior Designer bei Ihrem bevorstehenden Projekt zur
							Seite.</h3>
						<p>Kontaktieren Sie uns noch heute, um einen ersten Schritt in Richtung Ihrer Traumräume zu
							machen.</p>
						<button class="main__button">Termin vereinbaren</button>
					</div>
				</div>
			</section>

		</main>


		<footer class="footer">
			<div class="footer__container">

				<div class="footer__top">

					<a class="logo light-font" href="index.html">id<span class="accent-color">:</span>studio</a>

					<div class="footer__contacts">
						<div class="adress__link">Luzernerstrasse 64</div>
						<div class="adress__link">5478 Luzern</div>
						<a href="#" class="contacts__link">+41955833179</a>
						<a href="#" class="contacts__link">hallo@idstudio.ch</a>
					</div>

					<div class="footer__navigation">
						<a href="index.html">Startseite</a>
						<a href="projects.html">Projekte</a>
						<a href="services.html">Services</a>
						<a href="about.html">Team</a>
						<a href="feedback.php">Feedback</a>
						<a href="contacts.html">Kontakt</a>
					</div>

					<div class="footer__subscribe">
						<div class="subscribe__title">News und Aktionen</div>

						<form class="subscribe__form">
							<input class="subscribe__input" type="email" placeholder="Deine E-Mail Adresse">
							<button class="main__button" type="submit">Anmelden</button>
						</form>
					</div>

				</div>

				<div class="footer__bottom">

					<p>Copyright © 2023 id:studio</p>

					<div class="footer__legacy">
						<a href="#" class="legacy__link">Datenschutz</a>
						<a href="#" class="legacy__link">Impressum</a>
					</div>

					<div class="footer__icons">
						<a href="#" class="icons__link" aria-label="Instagram">
							<span><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"
									fill="none">
									<path
										d="M8.7 0H21.3C26.1 0 30 3.9 30 8.7V21.3C30 23.6074 29.0834 25.8203 27.4518 27.4518C25.8203 29.0834 23.6074 30 21.3 30H8.7C3.9 30 0 26.1 0 21.3V8.7C0 6.39262 0.916605 4.17974 2.54817 2.54817C4.17974 0.916605 6.39262 0 8.7 0ZM8.4 3C6.96783 3 5.59432 3.56893 4.58162 4.58162C3.56893 5.59432 3 6.96783 3 8.4V21.6C3 24.585 5.415 27 8.4 27H21.6C23.0322 27 24.4057 26.4311 25.4184 25.4184C26.4311 24.4057 27 23.0322 27 21.6V8.4C27 5.415 24.585 3 21.6 3H8.4ZM22.875 5.25C23.3723 5.25 23.8492 5.44754 24.2008 5.79917C24.5525 6.1508 24.75 6.62772 24.75 7.125C24.75 7.62228 24.5525 8.09919 24.2008 8.45082C23.8492 8.80245 23.3723 9 22.875 9C22.3777 9 21.9008 8.80245 21.5492 8.45082C21.1975 8.09919 21 7.62228 21 7.125C21 6.62772 21.1975 6.1508 21.5492 5.79917C21.9008 5.44754 22.3777 5.25 22.875 5.25ZM15 7.5C16.9891 7.5 18.8968 8.29018 20.3033 9.6967C21.7098 11.1032 22.5 13.0109 22.5 15C22.5 16.9891 21.7098 18.8968 20.3033 20.3033C18.8968 21.7098 16.9891 22.5 15 22.5C13.0109 22.5 11.1032 21.7098 9.6967 20.3033C8.29018 18.8968 7.5 16.9891 7.5 15C7.5 13.0109 8.29018 11.1032 9.6967 9.6967C11.1032 8.29018 13.0109 7.5 15 7.5ZM15 10.5C13.8065 10.5 12.6619 10.9741 11.818 11.818C10.9741 12.6619 10.5 13.8065 10.5 15C10.5 16.1935 10.9741 17.3381 11.818 18.182C12.6619 19.0259 13.8065 19.5 15 19.5C16.1935 19.5 17.3381 19.0259 18.182 18.182C19.0259 17.3381 19.5 16.1935 19.5 15C19.5 13.8065 19.0259 12.6619 18.182 11.818C17.3381 10.9741 16.1935 10.5 15 10.5Z"
										fill="#E06337" />
								</svg></span>
						</a>
						<a href="#" class="icons__link" aria-label="Facebook">
							<span><svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30"
									fill="none">
									<path
										d="M30.9166 15C30.9166 6.72 24.0099 0 15.4999 0C6.98992 0 0.083252 6.72 0.083252 15C0.083252 22.26 5.38659 28.305 12.4166 29.7V19.5H9.33325V15H12.4166V11.25C12.4166 8.355 14.837 6 17.8124 6H21.6666V10.5H18.5833C17.7353 10.5 17.0416 11.175 17.0416 12V15H21.6666V19.5H17.0416V29.925C24.827 29.175 30.9166 22.785 30.9166 15Z"
										fill="#E06337" />
								</svg></span>
						</a>
						<a href="#" class="icons__link" aria-label="Linkedin"><span><svg
									xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
									fill="none">
									<path
										d="M24.5 0.5C25.2956 0.5 26.0587 0.81607 26.6213 1.37868C27.1839 1.94129 27.5 2.70435 27.5 3.5V24.5C27.5 25.2956 27.1839 26.0587 26.6213 26.6213C26.0587 27.1839 25.2956 27.5 24.5 27.5H3.5C2.70435 27.5 1.94129 27.1839 1.37868 26.6213C0.81607 26.0587 0.5 25.2956 0.5 24.5V3.5C0.5 2.70435 0.81607 1.94129 1.37868 1.37868C1.94129 0.81607 2.70435 0.5 3.5 0.5H24.5ZM23.75 23.75V15.8C23.75 14.5031 23.2348 13.2593 22.3178 12.3422C21.4007 11.4252 20.1569 10.91 18.86 10.91C17.585 10.91 16.1 11.69 15.38 12.86V11.195H11.195V23.75H15.38V16.355C15.38 15.2 16.31 14.255 17.465 14.255C18.022 14.255 18.5561 14.4762 18.9499 14.8701C19.3438 15.2639 19.565 15.798 19.565 16.355V23.75H23.75ZM6.32 8.84C6.98835 8.84 7.62932 8.5745 8.10191 8.10191C8.5745 7.62932 8.84 6.98835 8.84 6.32C8.84 4.925 7.715 3.785 6.32 3.785C5.64768 3.785 5.00289 4.05208 4.52748 4.52748C4.05208 5.00289 3.785 5.64768 3.785 6.32C3.785 7.715 4.925 8.84 6.32 8.84ZM8.405 23.75V11.195H4.25V23.75H8.405Z"
										fill="#E06337" />
								</svg></span></a>
					</div>
				</div>


			</div>
		</footer>
	</div>
</body>

</html>
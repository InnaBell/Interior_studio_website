<?php
// Werte in die Session schreiben

function create_usersession(): bool {
	// Prüfen ob es eine Session gibt
	if(!isset($_SESSION)) {
		return false;
	}
	$_SESSION['isloggedin'] = true;// login status
	$_SESSION['userip'] = $_SERVER['REMOTE_ADDR']; // IP Speichern für prüfung
	$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT']; // IP Speichern für prüfung
	$_SESSION['timestamp'] = time(); // Timestamp für Zeiteinschränkung

	return true; // Session erstellt
}

// User Session prüfen

function check_usersession():bool { 
	$isLoggedIn = false; // zuerst die Werte prüfen!
	
	if (isset($_SESSION['isloggedin']) && $_SESSION['isloggedin'] === true) {
		$isLoggedIn = true;
		$session_lifetime = SESSION_LIFETIME;

		// Zeit einschränken:
		$timeNow = time(); // Vergangene Sekunden seit letzter Aktivität / letztem Page load
		if($timeNow - $_SESSION['timestamp'] > $session_lifetime) {
			$isLoggedIn = false; // Zu lange inaktiv
		}
	}

    if($isLoggedIn == false){
        delete_usersession(); // session zurücksetzen
    }else{
        session_regenerate_id(); // Ersetzt die aktuelle Session-ID durch eine neu erzeugte
        $_SESSION['timestamp'] = time(); // timestamp erneuern bei jedem page load (NACH allen Überprüfungungen!)
    }

    return $isLoggedIn;
}

// User Session beenden

function delete_usersession(): void {
    unset( $_SESSION['isloggedin'] ); // löschen
    unset( $_SESSION['userip'] );
    unset( $_SESSION['useragent'] );
    unset( $_SESSION['timestamp'] );
	unset( $_SESSION['user_id'] );
	session_destroy();
	header('Location: /../sign_in.php');
	exit();
}


?>
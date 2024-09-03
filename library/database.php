<?php
// Verbindung PHP mit Datenbank (mit PDO) aufbauen + eine Fehlermeldung abfangen

function db_connect(){
	try {
		$db = new PDO('mysql:host='.DBSERVER.';dbname='.DBNAME, DBUSER, DBPASSWORT);
		return $db; // um $db weiterzuverwenden
	} catch (Exception $exception) {
		die( 'MySQL Verbindungsfehler: '.$exception->getMessage() );
		// Abbruch, wenn die DB Verbindung nicht klappt
	}
}


?>
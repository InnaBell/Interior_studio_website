<?php
// Logout - Button zum Ausloggen
require( '../library/session.php' ); 
session_start();
delete_usersession();
?>
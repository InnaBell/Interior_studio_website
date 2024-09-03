<?php


// Validierung von Formularfeldern
class Validation {
	public $hasErrors = false; // Status der Validation
	public $errorsArr = []; // Validierungsfehler


	function desinfect($str): string {
		$str1 = strip_tags($str); // entfernt HTML/PHP-Tags 
		$str2 = preg_replace('/\x00|<[^>]*>?/', '', $str1); // entfernt NULL-Zeichen
        $str3 = str_replace(["'", '"'], ['&#39;', '&#34;'], $str2); // ersetzt Anführungszeichen
        $str4 = htmlspecialchars($str3); // konvertiert HTML-Tags in HTML-Code
        $str5 = trim($str4); // entfernt alle Leerzeichen am Anfang und am Ende eines Strings
        return $str5;
	}

	// Ist das Feld obligatorisch
    function isRequired($name, $duty, $cleanStr): bool {
		// $name - Name des Feldes, $duty - Validierung, $cleanStr - value
        switch ($duty) {
            case "notEmpty":
                if (empty($cleanStr )) {
					$this -> addError($name, "Das Feld darf nicht leer sein.");
                    return false;
                }
                else {
                    return true;
                }
            case "min3":
                // Minimale Anzahl der Zeichen
                $min = 3;
                $nrChars = strlen($cleanStr); // strlen() - Anzahl der Zeichen
                if ($nrChars < $min) {
					$this->addError($name, "Der eingegebene Begriff ist zu kurz.");
                    return false;
                }
                else {
                    return true;
                }
            case "str":
                return true;

        }
    }

	 // Methode zur Fehlerhinzufügung
	 function addError($name, $error): void {
        $this->hasErrors = true;
        if (!isset($this->errorsArr[$name])) {
            $this->errorsArr[$name] = [];
        }
        $this->errorsArr[$name][] = $error;
    }

    function validate($name, $duty, $kind, $str): string {
        $cleanStr = $this -> desinfect($str);

        $goOn = $this -> isRequired($name, $duty, $cleanStr);

        if ($goOn) {
            switch($kind) {
                case "validMail";
                    $this -> isEmailCorrect($name, $cleanStr);
                break;
                case "validPassword";
                    $this -> isPasswordCorrect($name, $cleanStr);
                break;
                case "validUsername";
                    $this -> isUsernameCorrect($name, $cleanStr);
                break;
				case "validString":;
                    $this -> isStringCorrect($name, $cleanStr);
                break;
				case "validText":;
                    $this -> isTextCorrect($name, $cleanStr);
                break;
            }
        }

        return $cleanStr;
    }

	// Überprüfen, ob die E-Mail Adresse korrekt ist
    function isEmailCorrect($name, $str): void {
		if (!filter_var($str, FILTER_VALIDATE_EMAIL)) { // FILTER_VALIDATE_EMAIL -  PHP-Filter
            $this->addError($name, "Die E-Mail-Adresse ist nicht gültig.");
		}
	}

	  // Prüfen, ob das Passwort gültig ist 
	  function isPasswordCorrect($name, $str): void {
		$suchmuster = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@%&*-]).\S{8,}$/';
		if (!preg_match($suchmuster, $str)) {
            $this->addError($name, "Passwort muss mind. 8 Zeichen lang sein und einen Großbuchstaben, ein Sonderzeichen und eine Zahl enthalten.");
		}
	}

	// Überprüfen, ob der Username den Vorgaben entspricht
    function isUsernameCorrect($name, $str): void {
		$min = 2;
        $max = 16;

        $pos = strrpos($str, " ");  // Hat es Leerschläge im Usernamen?
        if ($pos === false) {
            $nrChars = strlen($str);

		    if ($nrChars < $min) {
                $this->addError($name, "Das Feld muss mind. 2 Zeichen haben.");
            }
            if ($nrChars > $max) {
                $this->addError($name, "Das Feld darf nicht länger als 16 Zeichen sein.");
            }
        }
        else {
            $this->addError($name, "Der Benutzername darf keine Leerzeichen enthalten.");
		}
	}

	function isStringCorrect($name, $str): void {
		$min = 2;
        $max = 40;

        $nrChars = strlen($str);

		    if ($nrChars < $min) {
                $this->addError($name, "Das Feld muss mind. 2 Zeichen haben.");
            }
            if ($nrChars > $max) {
				$this->addError($name, "Das Feld darf nicht länger als 40 Zeichen sein.");
            } 
	}

	function isTextCorrect($name, $str): void {
		$min = 4;
        $max = 250;

        $nrChars = strlen($str);

		    if ($nrChars < $min) {
                $this->addError($name, "Das Feld muss mind. 4 Zeichen haben.");
            }
            if ($nrChars > $max) {
                $this->addError($name, "Das Feld darf nicht länger als 250 Zeichen sein.");
            } 
	}


}



?>
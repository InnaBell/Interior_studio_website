<?php

// Klasse zum Validieren von Bild-Uploads
class RawUpload {
	// Zielverzeichnis
	private $targetDir = "uploads";
	// Array für die Fehlermeldungen
	public $errorsArrUpload = [];
	// Array für erlaubte MIME-Types
	private $allowedMimeTypes = ["image/jpeg","image/png", "image/webp"];
	// Array für erlaubte Datei-Endungen
	private $allowedExtensions = ["png","PNG","jpg","JPG","jpeg","JPEG", "webp", "WEBP"];
	// max. erlaubte Dateigrösse
	public $maxFileSize = 2048000; // 2 MB
	// max. erlaubte Dimensionen des Bildes
	private $maxImgWidth = 1200;
	private $maxImgHeight = 1000;
	public $imagePath;
	
	// die Fehlermeldungen verarbeiten
	function checkFileError(): bool {
        $errorNo = $_FILES['image']['error'];
        switch ($errorNo) {
            case UPLOAD_ERR_OK:
                // Kein Fehler, die Datei wurde erfolgreich hochgeladen
                return true;
            case UPLOAD_ERR_INI_SIZE:
                $this->errorsArrUpload[] = "Die hochgeladene Datei überschreitet die festgelegte Größe.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $this->errorsArrUpload[] = "Die hochgeladene Datei überschreitet die maximale Dateigröße.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $this->errorsArrUpload[] = "Die Datei wurde nur teilweise hochgeladen.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $this->errorsArrUpload[] = "Es wurde keine Datei hochgeladen.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $this->errorsArrUpload[] = "Ein Fehler beim Hochladen der Datei.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $this->errorsArrUpload[] = "Speichern der Datei auf die Festplatte ist fehlgeschlagen.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $this->errorsArrUpload[] = "Ein Fehler beim Hochladen der Datei.";
                break;
            default:
                $this->errorsArrUpload[] = "Ein Fehler beim Hochladen der Datei.";
                break;
        }
        return false;
    }
	
	// weitere Checks mit dem File
	function checkFileInQuarantine(): bool {
		$hasErrors = false;

		// MIME-Type des Bildes, Dateigrösse, Datei-Endung prüfen
		$type = $_FILES['image']['type'];
		$size = $_FILES['image']['size'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)); // PATHINFO_EXTENSION - Datei-Endung

		if(!in_array($type, $this->allowedMimeTypes)) {
			// Datei hat ein ungültiges MIME-Type
			$hasErrors = true;
			$this -> errorsArrUpload[] = "Sie dürfen nur JPG-, WEBP- oder PNG-Bilder hochladen.";
		}

		if (!in_array($ext, $this->allowedExtensions)) {
            $hasErrors = true;
            $this->errorsArrUpload[] = "Die Datei-Endung muss .jpg, .webp oder .png sein.";
        }

        if ($size > $this->maxFileSize) {
            $hasErrors = true;
            $this->errorsArrUpload[] = "Die Datei muss kleiner als 2 MB sein.";
        }

		// Dimensionen eines Bildes bestimmen
		$sizeArr = getimagesize($_FILES['image']['tmp_name']);
		$width = $sizeArr[0];
		$height = $sizeArr[1];

		if($width > $this->maxImgWidth) {
			// Bild ist zu breit
			$hasErrors = true;
			$this -> errorsArrUpload[] = "Das Bild darf max. 1200 Pixel breit sein";
		}
		if($height > $this->maxImgHeight) {
			// Bild ist zu hoch
			$hasErrors = true;
			$this -> errorsArrUpload[] = "Das Bild darf max. 1000 Pixel hoch sein";
		}
			
		if ($hasErrors) {
			return false;
		}
		else {
			return true;
		}
	}
	
	// das File aus dem temp. Verzeichnis in das Upload-Verzeichnis verschieben
	function moveFile(): bool {

		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
			$tmp_name = $_FILES["image"]["tmp_name"];
        	$name = basename($_FILES["image"]["name"]); // basename() gegen Directory-Angriffe;
			$zeit = time();
			$name = $zeit."-".$name; // neue Dateiname erstellen (um Uberschreibungen zu vermeiden)
			$this->imagePath = $this->targetDir . "/" . $name;
        	move_uploaded_file($tmp_name, $this->targetDir."/".$name);
			return true;	
		}
		else {
   			$this->errorsArrUpload[] = "Das Bild konnte nicht gespeichert werden.";
			return false;
   		}	
	}
	
}

?>
# Eine Anwendung mit Integration eines Content Management Systems (CMS) für ID:Studio Webseite

- Projekt von Inna Belorustseva
- WDD323 - Modul 4FSC0WD004
- Abgabe: 24. Juni 2024

## Projektbeschreibung

Dieses Projekt erweitert ein bestehendes Web-Projekt und implementiert ein benutzerdefiniertes CMS. Diese Anwendung soll es Administratoren ermöglichen, Inhalte effizient zu verwalten, Benutzer zu administrieren und Kundenfeedback zu veröffentlichen. Kunden haben keinen Zugang zu einer Benutzerregistrierung, aber können über ein Kontaktformular auf der Webseite mit dem Unternehmen in Verbindung treten. Die Hauptfunktionalitäten umfassen Registrierung und -login, CRUD-Operationen für Inhalte, File-Uploads. Die Anwendung ist in PHP entwickelt und nutzt eine MySQL-Datenbank.

## Funktionen

1. Admin-Registrierung und -Login: Nur Admins können sich bei der Anwendung registrieren. Die Registrierung erfolgt über ein sicheres Formular, das nur für befugte Personen zugänglich ist. Admins können sich mit ihren Anmeldeinformationen einloggen und erhalten Zugang zu den Administrationsfunktionen der Anwendung.

2. Verwaltung von Kunden-Feedback: Admins können neues Kunden-Feedback inklusive Dateien erstellen, basierend auf der Kundenbewertung, welche sie per E-Mail erhalten haben, und dies direkt auf der Webseite veröffentlichen, um Kundenmeinungen sichtbar zu machen. Bestehendes Feedback kann geändert und angepasst sowie unnötiges oder veraltetes Feedback entfernt werden.

3. Kontaktformular für Kunden: Kunden können ein Formular auf der Webseite ausfüllen, um ihre Kontaktdaten und Nachrichten an das Unternehmen zu übermitteln. Die eingegebenen Informationen werden sicher in CMS gespeichert und können von Admins eingesehen und bearbeitet werden.

4. Benutzerverwaltung: Admins können neue Benutzer anlegen, bestehende Benutzerprofile ändern, einschließlich der Aktualisierung von Kontaktdaten, und Benutzer löschen, wenn diese nicht mehr benötigt werden.

## Anforderungen

- Webserver (z.B. MAMP, XAMPP).
- Ein Webbrowser wie Chrome, Firefox, Safari usw.

## Technische Details

- Die Hauptdatei ist ein Anmeldeformular für Admins "sign_in.php".

## Logindaten

Hier sind die Logindaten von Admin, um das CMS zu verwalten:

```
Benutzername: admin@admin.com
Passwort: Administrator1!
```

## Installation

### Installation eines lokalen Servers

1. Laden Sie XAMPP (für macOS, Windows, Linux) oder MAMP (für macOS) von der offiziellen Website herunter.
2. Installieren Sie die heruntergeladene Software gemäß den Anweisungen auf der Website.
3. Starten Sie den installierten Server.
4. Kopieren Sie die heruntergeladenen Dateien der Webanwendung in das Dokumentenverzeichnis des Servers (normalerweise "htdocs" für XAMPP oder "htdocs" für MAMP, stellen Sie sicher, dass sich die Datei `sign_in.php` und alle anderen Dateien direkt im Hauptverzeichnis befinden).
5. Öffnen Sie Ihren Webbrowser und gehen Sie zu `http://localhost:8888/sign_in.php` für MAMP oder `http://localhost/sign_in.php` für XAMPP.

## Datenbank einrichten in MAMP oder XAMPP

1. Starten Sie die Server-Anwendung.
2. Klicken Sie auf "Server starten" (MAMP) oder "Start" (XAMPP).
3. Öffnen Sie Ihren Webbrowser und gehen Sie zu `http://localhost:8888/phpMyAdmin5` (MAMP) oder `http://localhost/phpmyadmin5` (XAMPP).
4. Melden Sie sich bei "phpMyAdmin" an.
5. Klicken Sie oben auf die Registerkarte "Datenbanken".
6. Geben Sie den Namen der neuen Datenbank in das Feld "Datenbank erstellen" ein und klicken Sie auf "Erstellen".
7. Wählen Sie die erstellte Datenbank aus der Liste auf der linken Seite aus.
8. Klicken Sie oben auf die Registerkarte "Importieren".
9. Klicken Sie auf "Datei auswählen" und wählen Sie die `Id_Studio_DB.sql` (Ordner `db`) aus dem heruntergeladenen Ordner aus.
10. Klicken Sie auf "OK", um die Datenbank zu importieren.

### Informationen zur Datenbank

Die Datei zur Konfiguration der Datenbank für MAMP Server befindet sich hier: `config.php`. Momentane Einstellungen:

```
"DBSERVER", 'localhost';
"DBNAME", 'Id_Studio_DB';
"DBUSER", 'root';
"DBPASSWORT", 'root';
```

Bei XAMPP müssen Anpassungen vorgenommen werden ("DBPASSWORT", '';).

## Kontakt

Bei Fragen oder Problemen können Sie mich unter ibelorusceva@icloud.com erreichen.

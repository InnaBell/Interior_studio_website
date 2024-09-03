-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Erstellungszeit: 22. Jun 2024 um 20:35
-- Server-Version: 5.7.39
-- PHP-Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `Id_Studio_DB`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Administrators`
--

CREATE TABLE `Administrators` (
  `ID` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Administrators`
--

INSERT INTO `Administrators` (`ID`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(12, 'Inna', 'inna@inna.com', '$2y$10$GVe8Bal57t.1q69/IaksZupWYoss0ENXrvN/OMIiupT.6.tJ5OY2u', '2024-05-31 15:20:05', '2024-05-31 15:20:37'),
(67, 'Administrator', 'admin@admin.com', '$2y$10$M1RiQCWLQY/G/tzYCa5F2eMthLf9V9jfrPqwtcclxr043nO4XSDS6', '2024-06-12 13:01:55', '2024-06-12 13:01:55');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Posts`
--

CREATE TABLE `Posts` (
  `ID` bigint(24) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `category_id` bigint(24) UNSIGNED DEFAULT NULL,
  `text` text,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Posts`
--

INSERT INTO `Posts` (`ID`, `title`, `author`, `category_id`, `text`, `image`, `created_at`, `updated_at`) VALUES
(17, 'Perfekte Umsetzung meiner Vision', 'Leon Johnson', 1, 'Absolut begeistert von der Kreativität und Präzision! Das Team meines Innerarchitekturbüros hat unsere Vision perfekt umgesetzt. Einzigartiges Design, großartige Zusammenarbeit!', 'uploads/1718978591-client_01.jpg', '2024-06-08 14:32:33', '2024-06-08 14:32:33'),
(18, 'Farbpalette und Design begeistern', 'Emilia Schmidt', 2, 'Hervorragende Dienstleistungen! Das Innerarchitekturbüro zeichnet sich durch Fachkenntnisse, Pünktlichkeit und innovative Ideen aus. Unsere Räume wurden zu echten Kunstwerken transformiert. Sehr zu empfehlen!', 'uploads/1717859095-client_02.jpg', '2024-06-08 15:04:55', '2024-06-08 15:04:55'),
(19, 'Professionell, kreativ, zuvorkommend', 'Maya Patel', 1, 'Mein Innerarchitekturbüro des Vertrauens! Professionell, freundlich und stets auf höchstem Niveau. Die maßgeschneiderten Lösungen haben unsere Erwartungen übertroffen. Ein echter Gewinn für jeden, der Qualität schätzt.', 'uploads/1717859346-client_03.jpg', '2024-06-08 15:09:06', '2024-06-08 15:09:06'),
(20, 'Beeindruckende Arbeit', 'Anna Chang', 2, 'Einzigartige Ästhetik und Funktionalität! Das Innerarchitekturbüro hat unser Zuhause in einen stilvollen Rückzugsort verwandelt. Beeindruckende Designs und sorgfältige Umsetzung. Wir sind mehr als zufrieden!', 'uploads/1717859557-client_04.jpg', '2024-06-08 15:12:37', '2024-06-08 15:12:37'),
(21, 'Verwandlung unseres Hauses', 'Isabella Ramirez', 1, 'Exzellenter Kundenservice! Von der Planung bis zur Umsetzung hat das Innerarchitekturbüro ein herausragendes Maß an Professionalität gezeigt. Die Ergebnisse sprechen für sich – unsere Erwartungen wurden übertroffen. Danke!', 'uploads/1717859852-client_05.jpg', '2024-06-08 15:17:32', '2024-06-08 15:17:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Posts_category`
--

CREATE TABLE `Posts_category` (
  `ID` bigint(24) UNSIGNED NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Posts_category`
--

INSERT INTO `Posts_category` (`ID`, `label`, `created_at`, `updated_at`) VALUES
(1, '#commercial', '2024-05-31 15:45:24', '2024-05-31 15:45:24'),
(2, '#privateswohnen', '2024-05-31 15:45:24', '2024-05-31 15:45:24'),
(3, '#ferienimmobilien', '2024-05-31 15:46:00', '2024-05-31 15:46:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `Users`
--

CREATE TABLE `Users` (
  `ID` bigint(24) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `Users`
--

INSERT INTO `Users` (`ID`, `title`, `first_name`, `last_name`, `city`, `street`, `postcode`, `email`, `message`, `created_at`, `updated_at`) VALUES
(9, '2', 'Alexandra', 'Fuchs', 'Bern', 'Bernerstrasse 34', '3456', 'alexandra@email.com', 'Kontaktieren Sie mich, bitte!', '2024-06-14 13:35:21', '2024-06-14 13:35:21'),
(15, '1', 'Peter', 'Fox', 'Stans', 'Stansstrasse 34', '1000', 'Peter@fox.com', NULL, '2024-06-14 21:34:48', '2024-06-14 21:34:48'),
(23, '2', 'Stefanie', 'Schneider', 'Lausanne', '', '1006', 'stefanie.schneider@example.com', NULL, '2024-06-15 12:05:57', '2024-06-15 12:05:57'),
(24, '1', 'Thomas', 'Hug', 'St. Gallen', 'Multergasse 3', '5656', 'thomas.hug@example.com', NULL, '2024-06-15 12:06:49', '2024-06-15 12:06:49'),
(69, '2', 'Inna', 'Belorustseva', 'Horw', 'Sternenriedlatz 1', '6048', 'ibelorusceva@icloud.com', 'Interessiere mich für eine Wohnzimmer-Renovierung.', '2024-06-17 17:18:12', '2024-06-17 17:18:12'),
(70, '1', 'Michael', ' Baumann', 'Biel', '', '2502', 'michael.baumann@example.com', 'Brauche Unterstützung bei der Gestaltung meines Büros.', '2024-06-17 17:27:52', '2024-06-17 17:27:52'),
(71, '2', 'Claudia', 'Zimmermann', 'Lugano', 'Via Nassa 12', '6090', 'claudia.zimmermann@example.com', '', '2024-06-17 17:58:26', '2024-06-17 17:58:26'),
(73, '2', 'Alexandra', 'Fuchs', 'St. Gallen', 'Multergasse 3', '5554', 'alexandra@fuchs.com', NULL, '2024-06-21 16:44:54', '2024-06-21 16:44:54'),
(76, '2', 'Stefanie', 'Schneider', 'Lausanne', 'Multergasse 3', '5700', 'stefanie@schneider.com', 'Brauche Unterstützung bei der Gestaltung meines Büros. Dankeschön.', '2024-06-21 16:58:51', '2024-06-21 16:58:51');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `Administrators`
--
ALTER TABLE `Administrators`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `category_id` (`category_id`);

--
-- Indizes für die Tabelle `Posts_category`
--
ALTER TABLE `Posts_category`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `Administrators`
--
ALTER TABLE `Administrators`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT für Tabelle `Posts`
--
ALTER TABLE `Posts`
  MODIFY `ID` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `Posts_category`
--
ALTER TABLE `Posts_category`
  MODIFY `ID` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` bigint(24) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Posts_category` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

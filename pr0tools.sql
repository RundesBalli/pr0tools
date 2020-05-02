-- Adminer 4.7.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

USE `pr0tools`;

DELIMITER ;;

DROP EVENT IF EXISTS `Automatisches Löschen der Favoriten`;;
CREATE EVENT `Automatisches Löschen der Favoriten` ON SCHEDULE EVERY 1 HOUR STARTS '2019-09-14 09:21:51' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Löscht Favoriten, die 20 Wochen nicht genutzt wurden.' DO DELETE FROM `fav` WHERE `lastused` < DATE_SUB(NOW(), INTERVAL 20 WEEK);;

DROP EVENT IF EXISTS `Automatisches Löschen leerer Favoriteneinträge.`;;
CREATE EVENT `Automatisches Löschen leerer Favoriteneinträge.` ON SCHEDULE EVERY 10 MINUTE STARTS '2019-09-14 15:48:27' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Löscht Favoriteneinträge, die angelegt aber nie befüllt wurden.' DO DELETE FROM `fav` WHERE `lastused` < DATE_SUB(NOW(), INTERVAL 1 HOUR) AND NOT EXISTS (SELECT * FROM `fav_items` WHERE `fav_items`.`key` = `fav`.`key`);;

DELIMITER ;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Angezeigter Name',
  `shortTitle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kurzer Name für die URL',
  `sortIndex` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sortierindex',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Beschreibung der Kategorie',
  `shortDescription` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Kurze Beschreibung der Kategorie',
  UNIQUE KEY `shortTitle` (`shortTitle`),
  KEY `sortindex` (`sortIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Kategorientabelle';

TRUNCATE `categories`;
INSERT INTO `categories` (`title`, `shortTitle`, `sortIndex`, `description`, `shortDescription`) VALUES
('Communityprojekte',	'community',	30,	'In dieser Kategorie findest du Projekte von Nutzern für Nutzer. ',	'Projekte von und für Nutzer'),
('Posterstellung',	'creation',	10,	'In dieser Kategorie findest du nützliche Tools zum Thema Posterstellung.\r\n\r\nDamit kannst du zum Beispiel deine eigenen Textposts erstellen und mit Bildern versehen. OC-Offensive!',	'Nie wieder mit Photoshop herumquälen'),
('Spiele',	'games',	60,	'Spiele die etwas mit dem pr0 zu tun haben.',	'Spiele die etwas mit dem pr0 zu tun haben.'),
('Gut zu wissen',	'nice-to-know',	50,	'Hier werden Links zu Posts, Kommentaren und Seiten mit besonderem Wert gesammelt.',	'Links zu Posts und Kommentaren mit besonderem Wert'),
('Statistiken',	'stats',	40,	'In dieser Kategorie findest du interessante Statistiken und Aufstellungen, alles was die API hergibt.',	'Alles was die API hergibt!'),
('Hochladen',	'upload',	20,	'In dieser Kategorie findest du nützliche Tools zum Thema Hochladen.\r\n\r\nFinde Reposts oder wandel deine Videos in das richtige Format um!',	'Reposts finden, Videos konvertieren...');

DROP TABLE IF EXISTS `category_items`;
CREATE TABLE `category_items` (
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kategorie',
  `item` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Eintrag',
  `sortIndex` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sortierindex',
  UNIQUE KEY `category_item` (`category`,`item`),
  KEY `category` (`category`),
  KEY `item` (`item`),
  KEY `sortindex` (`sortIndex`),
  CONSTRAINT `category_items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`shortTitle`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `category_items_ibfk_2` FOREIGN KEY (`item`) REFERENCES `items` (`shortTitle`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Querverweistabelle';

TRUNCATE `category_items`;
INSERT INTO `category_items` (`category`, `item`, `sortIndex`) VALUES
('nice-to-know',	'apidoc',	0),
('nice-to-know',	'app',	0),
('nice-to-know',	'badewanne',	0),
('nice-to-know',	'badewanne-1-1',	0),
('nice-to-know',	'badges',	0),
('nice-to-know',	'bwcalc',	0),
('nice-to-know',	'discord',	0),
('nice-to-know',	'eckdaten',	0),
('nice-to-know',	'pr0wiki',	0),
('nice-to-know',	'rueckwaertssuche',	0),
('nice-to-know',	'sch0ngesehen',	0),
('nice-to-know',	'screenshots',	0),
('nice-to-know',	'suche',	0),
('nice-to-know',	'tierduden',	0),
('nice-to-know',	'tts',	0),
('nice-to-know',	'userscripts',	0),
('community',	'app',	10),
('creation',	'pr0texter',	10),
('games',	'z0cken',	10),
('stats',	'w0chenstatistik',	10),
('upload',	'pr0verter',	10),
('community',	'pr0mart',	12),
('community',	'z0cken',	15),
('community',	'userscripts',	20),
('creation',	'eckdaten',	20),
('games',	'flatterfogel',	20),
('stats',	'pr0p0ll',	20),
('upload',	'rep0st',	20),
('stats',	'apidoc',	25),
('community',	'pr0p0ll',	30),
('creation',	'thumbnails',	30),
('games',	'pr0ball-2_0',	30),
('stats',	'pr0kular',	30),
('upload',	'pr0verter-offline',	30),
('creation',	'memetemplates',	35),
('community',	'pr0keys',	40),
('creation',	'pr0p0st',	40),
('games',	'pr0rona',	40),
('stats',	'pr0stats',	40),
('community',	'pr0wiki',	50),
('creation',	'pr0p0ll-viewer',	50),
('games',	'pr0fense',	50),
('community',	'fap0gramm',	60),
('creation',	'tts',	60),
('games',	'guess-the-tag',	60),
('creation',	'scribus',	70);

DROP TABLE IF EXISTS `fav`;
CREATE TABLE `fav` (
  `key` varchar(32) NOT NULL COMMENT 'Schlüssel zum Anzeigen',
  `lastused` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Zuletzt genutzt am',
  UNIQUE KEY `key` (`key`),
  KEY `lastused` (`lastused`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Favoritentabelle';


DROP TABLE IF EXISTS `fav_items`;
CREATE TABLE `fav_items` (
  `key` varchar(32) NOT NULL COMMENT 'Favoriteneintrag',
  `item` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Itemeintrag',
  `sortindex` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sortierindex',
  UNIQUE KEY `key_shortTitle` (`key`,`item`),
  KEY `shortTitle` (`item`),
  KEY `key` (`key`),
  CONSTRAINT `fav_items_ibfk_1` FOREIGN KEY (`item`) REFERENCES `items` (`shortTitle`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fav_items_ibfk_2` FOREIGN KEY (`key`) REFERENCES `fav` (`key`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Favoriten-Querverweistabelle';


DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Angezeigter Name',
  `shortTitle` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Kurzer Name für die URL',
  `description` text COLLATE utf8mb4_unicode_ci COMMENT 'Lange Beschreibung für die Anzeige des Eintrags',
  `author` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Username des Erstellers',
  `thumb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Dateiname des Screenshots',
  `url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'URL zum Projekt',
  UNIQUE KEY `shortTitle` (`shortTitle`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Eintragstabelle';

TRUNCATE `items`;
INSERT INTO `items` (`title`, `shortTitle`, `description`, `author`, `thumb`, `url`) VALUES
('API Dokumentation',	'apidoc',	'Inoffizielle Dokumentation für die pr0gramm API',	'5yn74x',	'apidoc.png',	'https://pr0gramm.com/new/3273699'),
('pr0gramm Android App',	'app',	'Die offizielle pr0gramm Android App.',	'Mopsalarm',	'app.png',	'https://app.pr0gramm.com/'),
('pr0-Norm #1 - Die Badewanne',	'badewanne',	'Die allseits beliebte Badewanne genormt.',	'J0unz',	'badewanne.png',	'https://pr0gramm.com/new/1350989'),
('pr0-Norm #1.1 - Aktualisierung',	'badewanne-1-1',	'Eine Aktualisierung der Badenwannennorm.',	'DerAckrige',	'badewanne_1-1.png',	'https://pr0gramm.com/new/2029841'),
('Badgeübersicht',	'badges',	'Eine Übersicht aller Badges auf pr0gramm.\r\nStand: April 2019',	't0b3',	'badges.png',	'https://pr0gramm.com/new/3125123'),
('BadewannenCalculator',	'bwcalc',	'Der praktische Rechner zum Umrechnen gemäß pr0-Norm 1.',	'ufop',	'badewannencalculator.png',	'http://badewannencalculator.de/'),
('Discord',	'discord',	'Der offizielle pr0gramm-Discordserver',	'pr0gramm',	'discord.png',	'https://discord.gg/pr0'),
('Eckdaten',	'eckdaten',	'Eckdaten für Textposts',	'holzmaster',	'eckdaten.png',	'https://holzmaster.github.io/userscripts/eckdaten/'),
('fap0gramm',	'fap0gramm',	'fap0gramm ist ein nsfw-viewer für das pr0gramm',	'VladimirObama',	'fap0gramm.png',	'https://fap0gramm.com/'),
('Flatterfogel',	'flatterfogel',	'Ein Flappybird-Klon als pr0-Version',	'C0dingschmuser',	'flatterfogel.png',	'https://pr0gramm.com/new/2230627'),
('GuessTheTag',	'guess-the-tag',	'GuessTheTag ist ein Tagratespiel, bei dem man von einem Post den korrekten Tag erraten muss.',	'C0dingschmuser',	'guess-the-tag.png',	'https://pr0gramm.com/new/3126416'),
('Memetemplates in HD',	'memetemplates',	'Hier gibt es zahlreiche Memetemplates in bester Bildqualität.',	'Meistergeck0',	'memetemplates.png',	'https://pr0gramm.com/new/3294493'),
('pr0ball 2.0',	'pr0ball-2_0',	'Der Nachfolger von pr0ball - Sammelt Blussis, verzockt sie im Benitrat0r, verbessert eure Bälle und benutzt Skills um eure Gegner umzunieten.',	'Mopsi91',	'pr0ball-2_0.png',	'https://pr0gramm.com/new/3757480'),
('Pr0fense',	'pr0fense',	'pr0fense ist ein Tower-Defense Spiel im pr0gramm-Stil.',	'C0dingschmuser',	'pr0fense.png',	'https://pr0gramm.com/new/2561200'),
('pr0keys',	'pr0keys',	'Schließe dich der Community an und bereite anderen pr0grammern eine Freude! Auf pr0keys werden Steam-Keys für Spiele und andere Apps, die nicht mehr benötigt werden, geteilt. Meist stammen diese Keys aus Random-Key Paketen oder aus Humble Bundle-Bundles. Anstatt diese Keys einfach liegen zu lassen, kannst du sie hier mit anderen pr0grammern teilen.\r\n<span class=\"italic\">(Quelle: die Seite selbst)</span>',	'blussischmuser',	'pr0keys.png',	'https://pr0keys.com/'),
('pr0kular',	'pr0kular',	'Topliste aller Posts mit verschiedenen Suchmöglichkeiten.',	'pr0stats',	'pr0kular.png',	'https://pr0kular.herokuapp.com'),
('pr0mart',	'pr0mart',	'Der offizielle pr0gramm Merchandise Shop!',	'pr0mart',	'pr0mart.png',	'https://pr0mart.com'),
('pr0p0ll',	'pr0p0ll',	'pr0p0ll ist eine Umfragenplattform nur für pr0grammer. Erstell deine eigenen Umfragen und befrag die Community!',	'RundesBalli',	'pr0p0ll.png',	'https://pr0p0ll.com/'),
('pr0p0ll-viewer',	'pr0p0ll-viewer',	'Der pr0p0ll-viewer ist ein Tool um die Ergebnisse einer pr0p0ll-Umfrage in einen Post mit Diagrammen umzuwandeln.',	'PoTTii',	'pr0p0ll-viewer.png',	'https://scarwolf.github.io/pr0p0ll-viewer/'),
('pr0p0st',	'pr0p0st',	'Tool zum einfachen Erstellen von OC.',	'retro',	'pr0p0st.png',	'https://retropr0.github.io/pr0p0st/html/'),
('pr0rona',	'pr0rona',	'Ein Spiel zum pr0rona Ausbruch 2020. Weiche geschickt den Viren aus, trinke Bier und erreiche deinen Hochwert. Spielbar unter Python oder per Win. Installation; Code frei verfügbar.',	'pr0nihilo',	'pr0rona.png',	'https://pr0gramm.com/new/3839649'),
('pr0stats (veraltet)',	'pr0stats',	'Alte Statistiken über das pr0gramm.',	'pr0stats',	'pr0stats.png',	'https://pr0stats.github.io/'),
('pr0texter',	'pr0texter',	'Tool zum einfachen Erstellen von OC.',	'ZungeWegIchFurz',	'pr0texter.png',	'http://pr0texter.com/'),
('pr0verter',	'pr0verter',	'Mit dem pr0verter kannst du deine Videos direkt in das webm Format konvertieren.',	'Insax',	'pr0verter.png',	'https://pr0verter.de/'),
('pr0verter Offline',	'pr0verter-offline',	'Der pr0verter als Offline-Version.',	'Pennypacker',	'pr0verter_offline.png',	'https://pr0gramm.com/new/3322321'),
('pr0wiki',	'pr0wiki',	'Das pr0wiki ist eine Zusammenfassung von nützlichem Wissen über das pr0gramm. Es wird stetig erweitert.',	'MedPlex',	'pr0wiki.png',	'https://pr0wiki.com/'),
('rep0st',	'rep0st',	'rep0st minimiert das Risiko von Benisverkürzungen durch Reposts. Mithilfe unserer Skalarwellentechnologie wurden alle Bilder, die je auf dem pr0gramm gepostet wurden, auf dem im pr0gramm Hauptquartier befindlichen SNASA Cluster aufbereitet und indiziert. Mithilfe von reichlich Magie wird dann dein Bild mit der Datenbank verglichen. Angezeigt werden dann Bilder, die deinem Bild ähnlich sind! (Kann p0rn und g0re enthalten!)\r\n<span class=\"italic\">(Quelle: die Seite selbst)</span>',	'Rene8888',	'rep0st.png',	'https://rep0st.rene8888.at/'),
('Rückwärtssuche',	'rueckwaertssuche',	'Der Infopost zur Rückwärtssuche auf pr0gramm.\r\nDie Rückwärtssuche kann genutzt werden um den zugehörigen Upload zu einem Direktlink herauszufinden.',	'pr0gramm',	'rueckwaertssuche.png',	'https://pr0gramm.com/new/3323910'),
('sch0ngesehen',	'sch0ngesehen',	'Ein Browseraddon um anzuzeigen, welche Posts man bereits gesehen hat.',	'Mwni',	'sch0ngesehen',	'https://pr0gramm.com/new/3568968'),
('große, lange Screenshots',	'screenshots',	'Tutorial um große, lange Screenshots zu erstellen.',	'Donnerstaender',	'screenshots.png',	'https://pr0gramm.com/new/1579819'),
('Scribus Tutorial',	'scribus',	'Anleitung zum Erstellen von Posts mittels Scribus.',	'Retrowinger',	'scribus.png',	'https://pr0gramm.com/new/3156775'),
('erweiterte Suche',	'suche',	'Die erweiterte pr0gramm-Suche.',	'pr0gramm',	'suche.png',	'https://pr0gramm.com/new/2782197'),
('Thumbnail mit Rahmen',	'thumbnails',	'Anleitung für schöne Vorschaubildchen mit Rahmen.',	'Retrowinger',	'thumbnails.png',	'https://pr0gramm.com/new/3295515'),
('Tierduden v4',	'tierduden',	'Der pr0gramm Tierduden ist eine Aufstellung aller Kadsen, Kefer und .EXEn',	'Unbefriedigend',	'tierduden.png',	'https://pr0gramm.com/new/1755191'),
('text2speech Tutorial',	'tts',	'Text2Speech / Computerstimme für OC-Videos',	'qbl',	'tts.png',	'https://pr0gramm.com/new/1947058'),
('Userscripts',	'userscripts',	'Was es gibt, was gewollt wird.\r\n\r\nDie Userscripts, Plugins, Userstyles und Tools werden alle von unterschiedlichen Entwicklern gewartet und weiterentwickelt.\r\n<span class=\"italic\">(Quelle: die Seite selbst)</span>',	'holzmaster',	'userscripts.png',	'https://holzmaster.github.io/userscripts/'),
('w0chenstatistik',	'w0chenstatistik',	'Die Wochenstatistik. Immer Montags um 21:00 Uhr.',	'DerpyDerp',	'w0chenstatistik.png',	'https://pr0gramm.com/user/DerpyDerp/uploads/w0chenstatistik'),
('z0cken.com',	'z0cken',	'Hinter z0cken.com steckt ein Projekt von der pr0gramm.com Community für die pr0gramm Community.\r\nDas z0cken Team übernimmt die infrastrukturelle Verwaltung der Server, welche vom jeweiligen Serverteam konfiguriert und geleitet werden.',	'z0cken',	'z0cken.png',	'https://z0cken.com/');

-- 2020-05-02 09:09:03

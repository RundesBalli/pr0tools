-- Adminer 4.8.1 MySQL 5.5.5-10.1.48-MariaDB-0+deb9u2 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `pr0tools`;
CREATE DATABASE `pr0tools` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `pr0tools`;

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
('nice-to-know',	'1-typ-stickerpack',	0),
('nice-to-know',	'app',	0),
('nice-to-know',	'badewanne',	0),
('nice-to-know',	'badewanne-1-2',	0),
('nice-to-know',	'badges',	0),
('nice-to-know',	'bwcalc',	0),
('nice-to-know',	'discord',	0),
('nice-to-know',	'eckdaten',	0),
('nice-to-know',	'fitImages',	0),
('nice-to-know',	'gangsign',	0),
('nice-to-know',	'pr0wiki',	0),
('nice-to-know',	'rueckwaertssuche',	0),
('nice-to-know',	'sch0ngesehen',	0),
('nice-to-know',	'screenshots',	0),
('nice-to-know',	'suche',	0),
('nice-to-know',	'themes',	0),
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
('games',	'pr0game',	15),
('community',	'userscripts',	20),
('creation',	'eckdaten',	20),
('games',	'flatterfogel',	20),
('stats',	'pr0p0ll',	20),
('upload',	'rep0st',	20),
('community',	'p0weruser',	25),
('community',	'pr0p0ll',	30),
('creation',	'thumbnails',	30),
('games',	'pr0ball-2_0',	30),
('upload',	'pr0verter-offline',	30),
('creation',	'gangsign',	32),
('community',	'kellertreff',	35),
('community',	'pr0keys',	40),
('creation',	'pr0p0st',	40),
('games',	'pr0rona',	40),
('stats',	'pr0stats',	40),
('community',	'1-typ-stickerpack',	45),
('community',	'pr0wiki',	50),
('creation',	'pr0p0ll-viewer',	50),
('games',	'pr0fense',	50),
('creation',	'tts',	60),
('games',	'guess-the-tag',	60),
('creation',	'scribus',	70);

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
('1-Typ Stickerpack',	'1-typ-stickerpack',	'Die beliebten 1Typ Bilder als Stickerpack für Telegram, WhatsApp & Signal. (Siehe Kommentarbaum)',	'Fehlgeburt',	'1typ.png',	'https://pr0gramm.com/new/4372488:comment45601148'),
('pr0gramm Android App',	'app',	'Die offizielle pr0gramm Android App.',	'Mopsalarm',	'app.png',	'https://app.pr0gramm.com/'),
('pr0-Norm #1 - Die Badewanne',	'badewanne',	'Die allseits beliebte Badewanne genormt.',	'J0unz',	'badewanne.png',	'https://pr0gramm.com/new/1350989'),
('pr0-Norm #1.2 - Aktualisierung',	'badewanne-1-2',	'Eine erneute Aktualisierung der Badenwannennorm.',	'DerAckrige',	'badewanne_1-2.png',	'https://pr0gramm.com/new/4239894'),
('Badges',	'badges',	'Übersicht aller Badges auf pr0gramm.',	'Blood32',	'pr0badges.png',	'https://pr0badges.github.io/'),
('BadewannenCalculator',	'bwcalc',	'Der praktische Rechner zum Umrechnen gemäß pr0-Norm 1.',	'ufop',	'badewannencalculator.png',	'http://badewannencalculator.de/'),
('Discord',	'discord',	'Der offizielle pr0gramm-Discordserver',	'pr0gramm',	'discord.png',	'https://discord.gg/pr0'),
('Eckdaten',	'eckdaten',	'Eckdaten für Textposts',	'holzmaster',	'eckdaten.png',	'https://holzmaster.github.io/userscripts/eckdaten/'),
('Bilder Scaling Userscript',	'fitImages',	'Passt auf Tastendruck die Höhe des angezeigten Bildes an und macht es so möglich erwas höhere Bilder auf kleineren Monitoren zu anzuschauen ohne zu scrollen.',	'openssl',	'fitImages.png',	'https://pr0gramm.com/new/3145896'),
('Flatterfogel',	'flatterfogel',	'Ein Flappybird-Klon als pr0-Version',	'C0dingschmuser',	'flatterfogel.png',	'https://pr0gramm.com/new/2230627'),
('Gangsign 2.0',	'gangsign',	'Das pr0-Gangsign wie es sein sollte.',	'l00tSpastille',	'gangsign.png',	'https://pr0gramm.com/new/1500962'),
('GuessTheTag',	'guess-the-tag',	'GuessTheTag ist ein Tagratespiel, bei dem man von einem Post den korrekten Tag erraten muss.',	'C0dingschmuser',	'guess-the-tag.png',	'https://pr0gramm.com/new/3126416'),
('Kellertreff',	'kellertreff',	'Du suchst einen anderen Menschen? Zum Zocken, Unterhalten, für ein Projekt oder ein Treffen? Dann bist du beim Kellertreff genau richtig!',	'holzmaster',	'kellertreff.png',	'https://kellertreff.com/'),
('p0weruser Userscript',	'p0weruser',	'Root-Zugriff auf das pr0gramm! WideScreen Modus, Notification Center, eingefärbte Kommentar-Ebenen, uvm.',	'PoTTii',	'p0weruser.png',	'https://scarwolf.github.io/p0weruser/p0weruser.user.js'),
('pr0ball 2.0',	'pr0ball-2_0',	'Der Nachfolger von pr0ball - Sammelt Blussis, verzockt sie im Benitrat0r, verbessert eure Bälle und benutzt Skills um eure Gegner umzunieten.',	'Mopsi91',	'pr0ball-2_0.png',	'https://pr0gramm.com/new/3877042'),
('Pr0fense',	'pr0fense',	'pr0fense ist ein Tower-Defense Spiel im pr0gramm-Stil.',	'C0dingschmuser',	'pr0fense.png',	'https://pr0gramm.com/new/2561200'),
('pr0game',	'pr0game',	'Bei pr0game handelt es sich um einen \"OGame\" Klon, der komplett auf bekannte Premiumfunktionen verzichtet um das klassische Spielgefühl von damals wiederzugeben.',	'Rosenreeman',	'pr0game.png',	'https://pr0game.com/'),
('pr0keys',	'pr0keys',	'Schließe dich der Community an und bereite anderen pr0grammern eine Freude! Auf pr0keys werden Steam-Keys für Spiele und andere Apps, die nicht mehr benötigt werden, geteilt. Meist stammen diese Keys aus Random-Key Paketen oder aus Humble Bundle-Bundles. Anstatt diese Keys einfach liegen zu lassen, kannst du sie hier mit anderen pr0grammern teilen.\r\n<span class=\"italic\">(Quelle: die Seite selbst)</span>',	'blussischmuser',	'pr0keys.png',	'https://pr0keys.com/'),
('pr0mart',	'pr0mart',	'Der offizielle pr0gramm Merchandise Shop!',	'pr0mart',	'pr0mart.png',	'https://pr0mart.com'),
('pr0p0ll',	'pr0p0ll',	'pr0p0ll ist eine Umfragenplattform nur für pr0grammer. Erstell deine eigenen Umfragen und befrag die Community!',	'RundesBalli',	'pr0p0ll.png',	'https://pr0p0ll.com/'),
('pr0p0ll-viewer',	'pr0p0ll-viewer',	'Der pr0p0ll-viewer ist ein Tool um die Ergebnisse einer pr0p0ll-Umfrage in einen Post mit Diagrammen umzuwandeln.',	'PoTTii',	'pr0p0ll-viewer.png',	'https://scarwolf.github.io/pr0p0ll-viewer/'),
('pr0p0st',	'pr0p0st',	'Tool zum einfachen Erstellen von OC.',	'retro',	'pr0p0st.png',	'https://retropr0.github.io/pr0p0st/html/'),
('pr0rona',	'pr0rona',	'Ein Spiel zum pr0rona Ausbruch 2020. Weiche geschickt den Viren aus, trinke Bier und erreiche deinen Hochwert. Spielbar unter Python oder per Win. Installation; Code frei verfügbar.',	'pr0nihilo',	'pr0rona.png',	'https://pr0gramm.com/new/3839649'),
('pr0stats (veraltet)',	'pr0stats',	'Alte Statistiken über das pr0gramm.',	'pr0stats',	'pr0stats.png',	'https://pr0stats.github.io/'),
('pr0texter',	'pr0texter',	'Tool zum einfachen Erstellen von OC.',	'ZungeWegIchFurz',	'pr0texter.png',	'http://pr0texter.com/'),
('pr0verter',	'pr0verter',	'Mit dem pr0verter kannst du deine Videos direkt in das webm Format konvertieren.',	'Insax',	'pr0verter.png',	'https://dev.pr0verter.de/'),
('pr0verter Offline',	'pr0verter-offline',	'Der pr0verter als Offline-Version.',	'Pennypacker',	'pr0verter_offline.png',	'https://pr0gramm.com/new/3322321'),
('pr0wiki',	'pr0wiki',	'Das pr0wiki ist eine Zusammenfassung von nützlichem Wissen über das pr0gramm. Es wird stetig erweitert.',	'MedPlex',	'pr0wiki.png',	'https://pr0wiki.com/'),
('rep0st',	'rep0st',	'rep0st minimiert das Risiko von Benisverkürzungen durch Reposts. Mithilfe unserer Skalarwellentechnologie wurden alle Bilder, die je auf dem pr0gramm gepostet wurden, auf dem im pr0gramm Hauptquartier befindlichen SNASA Cluster aufbereitet und indiziert. Mithilfe von reichlich Magie wird dann dein Bild mit der Datenbank verglichen. Angezeigt werden dann Bilder, die deinem Bild ähnlich sind! (Kann p0rn und g0re enthalten!)\r\n<span class=\"italic\">(Quelle: die Seite selbst)</span>',	'Rene8888',	'rep0st.png',	'https://rep0st.rene8888.at/'),
('Rückwärtssuche',	'rueckwaertssuche',	'Der Infopost zur Rückwärtssuche auf pr0gramm.\r\nDie Rückwärtssuche kann genutzt werden um den zugehörigen Upload zu einem Direktlink herauszufinden.',	'pr0gramm',	'rueckwaertssuche.png',	'https://pr0gramm.com/new/3323910'),
('sch0ngesehen',	'sch0ngesehen',	'Ein Browseraddon um anzuzeigen, welche Posts man bereits gesehen hat.',	'Mwni',	'sch0ngesehen.png',	'https://pr0gramm.com/new/3568968'),
('große, lange Screenshots',	'screenshots',	'Tutorial um große, lange Screenshots zu erstellen.',	'Donnerstaender',	'screenshots.png',	'https://pr0gramm.com/new/1579819'),
('Scribus Tutorial',	'scribus',	'Anleitung zum Erstellen von Posts mittels Scribus.',	'Retrowinger',	'scribus.png',	'https://pr0gramm.com/new/3156775'),
('erweiterte Suche',	'suche',	'Die erweiterte pr0gramm-Suche.',	'pr0gramm',	'suche.png',	'https://pr0gramm.com/new/2782197'),
('Themes für Firefox',	'themes',	'Firefox Themes in den bewährten pr0gramm Farben.',	'J4it',	'themes.png',	'https://addons.mozilla.org/de/firefox/collections/17356040/pr0-Themes/'),
('Thumbnail mit Rahmen',	'thumbnails',	'Anleitung für schöne Vorschaubildchen mit Rahmen.',	'Retrowinger',	'thumbnails.png',	'https://pr0gramm.com/new/3295515'),
('Tierduden v4',	'tierduden',	'Der pr0gramm Tierduden ist eine Aufstellung aller Kadsen, Kefer und .EXEn',	'Unbefriedigend',	'tierduden.png',	'https://pr0gramm.com/new/1755191'),
('text2speech Tutorial',	'tts',	'Text2Speech / Computerstimme für OC-Videos',	'qbl',	'tts.png',	'https://pr0gramm.com/new/1947058'),
('Userscripts',	'userscripts',	'Was es gibt, was gewollt wird.\r\n\r\nDie Userscripts, Plugins, Userstyles und Tools werden alle von unterschiedlichen Entwicklern gewartet und weiterentwickelt.\r\n<span class=\"italic\">(Quelle: die Seite selbst)</span>',	'holzmaster',	'userscripts.png',	'https://holzmaster.github.io/userscripts/'),
('w0chenstatistik',	'w0chenstatistik',	'Die Wochenstatistik. Immer Montags um 21:00 Uhr.',	'DerpyDerp',	'w0chenstatistik.png',	'https://pr0gramm.com/user/DerpyDerp/uploads/w0chenstatistik'),
('z0cken.com',	'z0cken',	'Hinter z0cken.com steckt ein Projekt von der pr0gramm.com Community für die pr0gramm Community.\r\nDas z0cken Team übernimmt die infrastrukturelle Verwaltung der Server, welche vom jeweiligen Serverteam konfiguriert und geleitet werden.',	'z0cken',	'z0cken.png',	'https://z0cken.com/');

-- 2022-06-11 23:32:22

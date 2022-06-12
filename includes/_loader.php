<?php
/**
 * _loader.php
 * 
 * Konfigurations- und Funktionsloader
 */

/**
 * Grundlegende Webseitenkonfiguration
 */
require_once(__DIR__.DIRECTORY_SEPARATOR."_config.php");
require_once(__DIR__.DIRECTORY_SEPARATOR."constants.php");

/**
 * Datenbank und Datenbankfunktionen
 */
require_once(__DIR__.DIRECTORY_SEPARATOR."sql.php");
require_once(__DIR__.DIRECTORY_SEPARATOR."defuse.php");

/**
 * Einbinden grundlegender Webseitenfunktionen
 */
require_once(__DIR__.DIRECTORY_SEPARATOR."output.php");
?>

<?php
/**
 * addfav.php
 * 
 * Anlegen eines Favoriteneintrages.
 */

$title = "Favoriten";
$content.= "<h1><span class='fas'>&#xf004;</span> Favoriten anlegen</h1>".PHP_EOL;

if(!isset($_GET['add'])) {
  $content.= "<div class='row'>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Hier kannst du dir deine eigene Favoriten anlegen.</div>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Zum Beginnen klicke <a href='/addfav?add'>hier</a>.</div>".PHP_EOL.
  "</div>".PHP_EOL;
} else {
  /**
   * Erstellen eines Hashes.
   */
  $key = md5(time().hash('sha256', $_SERVER['REMOTE_ADDR']).rand(10000,99999));
  /**
   * Einfügen des Hashes in die Datenbank und Weiterleitung zur Favoritenübersicht.
   */
  mysqli_query($dbl, "INSERT INTO `fav` (`key`) VALUES ('".$key."')") OR DIE(MYSQLI_ERROR($dbl));
  $content.= "<div class='row'>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Du hast deinen persönlichen Favoriteneintrag erstellt.</div>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Zieh dir nun den folgenden Link einfach in die Lesezeichenleiste:</div>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/fav/".$key."'>pr0.tools Favoriten</a> - über diesen Link kannst du nun Einträge bearbeiten.</div>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Hinweis: Wenn du deine Favoriten sechs Wochen lang nicht benutzt, dann werden sie automatisch gelöscht.</div>".PHP_EOL.
  "</div>".PHP_EOL;
}
?>

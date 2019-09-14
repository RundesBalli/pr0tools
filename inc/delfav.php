<?php
/**
 * delfav.php
 * 
 * Löschen des gesamten Favoriteneintrags.
 */

/**
 * Prüfen ob ein Key übergeben wurde und ob das Format des Keys korrekt ist.
 */
if(!isset($_GET['key']) OR empty($_GET['key'])) {
  http_response_code(404);
  $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
  $content.= "<div class='row'>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Du musst einen gültigen Favoritenschlüssel übergeben. <a href='/'>Zur Startseite</a></div>".PHP_EOL.
  "</div>".PHP_EOL;
} else {
  if(preg_match('/^[a-f0-9]{32}$/', defuse($_GET['key']), $matches) !== 1) {
    http_response_code(404);
    $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
    $content.= "<div class='row'>".PHP_EOL.
    "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Du musst einen gültigen Favoritenschlüssel übergeben. <a href='/'>Zur Startseite</a></div>".PHP_EOL.
    "</div>".PHP_EOL;
  } else {
    $key = $matches[0];
    /**
     * Key in der Datenbank abfragen.
     */
    $result = mysqli_query($dbl, "SELECT `key` FROM `fav` WHERE `key`='".$key."' LIMIT 1") OR DIE(MYSQLI_ERROR($dbl));
    if(mysqli_num_rows($result) == 1) {
      /**
       * Aktuelle Zeit als letzte Nutzungszeit eintragen, damit der Favoriteneintrag nicht nach sechs Wochen entfernt wird.
       */
      mysqli_query($dbl, "UPDATE `fav` SET `lastused` = now() WHERE `key`='".$key."' LIMIT 1") OR DIE(MYSQLI_ERROR($dbl));
      $title = "Favoriten";
      $content.= "<h1><span class='fas'>&#xf7a9;</span> Favoriten löschen</h1>".PHP_EOL;
      if(!isset($_GET['del'])) {
        /**
         * Rückfrage ob wirklich gelöscht werden soll.
         */
        $content.= "<div class='row'>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Bist du dir sicher, dass du deine Favoriteneinträge löschen möchtest?</div>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/delfav/".$key."?del'>Ja</a></div>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/fav/".$key."'>Nein, zurück zu den Favoriten</a></div>".PHP_EOL.
        "</div>".PHP_EOL;
      } else {
        /**
         * Löschen.
         */
        mysqli_query($dbl, "DELETE FROM `fav` WHERE `key`='".$key."' LIMIT 1") OR DIE(MYSQLI_ERROR($dbl));
        $content.= "<div class='row'>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Gelöscht.</div>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/'>Zur Startseite</a></div>".PHP_EOL.
        "</div>".PHP_EOL;
      }
    } else {
      /**
       * Wenn der übergebene Key nicht in der Datenbank vorhanden ist.
       */
      http_response_code(404);
      $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
      $content.= "<div class='row'>".PHP_EOL.
      "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Dieser Favoritenschlüssel existiert nicht.</div>".PHP_EOL.
      "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/'>Zur Startseite</a></div>".PHP_EOL.
      "</div>".PHP_EOL;
    }
  }
}
?>

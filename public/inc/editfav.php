<?php
/**
 * editfav.php
 * 
 * Ändern der Favoriteneinträge.
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
      $content.= "<h1><span class='fas'>&#xf004;</span> Favoriten ändern</h1>".PHP_EOL;
      /**
       * Wenn noch kein Formular übergeben wurde, dann zeig das Formular.
       */
      if(!isset($_POST['submit'])) {
        $content.= "<div class='row'>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12 description'>Mittels Häkchen werden die Favoriten gesetzt. Du kannst sie innerhalb deiner Favoriten noch sortieren. Nutze dafür den Sortierindex. 0 = oben, x&gt;0 = weiter unten.</div>".PHP_EOL.
        "</div>".PHP_EOL;
        /**
         * Alle Items abfragen.
         */
        $result = mysqli_query($dbl, "SELECT `items`.`title`, `items`.`shortTitle`, `fav_items`.`sortindex` FROM `items` LEFT JOIN `fav_items` ON `items`.`shortTitle` = `fav_items`.`item` AND `fav_items`.`key` = '".$key."' ORDER BY `items`.`title` ASC") OR DIE(MYSQLI_ERROR($dbl));
        $content.= "<form method='post' action='/editfav/".$key."'>".PHP_EOL;
        while($row = mysqli_fetch_array($result)) {
          /**
           * Alle Items zeigen und zur Auswahl stellen.
           */
          $content.= "<div class='row hover'>".PHP_EOL.
          "<div class='col-x-1 col-s-1 col-m-1 col-l-1 col-xl-1'><input type='checkbox' name='items[".$row['shortTitle']."]' value='1'".(($row['sortindex'] !== NULL) ? "checked" : "")."></div>".PHP_EOL.
          "<div class='col-x-3 col-s-3 col-m-2 col-l-2 col-xl-2'><input type='number' value='".$row['sortindex']."' name='sortindex[".$row['shortTitle']."]'></div>".PHP_EOL.
          "<div class='col-x-8 col-s-8 col-m-9 col-l-9 col-xl-9'>".$row['title']."</div>".PHP_EOL.
          "</div>".PHP_EOL;
        }
        /**
         * Submit-Button
         */
        $content.= "<div class='row hover'>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><input type='submit' name='submit' value='Änderungen eintragen'></div>".PHP_EOL.
        "</div>".PHP_EOL;
        $content.= "</form>".PHP_EOL;
      } else {
        /**
         * Formularauswertung
         */
        if(empty($_POST['items']) OR empty($_POST['sortindex'])) {
          /**
           * Wenn nichts oder nur Teile übergeben wurden.
           */
          $content.= "<div class='row'>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Das Formular wurde nicht korrekt übergeben.</div>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/editfav/".$key."'>Neuer Versuch</a></div>".PHP_EOL.
          "</div>".PHP_EOL;
        } else {
          /**
           * Einmal alles clearen, dann neu anlegen.
           */
          mysqli_query($dbl, "DELETE FROM `fav_items` WHERE `key`='".$key."'") OR DIE(MYSQLI_ERROR($dbl));
          foreach($_POST['items'] as $item => $val) {
            /**
             * kein OR DIE(MYSQLI_ERROR($dbl)) weil bei Nichtvorhandensein des Items einfach weiter gemacht werden soll.
             */
            mysqli_query($dbl, "INSERT INTO `fav_items` (`key`, `item`, `sortindex`) VALUES ('".$key."', '".defuse($item)."', '".intval(defuse($_POST['sortindex'][$item]), 10)."')");
          }
          $content.= "<div class='row'>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Eingetragen.</div>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/fav/".$key."'>Zu den Favoriten</a></div>".PHP_EOL.
          "</div>".PHP_EOL;
        }
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

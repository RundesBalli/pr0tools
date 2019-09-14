<?php
/**
 * fav.php
 * 
 * Anzeigen der gespeicherten Favoriten.
 */

/**
 * Prüfen ob ein Key übergeben wurde und ob das Format des Keys korrekt ist.
 */
if(!isset($_GET['key']) OR empty($_GET['key'])) {
  http_response_code(404);
  $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
  $content.= "<div class='row'>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Du musst einen gültigen Favoritenschlüssel übergeben oder dir <a href='/addfav'>neue Favoriten anlegen</a>.</div>".PHP_EOL.
  "</div>".PHP_EOL;
} else {
  if(preg_match('/^[a-f0-9]{32}$/', defuse($_GET['key']), $matches) !== 1) {
    http_response_code(404);
    $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
    $content.= "<div class='row'>".PHP_EOL.
    "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Du musst einen gültigen Favoritenschlüssel übergeben oder dir <a href='/addfav'>neue Favoriten anlegen</a>.</div>".PHP_EOL.
    "</div>".PHP_EOL;
  } else {
    $key = $matches[0];
    /**
     * Key in der Datenbank abfragen.
     */
    $result = mysqli_query($dbl, "SELECT `key` FROM `fav` WHERE `key`='".$key."' LIMIT 1") OR DIE(MYSQLI_ERROR($dbl));
    if(mysqli_num_rows($result) == 1) {
      mysqli_query($dbl, "UPDATE `fav` SET `lastused` = now() WHERE `key`='".$key."' LIMIT 1") OR DIE(MYSQLI_ERROR($dbl));
      $title = "Favoriten";
      $content.= "<h1><span class='fas'>&#xf004;</span> Favoriten</h1>".PHP_EOL;
      /**
       * Favoriten-Menü
       */
      $content.= "<div class='row'>".PHP_EOL.
      "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/editfav/".$key."'>Favoriten anpassen</a> - <a href='/delfav/".$key."'>alle Favoriten löschen</a></div>".PHP_EOL.
      "</div>".PHP_EOL;
      $content.= "<div class='spacer-m'></div>";
      /**
       * Abfrage der Favoriten.
       */
      $result = mysqli_query($dbl, "SELECT `items`.* FROM `fav_items` JOIN `items` ON `fav_items`.`item` = `items`.`shortTitle` WHERE `key`='".$key."' ORDER BY `fav_items`.`sortindex` ASC, `items`.`title` ASC") OR DIE(MYSQLI_ERROR($dbl));
      if(mysqli_num_rows($result) == 0) {
        /**
         * Keine Favoriten vorhanden.
         */
        $content.= "<div class='row'>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Hier gibt es noch keine Einträge.</div>".PHP_EOL.
        "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/editfav/".$key."'>Füge deinen Favoriten Einträge hinzu.</a></div>".PHP_EOL.
        "</div>".PHP_EOL;
      } else {
        /**
         * Anzeige der Favoriten
         */
        while($row = mysqli_fetch_array($result)) {
          $content.= "<div class='row'>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-3 col-xl-3'><a href='".$row['url']."' target='_blank' rel='noopener'><img class='thumb' src='/".($row['thumb'] == NULL ? "src/nothumb.png" : "thumbs/".$row['thumb'])."' alt='Bild'></a></div>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-9 col-xl-9'>".PHP_EOL.
          "<div class='row'>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12 bigger'><span class='bold highlight'>".$row['title']."</span> <span class='italic'>von ".($row['author'] == NULL ? "unbekannt" : "<a href='https://pr0gramm.com/user/".$row['author']."' target='_blank' rel='noopener'>".$row['author']."</a>")."</span><span class='right'><a href='".$row['url']."' target='_blank' rel='noopener'><span class='fas'>&#xf35d;</span> zur Seite</a></span></div>".PHP_EOL.
          "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><span class='fas'>&#xf10d;</span> ".($row['description'] == NULL ? "<span class='italic'>Keine Beschreibung vorhanden</span>" : nl2br($row['description']))."</div>".PHP_EOL.
          "</div>".PHP_EOL.
          "</div>".PHP_EOL.
          "</div>".PHP_EOL;
          $content.= "<div class='spacer-m'></div>".PHP_EOL;
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
      "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><a href='/addfav'>Leg dir deine eigenen Favoriten an.</a></div>".PHP_EOL.
      "</div>".PHP_EOL;
    }
  }
}
?>

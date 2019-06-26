<?php
/**
 * showcategory.php
 * 
 * Anzeige aller Einträge innerhalb einer gewählten Kategorie.
 */

/**
 * Prüfen ob die übergebene Kategorie leer ist.
 */
if(!isset($_GET['category']) OR empty(trim($_GET['category']))) {
  http_response_code(404);
  $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
  $content.= "<div class='row'>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Du musst eine Kategorie angeben.</div>".PHP_EOL.
  "</div>".PHP_EOL;
} else {
  /**
   * Übergebene Kategorie für den Query vorbereiten.
   */
  $category = defuse($_GET['category']);

  /**
   * Kategorie abfragen
   */
  $result = mysqli_query($dbl, "SELECT * FROM `categories` WHERE `shortTitle`='".$category."' LIMIT 1") OR DIE(MYSQLI_ERROR($dbl));
  if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $title = $row['title'];
    $content.= "<h1><span class='fas'>&#xf07c;</span> Kategorie: ".$row['title']."</h1>".PHP_EOL;
    /**
     * Kategorienbeschreibung anzeigen, sofern vorhanden.
     */
    if($row['description'] !== NULL) {
      $content.= "<div class='row'>".PHP_EOL.
      "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'><span class='fas'>&#xf10d;</span> ".nl2br($row['description'])."</div>".PHP_EOL.
      "</div>".PHP_EOL;
    }
    $content.= "<div class='spacer-l'></div>".PHP_EOL;
    /**
     * Inhalte der Kategorie anzeigen.
     */
    $result = mysqli_query($dbl, "SELECT `items`.* FROM `category_items` JOIN `items` ON `category_items`.`item` = `items`.`shortTitle` WHERE `category`='".$category."' ORDER BY `category_items`.`sortindex` ASC, `items`.`title` ASC") OR DIE(MYSQLI_ERROR($dbl));
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
  } else {
    /**
     * Fehlermeldung, wenn die Kategorie nicht existiert.
     */
    http_response_code(404);
    $content.= "<h1>404 - Not Found</h1>".PHP_EOL;
    $content.= "<div class='row'>".PHP_EOL.
    "<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Die Kategorie <span class='italic'>".htmlentities($category, ENT_QUOTES)."</span> existiert nicht.</div>".PHP_EOL.
    "</div>".PHP_EOL;
  }
}
?>

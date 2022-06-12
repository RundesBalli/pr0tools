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
  $content.= "<h1>404 - Not Found</h1>";
  $content.= "<div class='row center'>".
    "<div class='col-s-12 col-l-12'>Du musst eine Kategorie angeben.</div>".
  "</div>";
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
    $content.= "<h1><span class='fas icon'>&#xf07c;</span>Kategorie: ".output($row['title'])."</h1>";
    /**
     * Kategorienbeschreibung anzeigen, sofern vorhanden.
     */
    if($row['description'] !== NULL) {
      $content.= "<div class='row center'>".
      "<div class='col-s-12 col-l-12'><span class='fas icon'>&#xf10d;</span>".output($row['description'])."</div>".
      "</div>";
    }
    $content.= "<div class='spacer-l'></div>";
    /**
     * Inhalte der Kategorie anzeigen.
     */
    $result = mysqli_query($dbl, "SELECT `items`.* FROM `category_items` JOIN `items` ON `category_items`.`item` = `items`.`shortTitle` WHERE `category`='".$category."' ORDER BY `category_items`.`sortindex` ASC, `items`.`title` ASC") OR DIE(MYSQLI_ERROR($dbl));
    while($row = mysqli_fetch_array($result)) {
      $content.= "<div class='row item hover'>".
        "<div class='col-s-12 col-l-3 center'>".
          "<a href='".output($row['url'])."' target='_blank' rel='noopener'>".
            "<img class='thumb' src='/assets/".($row['thumb'] == NULL ? "images/noThumb.png" : "thumbs/".output($row['thumb']))."' alt='Bild'>".
          "</a>".
        "</div>".
        "<div class='col-s-12 col-l-9'>".
          "<div class='row'>".
            "<div class='col-s-12 col-l-12 bigger'>".
              "<span class='bold highlight'>".output($row['title'])."</span> <span class='italic'>von ".($row['author'] == NULL ? "unbekannt" : "<a href='https://pr0gramm.com/user/".output($row['author'])."' target='_blank' rel='noopener'>".output($row['author'])."</a>")."</span>".
              "<span class='right'><a href='".output($row['url'])."' target='_blank' rel='noopener'>zur Seite<span class='fas iconright'>&#xf35d;</span></a></span>
            </div>".
            "<div class='col-s-12 col-l-12'>".
              "<span class='fas icon'>&#xf10d;</span>".($row['description'] == NULL ? "<span class='italic'>Keine Beschreibung vorhanden</span>" : output($row['description'])).
            "</div>".
          "</div>".
        "</div>".
      "</div>";
      $content.= "<div class='spacer-m'></div>";
    }
  } else {
    /**
     * Fehlermeldung, wenn die Kategorie nicht existiert.
     */
    http_response_code(404);
    $content.= "<h1>404 - Not Found</h1>";
    $content.= "<div class='row center'>".
      "<div class='col-s-12 col-l-12'>Die Kategorie <span class='italic'>".output($category)."</span> existiert nicht.</div>".
    "</div>";
  }

  $content.= "<div class='spacer-s'></div>";

  $content.= "<div class='row center'>".
    "<div class='col-s-12 col-l-12'>Dir fehlt eine Verlinkung? <a href='https://pr0gramm.com/inbox/messages/RundesBalli' target='_blank' rel='noopener'>Schreib mir eine PN</a> oder <a href='https://github.com/RundesBalli/pr0tools/issues/new' target='_blank' rel='noopener'>eröffne ein Issue auf Github</a>.</div>".
  "</div>";

  $content.= "<div class='spacer-m'></div>";
}
?>

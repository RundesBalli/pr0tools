<?php
/**
 * start.php
 * 
 * Startseite mit kurzer Begrüßung und Erläuterung...
 */

/**
 * Auflistung aller Kategorien mit Kurzbeschreibung.
 */
$content.= "<h1><span class='fas icon'>&#xf07c;</span>Kategorien</h1>";

$content.= "<div class='row hover'>".
  "<div class='col-s-12 col-l-5 alignRightNotMobile mobileCentered'><a href='/all'>Alles</a></div>".
  "<div class='col-s-12 col-l-7 mobileCentered'>Zeigt alle Inhalte an.</div>".
"</div>";

$result = mysqli_query($dbl, "SELECT * FROM `categories` ORDER BY `sortindex` ASC, `title` ASC") OR DIE(MYSQLI_ERROR($dbl));
while($row = mysqli_fetch_array($result)) {
  $content.= "<div class='row hover'>".
    "<div class='col-s-12 col-l-5 alignRightNotMobile mobileCentered'><a href='/category/".output($row['shortTitle'])."'>".output($row['title'])."</a></div>".
    "<div class='col-s-12 col-l-7 mobileCentered'>".($row['shortDescription'] == NULL ? "<span class='italic'>Keine Beschreibung vorhanden</span>" : output($row['shortDescription']))."</div>".
  "</div>";
}
?>

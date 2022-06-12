<?php
/**
 * all.php
 * 
 * Alphabetische Anzeige aller Einträge ohne Thumbnail.
 */

$content.= "<h1>Alle Einträge</h1>";
$content.= "<div class='row'>";
$result = mysqli_query($dbl, "SELECT * FROM `items` ORDER BY `title` ASC") OR DIE(MYSQLI_ERROR($dbl));
while($row = mysqli_fetch_array($result)) {
  $content.= "<div class='col-s-12 col-l-4 item hover center'><a href='".output($row['url'])."' target='_blank' rel='noopener'>".output($row['title'])."</a></div>";
}
$content.= "</div>";
?>

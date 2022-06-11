<?php
/**
 * all.php
 * 
 * Alphabetische Anzeige aller Einträge ohne Thumbnail.
 */

$content.= "<h1>Alle Einträge</h1>".PHP_EOL;
$content.= "<div class='row'>".PHP_EOL;
$result = mysqli_query($dbl, "SELECT * FROM `items` ORDER BY `title` ASC") OR DIE(MYSQLI_ERROR($dbl));
while($row = mysqli_fetch_array($result)) {
  $content.= "<div class='col-s-12 col-l-4 item hover'><a href='".$row['url']."' target='_blank' rel='noopener'>".$row['title']."</a></div>".PHP_EOL;
}
$content.= "</div>".PHP_EOL;
?>

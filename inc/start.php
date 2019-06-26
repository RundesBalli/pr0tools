<?php
/**
 * start.php
 * 
 * Startseite mit kurzer Begrüßung und Erläuterung...
 */
$title = "Startseite";
$content.= "<h1><span class='fas'>&#xf7d9;</span> pr0.tools</h1>".PHP_EOL;
$content.= "<div class='row'>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Willkommen auf pr0.tools!</div>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>pr0.tools ist eine Linksammlung für nützliche Tools rund ums pr0gramm.</div>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Das Projekt wurde von <a href='https://pr0gramm.com/user/yys' target='_blank' rel='noopener'>yys</a>, welcher das Projekt auch in der ersten Zeit betrieb und betreute, gestartet und ging am 22.06.2019 in die Obhut von <a href='https://pr0gramm.com/user/RundesBalli' target='_blank' rel='noopener'>RundesBalli</a> über und wurde komplett neu aufgesetzt und überarbeitet.</div>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Dir fehlt eine Verlinkung? <a href='https://pr0gramm.com/inbox/messages/RundesBalli' target='_blank' rel='noopener'>Schreib mir eine PN</a> oder <a href='https://github.com/RundesBalli/pr0tools/issues/new' target='_blank' rel='noopener'>eröffne ein Issue auf Github</a>.</div>".PHP_EOL.
"</div>".PHP_EOL;

$content.= "<div class='spacer-l'></div>".PHP_EOL;

/**
 * ...sowie Auflistung aller Kategorien mit Kurzbeschreibung.
 */
$content.= "<h1><span class='fas'>&#xf07c;</span> Kategorien</h1>".PHP_EOL;
$content.= "<div class='row'>".PHP_EOL;
$content.= "<div class='col-x-12 col-s-12 col-m-3 col-l-3 col-xl-3'><a href='/all'>Alles</a></div>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-9 col-l-9 col-xl-9'>Zeigt alle Inhalte an.</div>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-0 col-l-0 col-xl-0'><div class='spacer-s'></div></div>".PHP_EOL;
$result = mysqli_query($dbl, "SELECT * FROM `categories` ORDER BY `sortindex` ASC, `title` ASC") OR DIE(MYSQLI_ERROR($dbl));
while($row = mysqli_fetch_array($result)) {
  $content.= "<div class='col-x-12 col-s-12 col-m-3 col-l-3 col-xl-3'><a href='/category/".$row['shortTitle']."'>".$row['title']."</a></div>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-9 col-l-9 col-xl-9'>".($row['shortDescription'] == NULL ? "<span class='italic'>Keine Beschreibung vorhanden</span>" : $row['shortDescription'])."</div>".PHP_EOL.
  "<div class='col-x-12 col-s-12 col-m-0 col-l-0 col-xl-0'><div class='spacer-s'></div></div>".PHP_EOL;
}
$content.= "</div>".PHP_EOL;
?>

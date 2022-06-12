<?php
/**
 * pr0.tools
 * 
 * Eine Sammlung nützlicher Links für das pr0gramm
 * 
 * @author    RundesBalli <webspam@rundesballi.com>
 * @copyright 2019 RundesBalli
 * @version   1.0
 * @license   MIT-License
 * @see       https://github.com/RundesBalli/pr0tools
 */

/**
 * Einbinden der Konfigurationsdatei sowie der Funktionsdatei
 */
require_once(__DIR__.DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."config.php");
require_once(__DIR__.DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."functions.php");

/**
 * Initialisieren des Outputs und des Standardtitels
 */
$content = "";
$title = "";

/**
 * Herausfinden welche Seite angefordert wurde
 */
if(!isset($_GET['p']) OR empty($_GET['p'])) {
  $getp = "start";
} else {
  preg_match("/([\d\w-]+)/i", $_GET['p'], $match);
  $getp = $match[1];
}

/**
 * Das Seitenarray für die Seitenzuordnung
 */
$pageArray = array(
  /* Standardseiten */
  'start'          => 'start.php',
  'imprint'        => 'imprint.php',

  /* Seiten zur Ansicht der Kategorien und Einträge */
  'showCategory'   => 'showCategory.php',
  'all'            => 'all.php',

  /* Fehlerseiten */
  '404'            => '404.php',
  '403'            => '403.php'
);

/**
 * Prüfung ob die Unterseite im Array existiert, falls nicht 404
 */
if(isset($pageArray[$getp])) {
  require_once(__DIR__.DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR.$pageArray[$getp]);
} else {
  require_once(__DIR__.DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."404.php");
}

/**
 * Navigation
 * Das Toggle Element befindet sich im Template
 */
$a = " class='active'";
$nav = "<a href='/'".($getp == "start" ? $a : NULL).">Startseite</a>";
$nav.= "<a href='/all'".($getp == "all" ? $a : NULL).">Alles</a>";

$result = mysqli_query($dbl, "SELECT `title`, `shortTitle` FROM `categories` ORDER BY `sortindex` ASC, `title` ASC") OR DIE(MYSQLI_ERROR($dbl));
if(mysqli_num_rows($result) != 0) {
  while($row = mysqli_fetch_array($result)) {
    $nav.= "<a href='/category/".$row['shortTitle']."'".(($getp == "showCategory" AND (!empty($_GET['category']) AND $_GET['category'] == $row['shortTitle'])) ? $a : NULL).">".$row['title']."</a>";
  }
}

/**
 * Templateeinbindung und Einsetzen der Variablen
 */
$templatefile = __DIR__.DIRECTORY_SEPARATOR."src".DIRECTORY_SEPARATOR."template.tpl";
$fp = fopen($templatefile, "r");
$output = preg_replace(
  array(
    "/{TITLE}/im",
    "/{NAV}/im",
    "/{CONTENT}/im"
  ),
  array(
    ($title == "" ? "" : $title." - "),
    $nav,
    $content
  ),
  fread($fp, filesize($templatefile))
);
fclose($fp);

/**
 * Tidy HTML Output
 * @see https://gist.github.com/RundesBalli/a5d20a8c92a9a004803980654e638cbb
 * @see https://api.html-tidy.org/tidy/quickref_5.6.0.html
 */

$tidyOptions = array(
  'indent' => TRUE,
  'output-xhtml' => TRUE,
  'wrap' => 200,
  'newline' => 'LF', /* LF = \n */
  'output-encoding' => 'utf8',
  'drop-empty-elements' => FALSE /* e.g. for placeholders */
);

$tidy = tidy_parse_string($output, $tidyOptions, 'UTF8');
tidy_clean_repair($tidy);
echo $tidy;
?>

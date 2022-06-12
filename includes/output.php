<?php
/**
 * output.php
 * 
 * Ausgabefunktion
 * 
 * @param  string $string String, der ausgegeben werden soll.
 * 
 * @return string Der vorbereitete String.
 */
function output($string) {
  return nl2br(htmlentities($string, ENT_QUOTES));
}
?>

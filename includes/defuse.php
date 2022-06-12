<?php
/**
 * defuse.php
 * 
 * Entschärffunktion
 * 
 * @param  string $defuseString String der "entschärft" werden soll, um ihn in einen DB-Query zu übergeben.
 * @param  bool   $trim         Gibt an ob Leerzeichen/-zeilen am Anfang und Ende entfernt werden sollen.
 * 
 * @return string Der vorbereitete, "entschärfte" String.
 */
function defuse($defuseString, $trim = TRUE) {
  if($trim === TRUE) {
    $defuseString = trim($defuseString);
  }
  global $dbl;
  return mysqli_real_escape_string($dbl, strip_tags($defuseString));
}
?>

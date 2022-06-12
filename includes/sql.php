<?php
/**
 * sql.php
 * 
 * Stellt die Datenbankverbindung her und richtet das korrekte Charset ein.
 */
$dbl = mysqli_connect($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb) OR DIE(MYSQLI_ERROR($dbl));
mysqli_set_charset($dbl, $mysqlCharset) OR DIE(MYSQLI_ERROR($dbl));
?>

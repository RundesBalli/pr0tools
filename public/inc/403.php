<?php
/**
 * 403.php
 * 
 * 403 ErrorDocument.
 * Gibt die Fehlermeldung, sowie den angeforderten Pfad zurück.
 */
$title = "403";
http_response_code(403);
$content.= "<h1>403 - Forbidden</h1>".PHP_EOL;
$content.= "<div class='row'>".PHP_EOL.
"<div class='col-s-12 col-l-12'>Du hast keine Berechtigung auf die von dir angeforderte Ressource <span class='italic'>".htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES)."</span> zuzugreifen.</div>".PHP_EOL.
"</div>".PHP_EOL;
?>

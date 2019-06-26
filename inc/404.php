<?php
/**
 * 404.php
 * 
 * 404 ErrorDocument.
 * Gibt die Fehlermeldung, sowie den angeforderten Pfad zurück.
 */
$title = "404";
http_response_code(404);
$content.= "<h1>404 - Not Found</h1>".PHP_EOL;
$content.= "<div class='row'>".PHP_EOL.
"<div class='col-x-12 col-s-12 col-m-12 col-l-12 col-xl-12'>Die von dir angeforderte Ressource <span class='italic'>".htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES)."</span> existiert nicht.</div>".PHP_EOL.
"</div>".PHP_EOL;
?>

<?php
/**
 * 404.php
 * 
 * 404 ErrorDocument.
 * Gibt die Fehlermeldung, sowie den angeforderten Pfad zurück.
 */
$title = "404";
http_response_code(404);
$content.= "<h1>404 - Not Found</h1>";
$content.= "<div class='row center'>".
  "<div class='col-s-12 col-l-12'>Die von dir angeforderte Ressource <span class='italic'>".output($_SERVER['REQUEST_URI'])."</span> existiert nicht.</div>".
"</div>";
?>

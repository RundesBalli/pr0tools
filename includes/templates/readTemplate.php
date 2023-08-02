<?php
/**
 * includes/template/readTemplate.php
 * 
 * Loads the template file.
 */
$templateFile = __DIR__.DIRECTORY_SEPARATOR.'template.tpl';
if(file_exists($templateFile)) {
  $fp = fopen($templateFile, 'r');
  $template = fread($fp, filesize($templateFile));
  fclose($fp);
} else {
  http_response_code(500);
  echo '<h1>500 - Internal Server Error</h1>';
  die();
}
?>

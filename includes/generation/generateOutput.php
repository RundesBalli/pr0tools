<?php
/**
 * includes/generation/generateOutput.php
 * 
 * Generates the output with previous generated contents.
 */
$output = preg_replace(
  array(
    '/{CONTENT}/im'
  ),
  array(
    $content
  ),
  $template
);
?>

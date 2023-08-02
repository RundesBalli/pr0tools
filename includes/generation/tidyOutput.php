<?php
/**
 * includes/generation/tidyOutput.php
 * 
 * Tidies up the previously created output.
 * 
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

$output = tidy_parse_string($output, $tidyOptions, 'UTF8');
tidy_clean_repair($output);
?>

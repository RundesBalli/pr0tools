<?php
/**
 * pr0.tools
 * 
 * @author    RundesBalli <GitHub@RundesBalli.com>
 * @copyright 2023 RundesBalli
 * @version   3.0
 * @see       https://github.com/RundesBalli/pr0tools
 */

/**
 * Initialize content variable.
 */
$content = '';

/**
 * Including the configuration and function loader, the page generation elements, the router and the output generation.
 */
require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'loader.php');

/**
 * Output the generated and tidied output.
 */
echo $output;
?>

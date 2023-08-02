<?php
/**
 * includes/loader.php
 * 
 * Configuration and function loader
 */

/**
 * Content generation and router
 */
require_once(__DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'readTemplate.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'routing'.DIRECTORY_SEPARATOR.'routes.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'routing'.DIRECTORY_SEPARATOR.'router.php');

/**
 * Page generation
 */
require_once(__DIR__.DIRECTORY_SEPARATOR.'generation'.DIRECTORY_SEPARATOR.'generateOutput.php');
require_once(__DIR__.DIRECTORY_SEPARATOR.'generation'.DIRECTORY_SEPARATOR.'tidyOutput.php');
?>

<?php
/**
 * includes/routing/router.php
 * 
 * Router for the requested page.
 */
/**
 * PAGE_INCLUDE_DIR
 * 
 * Directory from which each subpage is included.
 */
const PAGE_INCLUDE_DIR = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'pages'.DIRECTORY_SEPARATOR;

/**
 * No error occurred so far. Find out which page was requested and if the requested page matches the pattern.
 */
if(!empty($_GET['page']) AND preg_match('/([a-z-\d]+)/i', $_GET['page'], $pageMatch) === 1) {
  /**
   * Check if the requested page exist in the routes.
   */
  if(array_key_exists($pageMatch[1], $routes)) {
    /**
     * The route exists. Include the file.
     */
    $route = $pageMatch[1];
    $fileToInclude = PAGE_INCLUDE_DIR.$routes[$route];
    if(file_exists($fileToInclude)) {
      /**
       * File exists
       */
      require_once($fileToInclude);
    } else {
      /**
       * File doesn't exist.
       */
      http_response_code(500);
      echo '<h1>500 - Internal Server Error</h1>';
      die();
    }
  } else {
    /**
     * The requested page doesn't exist in the routes.
     */
    header('Location: /');
    die();
  }
} else {
  /**
   * No page was requested or the requested page doesn't match the pattern.
   */
  $route = 'main';
  $fileToInclude = PAGE_INCLUDE_DIR.$routes[$route];
  if(file_exists($fileToInclude)) {
    /**
     * File exists
     */
    require_once($fileToInclude);
  } else {
    /**
     * File doesn't exist.
     */
    http_response_code(500);
    echo '<h1>500 - Internal Server Error</h1>';
    die();
  }
}
?>

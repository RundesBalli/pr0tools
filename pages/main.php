<?php
/**
 * pages/main.php
 * 
 * Main site
 */

/**
 * Description text
 */
$content.= '<p><span class="fas icon">&#xf05a;</span>pr0.tools ist eine Plattform zur Übersicht aller nützlichen Tools, Scripts, Webseiten und Bots rund um das <a href="https://pr0gramm.com" target="_blank" rel="noopener">pr0gramm</a></p>';

$content.= '<p><span class="fas icon">&#xf055;</span>Sollte dir ein Eintrag fehlen, dann <a href="https://pr0gramm.com/inbox/messages/RundesBalli" target="_blank" rel="noopener">schreib mir eine PN</a>, <a href="https://github.com/RundesBalli/pr0tools/issues/new" target="_blank" rel="noopener">eröffne ein Issue</a> oder <a href="https://github.com/RundesBalli/pr0tools#mitwirken" target="_blank" rel="noopener">füge es selbst hinzu</a>.</p>';

/**
 * Iterate through categories and items
 */
foreach($ci as $c) {
  $content.= '<h2><span class="'.$c['fa'].' icon">&#x'.$c['symbol'].';</span>'.$c['title'].'</h2>'.
  '<div class="items">';

  /**
   * Iterate through items in category.
   */
  foreach($c['items'] as $item) {
    $content.=
    '<div class="item">
      <a href="'.$item['url'].'" target="_blank" rel="noopener">
        <img src="/assets/thumbs/'.$item['thumb'].'.png">
      </a>
      <div class="infos">
        <div class="project">
          <div class="name"><a href="'.$item['url'].'" target="_blank" rel="noopener">'.$item['name'].'</a></div>
          <span class="smaller">von <a href="https://pr0gramm.com/user/'.$item['author'].'" target="_blank" rel="noopener">'.$item['author'].'</a></span>
        </div>
        '.nl2br($item['description']).'
      </div>
    </div>';
  }

  $content.= '</div>';
}
?>

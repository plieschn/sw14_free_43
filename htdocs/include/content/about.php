<?php
namespace tsis\content;

require_once('content.php');

class About extends Content {
  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $tpl = 'about.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'About');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }
}
?>

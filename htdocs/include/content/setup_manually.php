<?php
namespace tsis\content;

require_once('content.php');

class SetupManually extends Content {
  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $tpl = 'setup_manually.tpl';
    $smarty->assign('sub_menu_items', $sub_menu_items);
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Setup');
    $smarty->assign('sub_selected', 'Manually');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }
}
?>

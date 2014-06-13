<?php
namespace tsis\content;

require_once('content.php');
require_once('include/database/statement.php');

use \tsis\database\ParamType as ParamType;
use \DateTime as DateTime;

class Logout extends Content {
  public function setMainMenuItems($path_array, $baselink, $main_menu_items, &$content_factory) {
    unset($main_menu_items['Logout']);
    $main_menu_items['Login'] = 'Login';
    $main_menu_items['Register'] = 'Register';
    return $main_menu_items;
  }

  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    unset($_SESSION['username']);
    $tpl = 'about.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'About');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }
}
?>

<?php
namespace tsis\content;

require_once('content.php');

class Setup extends Content {
  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $sub_menu_items = $this->getSubMenuItems();

    if(count($path_array) > 2) {
      if($path_array[1] != 'Automatic' &&
         $path_array[1] != 'Manually' &&
         $path_array[1] != 'Test') {
        $this->resourceNotFound($smarty, $baselink);
        return;
      }

      if($path_array[1] == 'Automatic') {
        $content = $content_factory->getContent('setup_automatic');
        if($content != NULL) {
          $smarty_output = $content->get($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
        } else {
          $this->resourceNotFound($smarty, $baselink);
        }
      } else if($path_array[1] == 'Manually') {
        $content = $content_factory->getContent('setup_manually');
        if($content != NULL) {
          $smarty_output = $content->get($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
        } else {
          $this->resourceNotFound($smarty, $baselink);
        }
      } else if($path_array[1] == 'Test') {
        $content = $content_factory->getContent('setup_test');
        if($content != NULL) {
          $smarty_output = $content->get($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
        } else {
          $this->resourceNotFound($smarty, $baselink);
        }
      }

      return $smarty_output;
    }

    $tpl = 'setup.tpl';
    $smarty->assign('sub_menu_items', $sub_menu_items);
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Setup');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }

  private function getSubMenuItems() {
    $sub_menu_items = array('Automatic' => 'Automatic',
                            'Manually' => 'Manually',
                            'Test' => 'Test');

    return $sub_menu_items;
  }
}
?>

<?php
namespace tsis\content;

require_once('content.php');
require_once('include/database/statement.php');

use \tsis\database\ParamType as ParamType;

class SetupTest extends Content {
  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {

    $this->connect();
    if($this->database->getConnectError()) {
      print($this->database->getConnectError());
      return;
    }

    $query = 'select value_text from ' . $this->table_prefix_ .'information where `key`=?';
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $key = 'version';
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'key', &$key)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $version = NULL;
    $result = $statement->bindResults(array(&$version));
    $statement->fetch();

    $tpl = 'setup_test.tpl';
    $smarty->assign('sub_menu_items', $sub_menu_items);
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Setup');
    $smarty->assign('sub_selected', 'Test');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty->assign('version', $version);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }
}
?>

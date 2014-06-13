<?php
namespace tsis\content;

require_once('content.php');
require_once('include/database/statement.php');

use \tsis\database\ParamType as ParamType;
use \DateTime as DateTime;

class Login extends Content {
  public function setMainMenuItems($path_array, $baselink, $main_menu_items, &$content_factory) {
    if(isset($_GET['action']) && $_GET['action'] == 'submit' && $this->success()) {
      unset($main_menu_items['Login']);
      unset($main_menu_items['Register']);
      $main_menu_items['Logout'] = 'Logout';
      return $main_menu_items;
    } else {
      return $main_menu_items;
    }
  }

  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    if(isset($_GET['action']) && $_GET['action'] == 'submit') {
      return $this->submit($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
    } else {
      return $this->view($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
    }
  }

  private function submit($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $username = $_POST['username'];
    if($this->success() == false) {
      $tpl = 'login.tpl';
      $smarty->assign('baselink', $baselink);
      $smarty->assign('selected', 'Login');
      $smarty->assign('main_menu_items', $main_menu_items);
      $smarty->assign('username', $username);
      $smarty->assign('failed', true);
      $smarty_output = $smarty->fetch($tpl);
      return $smarty_output;
    } else {
      $_SESSION['username'] = $username;
      $tpl = 'about.tpl';
      $smarty->assign('baselink', $baselink);
      $smarty->assign('selected', 'About');
      $smarty->assign('main_menu_items', $main_menu_items);
      $smarty_output = $smarty->fetch($tpl);
      return $smarty_output;
    }
  }

  private function view($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $tpl = 'login.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Login');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty->assign('username', '');
    $smarty->assign('failed', false);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }

  private function success() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = 'select count(*) as amount from ' . $this->table_prefix_ . 'persons where username = ? and password = PASSWORD(?)';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'username', &$username),
                                         array(ParamType::PARAM_TYPE_STRING, 'password', &$password)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $amount = NULL;
    $result = $statement->bindResults(array(&$amount));
    $statement->fetch();

    return ($amount == 1);
  }
}
?>

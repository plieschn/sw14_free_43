<?php
namespace tsis\content;

require_once('content.php');
require_once('include/database/statement.php');

use \tsis\database\ParamType as ParamType;
use \DateTime as DateTime;

class Register extends Content {
  public function setMainMenuItems($path_array, $baselink, $main_menu_items, &$content_factory) {
    if(isset($_GET['action']) && $_GET['action'] == 'submit' && !$this->exists()) {
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
    if(!$this->exists()) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $title = $_POST['title'];
      $admin = 0;

      $query = 'insert into ' . $this->table_prefix_ . 'persons (username, password, first_name, last_name, title, admin, last_time_modified) ';
			$query .= 'VALUES (?, PASSWORD(?), ?, ?, ?, ?, CURRENT_TIMESTAMP)';

      $this->connect();
      $statement = $this->database->prepare($query);
      if(!$statement->prepareWorked()) {
        print($this->database->getError());
        return;
      }

      if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'username', &$username),
                                           array(ParamType::PARAM_TYPE_STRING, 'password', &$password),
                                           array(ParamType::PARAM_TYPE_STRING, 'first_name', &$first_name),
                                           array(ParamType::PARAM_TYPE_STRING, 'last_name', &$last_name),
                                           array(ParamType::PARAM_TYPE_STRING, 'title', &$title),
                                           array(ParamType::PARAM_TYPE_INT, 'admin', &$admin)))) {
        print($this->database->getError());
        return;
      }

      if(!$statement->execute()) {
        print($this->database->getError());
        print($statement->getError());
        return;
      }

      $tpl = 'about.tpl';
      $smarty->assign('baselink', $baselink);
      $smarty->assign('selected', 'About');
      $smarty->assign('main_menu_items', $main_menu_items);
      $smarty_output = $smarty->fetch($tpl);
      return $smarty_output;
    } else {
      $tpl = 'register.tpl';
      $smarty->assign('baselink', $baselink);
      $smarty->assign('selected', 'Register');
      $smarty->assign('failed', true);
      $smarty->assign('reason', 'user_name_exists');
      $smarty->assign('main_menu_items', $main_menu_items);
      $smarty_output = $smarty->fetch($tpl);
      return $smarty_output;
    }
  }

  private function view($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $tpl = 'register.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Register');
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }

  private function exists() {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = 'select count(*) as amount from ' . $this->table_prefix_ . 'persons where username = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'username', &$username)))) {
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

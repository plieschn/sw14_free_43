<?php
namespace tsis\content;

require_once('content_factory.php');
require_once('include/database/database_config.php');
require_once('include/database/database_factory.php');

use \tsis\database\DatabaseConfig as DatabaseConfig;
use \tsis\database\DatabaseFactory as DatabaseFactory;

abstract class Content {
  protected $table_prefix_ = '';

  public function setMainMenuItems($path_array, $baselink, $main_menu_items, &$content_factory) {
    return $main_menu_items;
  }

  abstract public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty);

  public function __construct() {
  }

  protected function connect() {
    $database_config = new DatabaseConfig();
    $database_config->load();
    $this->table_prefix_ = $database_config->getTablePrefix();
    $database_factory = new DatabaseFactory();
    $this->database = $database_factory->getModule(DATABASE_MODULE_MYSQLI);
    $this->database->connect($database_config->getHost(),
                             $database_config->getUser(),
                             $database_config->getEncPassword(),
                             $database_config->getDatabase());
  }

  public function resourceNotFound(&$smarty, $baselink) {
    $content_factory = new ContentFactory();
    $main_menu_items = $content_factory->mainMenuItems();
    header("HTTP/1.0 404 Not Found");
    $smarty->assign('baselink', $baselink);
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch('error_404.tpl');
    print($smarty_output);
  }

  public function unauthorized(&$smarty, $baselink) {
    $content_factory = new ContentFactory();
    $main_menu_items = $content_factory->mainMenuItems();
    header("HTTP/1.0 401 Unauthorized");
    $smarty->assign('baselink', $baselink);
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch('error_401.tpl');
    print($smarty_output);
  }
}
?>

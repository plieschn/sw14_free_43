<?php
namespace tsis\database;

define('DATABASE_MODULE_MYSQLI', 0x01);

require_once('database_mysqli.php');
require_once('database_pdo.php');

class DatabaseFactory {
  private $module_id_ = DATABASE_MODULE_MYSQLI;

  public function getModuleId() {
    return $this->module_id_;
  }

  public function setModuleId($module_id) {
    $this->module_id_ = $module_id;
  }

  public function getModule($module_id = NULL) {
    if(!$module_id)
      $module_id = $this->module_id_; 
    
    switch($module_id) {
    case DATABASE_MODULE_MYSQLI:
      return new DatabaseMysqli();
      break;
    case DATABASE_MODULE_PDO:
      return new DatabasePDO();
      break;
    default:
      echo "Unknown database module: " . $module_id	;
    }
  }
}
?>

<?php
namespace tsis\database;

define('STATEMENT_MODULE_MYSQLI', 0x01);

require_once('statement_mysqli.php');
require_once('statement_pdo.php');

class StatementFactory {
  private $module_id_ = STATEMENT_MODULE_MYSQLI;
  
  public function getModuleId() {
    return $this->module_id_;
  }
  
  public function setModuleId($module_id) {
    $this->module_id_ = $module_id;
  }
  
  public function getStatement($statement, $module_id = NULL) {
    if(!$module_id)
      $module_id = $this->module_id_; 
    
    switch($module_id) {
    case STATEMENT_MODULE_MYSQLI:
      return new StatementMysqli($statement);
      break;
    case STATEMENT_MODULE_PDO:
      return new StatementMysqli($statement);
      break;
    default:
      echo "Unknown statement module: " . $module_id	;
    }
  }
}
?>

<?php
namespace tsis\database;

define('RESULT_MODULE_MYSQLI', 0x01);

require_once('result_mysqli.php');

class ResultFactory {
  private $module_id_ = RESULT_MODULE_MYSQLI;

  public function getModuleId() {
    return $this->module_id_;
  }

  public function setModuleId($module_id) {
    $this->module_id_ = $module_id;
  }

  public function getResult($result, $module_id = NULL) {
    if(!$module_id)
      $module_id = $this->module_id_;

    switch($module_id) {
    case RESULT_MODULE_MYSQLI:
      return new ResultMysqli($result);
      break;
    default:
      echo "Unknown result module: " . $module_id       ;
    }
  }
}
?>

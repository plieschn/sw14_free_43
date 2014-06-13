<?php
namespace tsis\database;

require_once('statement.php');

class StatementPDO implements Statement{
  private $result_factory_;

  public function __construct($statement) {
    $this->statement_ = $statement;
  }

  public function prepareWorked() {
    return $this->statement_ != false;
  }

  public function bindParameters($parameters) {

  }

  public function bindResults($results) {

  }

  public function execute() {
    return $this->statement_->execute();
  }

  public function getResult() {
    $result = $this->statement_->get_result();
    $this->result_factory_->setModuleId(RESULT_MODULE_MYSQLI);
    $result_object = $this->result_factory_->getResult($result);
    return $result_object;
  }

  public function fetch() {
    return $this->statement_->fetch();
  }

  public function getError() {
    return $this->statement_->error;
  }
}
?>

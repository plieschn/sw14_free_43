<?php
namespace tsis\database;

require_once('statement.php');

class StatementMysqli implements Statement{
  private $result_factory_;

  public function __construct($statement) {
    $this->statement_ = $statement;
    $this->result_factory_ = new ResultFactory();
  }

  public function prepareWorked() {
    return $this->statement_ != false;
  }

  public function bindParameters($parameters) {
    $ref_parameters = array();

    $ref_parameters[0] = '';
    $counter = 1;

    foreach($parameters as $parameter) {
      $type = $parameter[0];
      $variable =& $parameter[2];

      if($type == ParamType::PARAM_TYPE_BOOL) {
        $ref_parameters[0] .= 'i';
      } else if($type == ParamType::PARAM_TYPE_INT) {
        $ref_parameters[0] .= 'i';
      } else if($type == ParamType::PARAM_TYPE_NUM) {
        $ref_parameters[0] .= 'd';
      } else if($type == ParamType::PARAM_TYPE_STRING) {
        $ref_parameters[0] .= 's';
      } else if($type == ParamType::PARAM_TYPE_BLOB) {
        $ref_parameters[0] .= 'b';
      }

      $ref_parameters[$counter++] =& $variable;
    }

    return call_user_func_array(array($this->statement_, 'bind_param'), $ref_parameters);
  }

  public function bindResults($results) {
    return call_user_func_array(array($this->statement_, 'bind_result'), $results);
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

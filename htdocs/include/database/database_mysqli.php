<?php
namespace tsis\database;

require_once('database.php');
require_once('result_factory.php');
require_once('result.php');
require_once('statement_factory.php');
require_once('statement.php');

class DatabaseMysqli implements Database
{
  private $db_;
  private $result_factory_;
  private $statement_factory_;

  public function __construct() {
    $this->result_factory_ = new ResultFactory();
    $this->statement_factory_ = new StatementFactory();
  }

  public function connect($host, $user, $enc_password, $database) {
    $password = base64_decode($enc_password);
    $this->db_ = new \mysqli($host, $user, $password, $database);
    $this->db_->set_charset('utf8');
  }

  public function getConnectError() {
    return $this->db_->connect_error;
  }

  public function &query($query) {
    $result = $this->db_->query($query);
    $this->result_factory_->setModuleId(RESULT_MODULE_MYSQLI);
    $result_object = $this->result_factory_->getResult($result);
    return $result_object;
  }

  public function &prepare($query) {
    $statement = $this->db_->prepare($query);
    $this->statement_factory_->setModuleId(STATEMENT_MODULE_MYSQLI);
    $statement_object = $this->statement_factory_->getStatement($statement);
    return $statement_object;
  }

  public function getInsertId() {
    return $this->db_->insert_id;
  }

  public function getError() {
    return $this->db_->error;
  }
}
?>

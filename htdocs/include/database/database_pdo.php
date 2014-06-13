<?php
namespace tsis\database;

require_once('database.php');
require_once('statement_factory.php');
require_once('statement.php');

class DatabasePDO implements Database
{
  private $db_;
  private $statement_factory_;
  private $connection_error_;
  private $error_;

  public function __construct() {
    $this->statement_factory_ = new StatementFactory();
  }

  public function connect($host, $user, $enc_password, $database) {
    $password = base64_decode($enc_password);
    try {
      $this->db_ = new \PDO("mysql:host=$host;dbname=$database", $user, $password);
    } catch(PDOException $e) {
      $this->error_ = $e->getMessage();
    }
  }

  public function getConnectError() {
    return $this->connection_error_;
  }

  public function &query($query) {
    try {
      $statement = $$this->db_->query($query);
    } catch(PDOException $e) {
      $this->error_ = $e->getMessage();
    }

    return $statement;
  }

  public function &prepare($query) {
    try {
      $statement = $this->db_->prepare($query);
    } catch(PDOException $e) {
      $this->error_ = $e->getMessage();
    }

    $this->statement_factory_->setModuleId(STATEMENT_MODULE_PDO);
    $statement_object = $this->statement_factory_->getStatement($statement);
    return $statement_object;
  }

  public function getInsertId() {
    return $this->db_->lastInsertId();
  }

  public function getError() {
    return $this->error_;
  }
}
?>

<?php
namespace tsis\database;

require_once('result.php');

class ResultMysqli implements Result {
  public function __construct($result) {
    $this->result_ = $result;
  }

  public function fetchObject() {
    if($this->result_)
      return $this->result_->fetch_object();
  }

  public function getNumRows() {
    return $this->result_->num_rows;
  }

  private $result_;
}
?>

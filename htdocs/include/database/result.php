<?php
namespace tsis\database;

interface Result {
  public function __construct($result);
  public function fetchObject();
  public function getNumRows();
}
?>

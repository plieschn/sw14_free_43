<?php
namespace tsis\database;

abstract class ParamType {
  const PARAM_TYPE_BOOL = 0;
  const PARAM_TYPE_INT = 1;
  const PARAM_TYPE_NUM = 2;
  const PARAM_TYPE_STRING = 3;
  const PARAM_TYPE_BLOB = 4;
}

interface Statement {
  public function __construct($statement);
  public function prepareWorked();
  public function bindParameters($parameters);
  public function bindResults($results);
  public function execute();
  public function getResult();
  public function fetch();
  public function getError();
}
?>

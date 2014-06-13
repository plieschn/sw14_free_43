<?php
namespace tsis\database;

interface Database {
  public function connect($host, $user, $enc_password, $database);
  public function getConnectError();
  public function &query($query);
  public function &prepare($query);
  public function getInsertId();
  public function getError();
}
?>

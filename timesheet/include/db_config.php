<?php
class DBConfig {
  private $host = '';
  private $database = '';
  private $username = '';
  private $password = '';

  function __construct($host, $database, $username, $password) {
    $this->host = $host;
    $this->database = $database;
    $this->username = $username;
    $this->password = $password;
  }

  public function getHost() {
    return $this->host;
  }

  public function getDatabase() {
    return $this->database;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getPassword() {
    return $this->password;
  }
}
?>

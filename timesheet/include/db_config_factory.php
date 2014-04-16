<?php
require_once('db_config.php');

class DBConfigFactory {
  public function get() {
    $contents = file_get_contents('include/db_config.json');
    $json_object = json_decode($contents);

    if($json_object != NULL) {
      $host = $json_object->host;
      $database = $json_object->database;
      $username = $json_object->username;
      $password = $json_object->password;

      $db_config = new DBConfig($host, $database, $username, $password);
      return $db_config;
    }
    return NULL;
  }
}
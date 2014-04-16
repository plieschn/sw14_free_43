<?php
require_once('db_config_factory.php');

function main() {
  $db_config_factory = new DBConfigFactory();
  $db_config = $db_config_factory->get();
  if($db_config == NULL)
    return;

  $mysqli = getMysqlI($db_config);
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  
}

function getMysqlI($db_config) {
  $mysqli = new mysqli($db_config->getHost(),
		       $db_config->getUsername(),
		       $db_config->getPassword(),
		       $db_config->getDatabase());
  return $mysqli;
}

main();
?>

<?php
define('SMARTY_DIR', "/usr/share/php/smarty/");

require_once('db_config_factory.php');
require_once(SMARTY_DIR . 'Smarty.class.php');

function main() {
  $db_config_factory = new DBConfigFactory();
  $db_config = $db_config_factory->get();
  if($db_config == NULL)
    return;

  $mysqli = getMysqlI($db_config);
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  }
  
  timezone();
  $smarty = smarty();

  $timing_rows = array();
  $task_rows = array();

  $smarty->assign('timing_rows', $timing_rows);
  $smarty->assign('task_rows', $task_rows);
  $smarty_output = $smarty->fetch('timesheet.tpl');
  $output = outputFiltering($smarty_output);
  print($output);
}

function getMysqlI($db_config) {
  $mysqli = new mysqli($db_config->getHost(),
		       $db_config->getUsername(),
		       $db_config->getPassword(),
		       $db_config->getDatabase());
  return $mysqli;
}

function timezone() {
  date_default_timezone_set('UTC');
}

function smarty() {
  $smarty = new Smarty();
  $smarty->setTemplateDir('include/smarty/templates');
  $smarty->setCompileDir('include/smarty/templates_c');
  $smarty->setConfigDir('include/smarty/configs');
  $smarty->setCacheDir('include/smarty/cache');

  return $smarty;
}

function outputFiltering($smarty_output) {
  $doc = new DOMDocument('1.0');
  $doc->preserveWhiteSpace = false;
  $doc->formatOutput = true;
  $doc->normalizeDocument();
  $doc->loadXML($smarty_output);
  return $doc->saveXML();
}

main();
?>

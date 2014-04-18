<?php
define('SMARTY_DIR', "/usr/share/php/smarty/");

require_once('db_config_factory.php');
require_once(SMARTY_DIR . 'Smarty.class.php');

function main() {
  timezone();
  $db_config_factory = new DBConfigFactory();
  $db_config = $db_config_factory->get();
  if($db_config == NULL) {
    error("Could not read configuration.");
    return;
  }

  $mysqli = getMysqlI($db_config);
  if ($mysqli->connect_errno) {
    error("Failed to connect to MySQL: " . $mysqli->connect_error);
    return;
  }
  
  $timing_rows = array();
  $task_rows = array();

  if(!fillTables($timing_rows, $task_rows, $mysqli)) {
    return;
  }

  $smarty = smarty();
  $smarty->assign('timing_rows', $timing_rows);
  $smarty->assign('task_rows', $task_rows);
  $smarty_output = $smarty->fetch('timesheet.tpl');
  $output = outputFiltering($smarty_output);
  header('Content-Type: application/xhtml+xml; charset=utf-8');
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

function fillTables(&$timing_rows, &$task_rows, $mysqli) {
  $query = 'select entries.id, entries.begin, entries.end, entries.notes, ';
  $query .= 'entries.coding_percentage as entry_coding_percentage, ';
  $query .= 'tasks.coding_percentage ';
  $query .= 'from entries ';
  $query .= 'inner join courses_tasks on entries.courses_tasks_id=courses_tasks.id ';
  $query .= 'inner join tasks on courses_tasks.task_id = tasks.id ';
  $query .= 'order by begin';
  
  if(NULL == $result = $mysqli->query($query)) {
    error("Query did not succeed. " . $mysqli->error);
    return false;
  }
  
  $rows = array();
  while($row = $result->fetch_assoc())
    array_push($rows, $row);

  if(!convertRows($rows)) {
    return false;
  }

  if(!verifyRows($rows)) {
    return false;
  }

  connectAdjacentRows($rows);
  $expanded_rows = expandRowsOverMidnight($rows);
  
  foreach($expanded_rows as $row) {
    array_push($timing_rows, array($row['begin']->format('d.m.Y'),
				   $row['begin']->format('H:i:s'),
				   twentyFourify($row['end']->format('H:i:s'))));
    array_push($task_rows, array($row['coding_percentage'] * 100,
				 $row['notes']));
  }

  return true;
}

function convertRows(&$rows) {
  foreach($rows as &$row) {
    $begin = new DateTimeImmutable($row['begin']);
    $end = new DateTimeImmutable($row['end']);
    $id = (int)$row['id'];
    $notes = $row['notes'];
    if($row['entry_coding_percentage'] !== NULL)
      $percentage = (float)$row['entry_coding_percentage'];
    else
      $percentage = (float)$row['coding_percentage'];

    $row['begin'] = $begin;
    $row['end'] = $end;
    $row['id'] = $id;
    $row['notes'] = preg_replace('/[^a-zA-Z0-9äöüÄÖÜß .!"§$%&\\/()=?+*\\-\\_,]/', '', $notes);
    $row['coding_percentage'] = $percentage;
  }

  return true;
}

function verifyRows($rows) {
  $begin = NULL;
  $end = NULL;
  $id = NULL;

  foreach($rows as $row) {
    if($begin == NULL && $end == NULL && $id == NULL) {
      $begin = $row['begin'];
      $end = $row['end'];
      $id = $row['id'];
    } else {
      $oldend = $end;
      $oldid = $id;
      $begin = $row['begin'];
      $end = $row['end'];
      $id = $row['id'];

      if($oldend->getTimeStamp() - $begin->getTimeStamp() > 0) {
	error('Begin of row with id ' . $id . ' overlaps with end of row with id ' . $oldid);
	return false;
      }
    }

    if($end->getTimeStamp() - $begin->getTimeStamp() < 0) {
      error('Begin after end in row with id ' . $id);
      return false;
    }
  }
  
  return true;
}

function connectAdjacentRows(&$rows) {
  $begin = NULL;
  $end = NULL;
  $id = NULL;
  $notes = NULL;
  $percentage = NULL;
  $indexes_to_remove = array();
  $index = -1;
  $oldindex = NULL;
  $keep_old = false;
  
  foreach($rows as $row) {
    if(!$keep_old) {
      $oldindex = $index;
    }
    
    ++$index;
    if($begin == NULL && $end == NULL && $id == NULL &&
       $notes == NULL && $percentage == NULL) {
      $begin = $row['begin'];
      $end = $row['end'];
      $id = $row['id'];
      $notes = $row['notes'];
      $percentage = $row['coding_percentage'];
      $keep_old = false;
      continue;
    } else {
      if(!$keep_old) {
	$oldbegin = $begin;
	$oldend = $end;
	$oldid = $id;
	$oldnotes = $notes;
	$oldpercentage = $percentage;
      }
      
      $begin = $row['begin'];
      $end = $row['end'];
      $id = $row['id'];
      $notes = $row['notes'];
      $percentage = $row['coding_percentage'];
      
      if($begin == $oldend) {
	$duration = $end->getTimeStamp() - $begin->getTimeStamp();
	$oldduration = $oldend->getTimeStamp() - $oldbegin->getTimeStamp();
	
	$newbegin = $oldbegin;
	$newend = $end;
	$newnotes = $oldnotes . ' ' . $notes;
	$newpercentage = ($oldduration / ($oldduration + $duration)) * $oldpercentage + 
	  ($duration / ($oldduration + $duration)) * $percentage;
	
	$rows[$oldindex]['begin'] = $newbegin;
	$rows[$oldindex]['end'] = $newend;
	$rows[$oldindex]['notes'] = $newnotes;
	$rows[$oldindex]['coding_percentage'] = $newpercentage;
	array_push($indexes_to_remove, $index);
	$keep_old = true;
      } else {
	$keep_old = false;
      }
    }
  }
  
  foreach($indexes_to_remove as $index) {
    unset($rows[$index]);
  }
}

function expandRowsOverMidnight($rows) {
  $expanded_rows = array();
  
  $begin = NULL;
  $end = NULL;
  $id = NULL;
  $notes = NULL;
  $percentage = NULL;
  
  foreach($rows as $row) {
    $begin = $row['begin'];
    $end = $row['end'];
    $id = $row['id'];
    $notes = $row['notes'];
    $percentage = $row['coding_percentage'];

    if($begin->format('%Y-%m-%d') != $end->format('%Y-%m-%d')) {
      $partbegin = $begin;
      $partend = $begin->setTime(23, 59, 59);
      $partrow = array('id' => $id, 'begin' => $partbegin, 'end' => $partend,
		       'notes' => $notes, 'coding_percentage' => $percentage);
      array_push($expanded_rows, $partrow);

      while($partend->add(new DateInterval('P1D'))->format('%Y-%m-%d') != $end->format('%Y-%m-%d')) {
	$partbegin = $partend->add(new DateInterval('P1D'))->setTime(0, 0, 0);
	$partend = $partbegin->setTime(23, 59, 59);
	$partrow = array('id' => $id, 'begin' => $partbegin, 'end' => $partend,
			 'notes' => $notes, 'coding_percentage' => $percentage);
	array_push($expanded_rows, $partrow);
      }

      $partbegin = $partend->add(new DateInterval('P1D'))->setTime(0, 0, 0);
      $partend = $end;
      $partrow = array('id' => $id, 'begin' => $partbegin, 'end' => $partend,
		       'notes' => $notes, 'coding_percentage' => $percentage);
      array_push($expanded_rows, $partrow);
    } else {
      array_push($expanded_rows, $row);
    }
  }

  return $expanded_rows;
}

function twentyFourify($timestamp) {
  if($timestamp == '23:59:59')
    return '24:00:00';
  else
    return $timestamp;
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

function error($msg) {
  print($msg);
}

main();
?>

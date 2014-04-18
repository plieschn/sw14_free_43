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

  $users = array();
  $projects = array();
  $date_begin = array();
  $date_end = array();

  if(!getFilterVariablesFromDB($users, $projects, $date_begin, $date_end, $mysqli)) {
    return;
  }

  $user_filter = array(0, '', '');
  $project_filter = array(0, '');
  $date_begin_filter = array();
  $date_end_filter = array();

  if(isset($_GET['action']) && $_GET['action'] == 'filter') {
    if(!getFilterVariablesFromPostData($user_filter, $project_filter, $date_begin_filter, $date_end_filter, $mysqli)) {
      return;
    }
  }

  if(count($date_begin_filter) != 0)
    $date_begin[0] = $date_begin_filter[0];

  if(count($date_end_filter) != 0)
    $date_end[0] = $date_end_filter[0];
  
  $timing_rows = array();
  $task_rows = array();

  if(!fillTables($timing_rows, $task_rows, $user_filter, $project_filter, $date_begin_filter, $date_end_filter, $mysqli)) {
    return;
  }

  $smarty = smarty();
  $smarty->assign('users', $users);
  $smarty->assign('projects', $projects);
  $smarty->assign('date_begin', $date_begin[0]->format('Y-m-d'));
  $smarty->assign('date_end', $date_end[0]->format('Y-m-d'));
  $smarty->assign('user_filter', $user_filter);
  $smarty->assign('project_filter', $project_filter);
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

function getFilterVariablesFromDB(&$users, &$projects, &$date_begin, &$date_end, $mysqli) {
  $query = "select * from users";
  if(NULL == $result = $mysqli->query($query)) {
    error("Query did not succeed. " . $mysqli->error);
    return false;
  }
  while($row = $result->fetch_assoc()) {
    array_push($users, array($row['id'], $row['first_name'], $row['last_name']));
  }
  
  $query = "select * from projects";
  if(NULL == $result = $mysqli->query($query)) {
    error("Query did not succeed. " . $mysqli->error);
    return false;
  }
  while($row = $result->fetch_assoc()) {
    array_push($projects, array($row['id'], $row['name']));
  }

  $query = "select min(begin) as date_begin from entries";
  if(NULL == $result = $mysqli->query($query)) {
    error("Query did not succeed. " . $mysqli->error);
    return false;
  }
  if($row = $result->fetch_assoc()) {
    array_push($date_begin, new DateTime($row['date_begin']));
  } else {
    error("Query did not succeed.");
    return false;
  }

  $query = "select max(end) as date_end from entries";
  if(NULL == $result = $mysqli->query($query)) {
    error("Query did not succeed. " . $mysqli->error);
    return false;
  }
  if($row = $result->fetch_assoc()) {
    array_push($date_end, (new DateTime($row['date_end']))->add(new DateInterval('P1D'))->setTime(0, 0, 0));
  } else {
    error("Query did not succeed.");
    return false;
  }

  return true;
}

function getFilterVariablesFromPostData(&$user_filter, &$project_filter, &$date_begin_filter, &$date_end_filter, $mysqli) {
  $user_id = (int)$_POST['user'];
  if($user_id != 0) {
    $query = "select id, first_name, last_name from users where id=?";
    if(!$statement = $mysqli->prepare($query)) {
      error('Prepare failed: ' . $mysqli->error);
      return false;
    }
    if(!$statement->bind_param('i', $user_id)) {
      error('Binding parameter failed: ' . $mysqli->error);
      return false;
    }
    if(!$statement->execute()) {
      error('Execute failed: ' . $mysqli->error);
    }
    if(!$statement->bind_result($user_filter[0], $user_filter[1], $user_filter[2])) {
      error('Binding failed: ' . $mysqli->error);
    }
    if(!$statement->fetch()) {
      error('Fetching failed: ' . $mysqli->error);
    }
    $statement->close();
  }

  $project_id = (int)$_POST['project'];
  if($project_id != 0) {
    $query = "select id, name from projects where id=?";
    if(!$statement = $mysqli->prepare($query)) {
      error('Prepare failed: ' . $mysqli->error);
      return false;
    }
    if(!$statement->bind_param('i', $project_id)) {
      error('Binding parameter failed: ' . $mysqli->error);
      return false;
    }
    if(!$statement->execute()) {
      error('Execute failed: ' . $mysqli->error);
    }
    if(!$statement->bind_result($project_filter[0], $project_filter[1])) {
      error('Binding failed: ' . $mysqli->error);
    }
    if(!$statement->fetch()) {
      error('Fetching failed: ' . $mysqli->error);
    }
    $statement->close();
  }

  if(isset($_POST['date_begin']) && $_POST['date_begin'] != '') {
    array_push($date_begin_filter, new DateTime($_POST['date_begin']));
  }

  if(isset($_POST['date_end']) && $_POST['date_end'] != '') {
    array_push($date_end_filter, new DateTime($_POST['date_end']));
  }

  return true;
}

function fillTables(&$timing_rows, &$task_rows, $user_filter, $project_filter, $date_begin_filter, $date_end_filter, $mysqli) {
  $parameters = array('');
  $query = 'select entries.id, entries.begin, entries.end, entries.notes, ';
  $query .= 'entries.coding_percentage as entry_coding_percentage, ';
  $query .= 'tasks.coding_percentage ';
  $query .= 'from entries ';
  $query .= 'inner join projects_tasks on entries.projects_tasks_id=projects_tasks.id ';
  $query .= 'inner join tasks on projects_tasks.task_id = tasks.id ';
  $query .= 'inner join projects on projects_tasks.project_id = projects.id ';
  applyFilters($query, $user_filter, $project_filter, $date_begin_filter, $date_end_filter, $mysqli, $parameters);

  $ref_parameters = array();
  $ref_parameters[0] = $parameters[0];
  for($counter = 0; $counter < count($parameters); ++$counter) {
    $ref_parameters[$counter] =& $parameters[$counter];
  }

  $query .= 'order by begin';

  if(!$statement = $mysqli->prepare($query)) {
    error("Prepare failed: " . $mysqli->error);
    return false;
  }

  if(count($ref_parameters) > 1) {
    call_user_func_array(array($statement, 'bind_param'), $ref_parameters);
  }

  if(!$statement->execute()) {
    error('Execute failed: ' . $mysqli->error);
  }

  if(!$statement->bind_result($id, $begin, $end, $notes, $entry_coding_percentage, $coding_percentage)) {
    error('Binding failed: ' . $mysqli->error);
  }

  $rows = array();
  while($statement->fetch()) {
    $row = array();
    $row['id'] = $id;
    $row['begin'] = $begin;
    $row['end'] = $end;
    $row['notes'] = $notes;
    $row['entry_coding_percentage'] = $entry_coding_percentage;
    $row['coding_percentage'] = $coding_percentage;
    array_push($rows, $row);
  }

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

function applyFilters(&$query, $user_filter, $project_filter, $date_begin_filter, $date_end_filter, $mysqli, &$parameters) {
  $filter_applied = false;

  if($user_filter[0] != 0) {
    $query .= 'where entries.user_id = ? ';
    $filter_applied = true;
    $parameters[0] .= 'i';
    array_push($parameters, $user_filter[0]);
    
  }
  if($project_filter[0] != 0) {
    if(!$filter_applied) {
      $query .= 'where projects.id = ? ';
      $filter_applied = true;
    } else {
      $query .= 'and projects.id=? ';
    }      
    $parameters[0] .= 'i';
    array_push($parameters, $project_filter[0]);
  }
  if(count($date_begin_filter) != 0) {
    if(!$filter_applied) {
      $query .= 'where entries.end >= ? ';
      $filter_applied = true;
    } else {
      $query .= 'and entries.end >= ? ';
    }      
    $parameters[0] .= 's';
    array_push($parameters, $date_begin_filter[0]->format('Y-m-d'));
  }
  if(count($date_end_filter) != 0) {
    if(!$filter_applied) {
      $query .= 'where entries.begin <= ? ';
      $filter_applied = true;
    } else {
      $query .= 'and entries.begin <= ? ';
    }      
    $parameters[0] .= 's';
    array_push($parameters, $date_end_filter[0]->format('Y-m-d'));
  }
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

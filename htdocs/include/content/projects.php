<?php
namespace tsis\content;

require_once('content.php');
require_once('include/database/statement.php');

use \tsis\database\ParamType as ParamType;
use \DateTimeImmutable as DateTimeImmutable;
use \DOMDocument as DOMDocument;

class Project {
  private $id;
  private $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getName() {
    return $this->name;
  }
}

class Track {
  private $id;
  private $project;
  private $number;

  public function __construct(&$project, $number) {
    $this->project = $project;
    $this->number = $number;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function &getProject() {
    return $this->project;
  }

  public function getNumber() {
    return $this->number;
  }
}

class Point {
  private $id;
  private $project;
  private $track;
  private $number;
  private $longitude;
  private $latitude;
  private $height;
  private $when;

  public function __construct(&$project, &$track, $number, $longitude, $latitude, $height, $when) {
    $this->project = $project;
    $this->track = $track;
    $this->number = $number;
    $this->longitude = $longitude;
    $this->latitude = $latitude;
    $this->height = $height;
    $this->when = $when;
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function &getProject() {
    return $this->project;
  }

  public function &getTrack() {
    return $this->track;
  }

  public function getNumber() {
    return $this->number;
  }

  public function getLongitude() {
    return $this->longitude;
  }

  public function getLatitude() {
    return $this->latitude;
  }

  public function getHeight() {
    return $this->height;
  }

  public function getWhen() {
    return $this->when;
  }

  public function getWhenOut() {
    $datetime = new DateTimeImmutable($this->when);
    return $datetime->format('Y-m-d\\TH:i:s\\Z');
  }
}

class Projects extends Content {
  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    if(count($path_array) == 2) {
      return $this->viewOverview($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
    } else if(count($path_array) == 4 && $path_array[1] == 'KML') {
      return $this->viewKML($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
    } else if(count($path_array) == 4 && $path_array[1] == 'View') {
      return $this->viewSpecific($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
    } else if(count($path_array) == 3 && $path_array[1] == 'Enter') {
      $this->enter($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
    }

  }

  private function viewOverview($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $projects = $this->getProjects();

    $tpl = 'projects_view_overview.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Projects');
    $smarty->assign('projects', $projects);
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }

  private function getProjects() {
    if(isset($_SESSION['username'])) {
      $username = $_SESSION['username'];
      $user_id = $this->getUserIdWithoutPassword($username);
      if($user_id == null) {
	return;
      }
    } else {
      return;
    }

    $query = 'select id, name from ' . $this->table_prefix_ . 'projects where person_id = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'person_id', &$user_id)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $name = NULL;
    $result = $statement->bindResults(array(&$id, &$name));

    $project_objects = array();
    while($statement->fetch()) {
      $project_object = new Project($name);
      $project_object->setId($id);
      array_push($project_objects, $project_object);
    }

    return $project_objects;
  }

  private function viewKML($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $project_name = $path_array[2];
    $project = $this->getProject($project_name);
    $tracks = $this->getTracksForProject($project);

    $track_numbers = array();
    $tracks_points_map = array();
    foreach($tracks as $track) {
      $points = $this->getPointsForTrack($project, $track);
      $tracks_points_map[$track->getNumber()] = $points;
      $track_objects[$track->getNumber()] = $track;
    }

    $project_kml = $this->buildProjectKml($project,
					  $tracks,
					  $track_numbers,
					  $tracks_points_map);
    $tpl = 'projects_view_kml.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Projects');
    $smarty->assign('project_kml', $project_kml);
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    header('Content-Type: application/xml; charset=utf-8');
    return $smarty_output;
  }

  private function viewSpecific($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $project_name = $path_array[2];
    $project = $this->getProject($project_name);
    
    $tpl = 'projects_view_specific.tpl';
    $smarty->assign('baselink', $baselink);
    $smarty->assign('selected', 'Projects');
    $smarty->assign('project_name', $project_name);
    $smarty->assign('timestamp', (new DateTimeImmutable())->getTimestamp());
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch($tpl);
    return $smarty_output;
  }

  private function getProject($project_name) {
    $query = 'select id, name from ' . $this->table_prefix_ . 'projects where name = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'name', &$project_name)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $name = NULL;
    $result = $statement->bindResults(array(&$id, &$name));

    $statement->fetch();
    $project_object = new Project($name);
    $project_object->setId($id);
    return $project_object;
  }

  private function getTracksForProject($project) {
    $query = 'select id, number from ' . $this->table_prefix_ . 'tracks where project_id = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $project_id = $project->getId();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'project_id', &$project_id)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $number = NULL;
    $result = $statement->bindResults(array(&$id, &$number));

    $track_objects = array();
    while($statement->fetch()) {
      $track_object = new Track($project, $number);
      $track_object->setId($id);
      array_push($track_objects, $track_object);
    }
    return $track_objects;
  }

  private function getPointsForTrack($project, $track) {
    $query = 'select id, number, longitude, latitude, height, `when` from ' . $this->table_prefix_ . 'points where track_id = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $track_id = $track->getId();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'track_id', &$track_id)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $number = NULL;
    $longitude = NULL;
    $latitude = NULL;
    $height = NULL;
    $when = NULL;
    $result = $statement->bindResults(array(&$id, &$number, &$longitude, &$latitude, 
					    &$height, &$when));

    $point_objects = array();
    while($statement->fetch()) {
      $point_object = new Point($project, $track, $number, 
				$longitude, $latitude, $height, $when);
      $point_object->setId($id);
      array_push($point_objects, $point_object);
    }
    return $point_objects;
  }

  private function buildProjectKml($project,
				   $tracks,
				   $track_numbers,
				   $tracks_points_map) {
    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->formatOutput = true;
    $kml = $dom->createElementNS('http://www.opengis.net/kml/2.2', 'kml');
    
    $kml->setAttribute('xmlns:gx', 'http://www.google.com/kml/ext/2.2');

    $document = $dom->createElement('Document');
    $kml->appendChild($document);

    $document_name = $dom->createElement('name');
    $document_name->appendChild($dom->createTextNode($project->getName()));
    $document->appendChild($document_name);

    $style = $dom->createElement('Style');
    $document->appendChild($style);
    $style->setAttribute('id', 'lineStyle');

    $line_style = $dom->createElement('LineStyle');
    $style->appendChild($line_style);

    $color = $dom->createElement('color');
    $line_style->appendChild($color);
    $color->appendChild($dom->createTextNode('ff0000ff'));
    
    $width = $dom->createElement('width');
    $line_style->appendChild($width);
    $width->appendChild($dom->createTextNode('5'));

    $folder = $dom->createElement('Folder');
    $document->appendChild($folder);

    $folder_name = $dom->createElement('name');
    $folder_name->appendChild($dom->createTextNode($project->getName()));
    $folder->appendChild($folder_name);

    $placemark = $dom->createElement('Placemark');
    $folder->appendChild($placemark);

    $style_url = $dom->createElement('styleUrl');
    $placemark->appendChild($style_url);
    $style_url->appendChild($dom->createTextNode('#lineStyle'));

    foreach($tracks as $track) {
      $track_xml = $dom->createElement('gx:Track');
      $placemark->appendChild($track_xml);

      $tessellate = $dom->createElement('tessellate');
      $track_xml->appendChild($tessellate);
      $tessellate->appendChild($dom->createTextNode('1'));

      foreach($tracks_points_map[$track->getNumber()] as $track_id => $point) {
	$when_xml = $dom->createElement('when');
	$when_xml->appendChild($dom->createTextNode($point->getWhenOut()));
	$track_xml->appendChild($when_xml);
      }
	
      foreach($tracks_points_map[$track->getNumber()] as $track_id => $point) {
	$coord_xml = $dom->createElement('gx:coord');
	$coord_string = $point->getLongitude() . ' ' . 
	  $point->getLatitude() . ' ' . $point->getHeight();
	$coord_xml->appendChild($dom->createTextNode($coord_string));
	$track_xml->appendChild($coord_xml);
      }
    }

    $dom->appendChild($kml);

    return $dom->saveXML();
  }

  private function enter($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    $objects = $this->getObjects();
    $this->enterObjects($objects);
  }

  private function getObjects() {
    $project_name = $_POST['project_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $file_content = $_POST['file_content'];

    var_dump($_POST);
    $user_id = $this->getUserId($username, $password);

    if($user_id == null) {
      return;
    }

    $document = new DOMDocument();
    $document->loadXML($file_content);

    $project_objects = array();
    $track_objects = array();
    $point_objects = array();

    $project_object = new Project($project_name);
    array_push($project_objects, $project_object);

    $tracks = $document->getElementsByTagNameNS('http://www.google.com/kml/ext/2.2', 'Track');
    foreach($tracks as $track) {
      $number  = $track->getAttribute('id');
      $track_object = new Track($project_object, $number);
      array_push($track_objects, $track_object);

      $whens_array = array();
      $coords_array = array();

      $whens = $track->getElementsByTagName('when');
      foreach($whens as $when) {
        array_push($whens_array, $when);
      }

      $coords = $track->getElementsByTagNameNS('http://www.google.com/kml/ext/2.2', 'coord');
      foreach($coords as $coord) {
        array_push($coords_array, $coord);
      }

      $points = array();
      $count = min(count($whens_array), count($coords_array));
      for($counter = 0; $counter < $count; ++$counter) {
        $when = new DateTimeImmutable($whens_array[$counter]->childNodes->item(0)->nodeValue);
        $coord_string = $coords_array[$counter]->childNodes->item(0)->nodeValue;
        $coord_string_split = preg_split('/[\s]/', $coord_string);
        $longitude = $coord_string_split[0];
        $latitude = $coord_string_split[1];
        $height = $coord_string_split[2];
        $point_object = new Point($project_object, $track_object, $counter, $longitude, $latitude, $height, $when);
        array_push($point_objects, $point_object);
      }
    }

    return array('project_objects' => $project_objects,
                 'track_objects' => $track_objects,
                 'point_objects' => $point_objects,
		 'user_id' => $user_id);
  }

  private function getUserId($username, $password) {
    $query = 'select id from ' . $this->table_prefix_ . 'persons where username = ? and password = PASSWORD(?)';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'username', &$username),
                                         array(ParamType::PARAM_TYPE_STRING, 'password', &$password)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $result = $statement->bindResults(array(&$id));
    if($statement->fetch()) {
      return (intval($id));
    } else {
      return null;
    }
  }

  private function getUserIdWithoutPassword($username) {
    $query = 'select id from ' . $this->table_prefix_ . 'persons where username = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'username', &$username)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $result = $statement->bindResults(array(&$id));
    if($statement->fetch()) {
      return (intval($id));
    } else {
      return null;
    }
  }

  private function enterObjects($objects) {
    $projects = $objects['project_objects'];
    $tracks = $objects['track_objects'];
    $points = $objects['point_objects'];
    $user_id = $objects['user_id'];

    $this->begin();

    foreach($projects as $project) {
      if(!$this->projectExists($project)) {
        if(!$this->enterProject($project, $user_id)) {
          return false;
        }
      } else {
        $this->setProjectId($project);
      }
    }

    $tracks_existed = array();
    foreach($tracks as $track) {
      if(!$this->trackExists($project, $track)) {
        if(!$this->enterTrack($track)) {
          return false;
        }
      } else {
        array_push($tracks_existed, $track);
      }
    }

    foreach($points as $point) {
      if(!in_array($point->getTrack(), $tracks_existed)) {
        if(!$this->enterPoint($point)) {
          return false;
        }
      }
    }

    $this->commit();

    return true;
  }

  private function projectExists(&$project) {
    $query = 'select count(*) as amount from ' . $this->table_prefix_ . 'projects where name = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $name = $project->getName();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'name', &$name)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $amount = NULL;
    $result = $statement->bindResults(array(&$amount));
    $statement->fetch();

    return ($amount == 1);
  }

  private function setProjectId(&$project) {
    $query = 'select id from ' . $this->table_prefix_ . 'projects where name = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $name = $project->getName();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'name', &$name)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $id = NULL;
    $result = $statement->bindResults(array(&$id));
    $statement->fetch();

    $project->setId($id);
  }


  private function trackExists($project, $track) {
    $query = 'select count(*) as amount from ' . $this->table_prefix_ . 'tracks where number = ? and project_id = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $number = $track->getNumber();
    $project_id = $project->getId();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'number', &$number),
					 array(ParamType::PARAM_TYPE_INT, 'project_id', &$project_id)))) {
      print($this->database->getError());
      return;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return;
    }

    $amount = NULL;
    $result = $statement->bindResults(array(&$amount));
    $statement->fetch();

    return ($amount == 1);
  }

  private function enterProject(&$project, $user_id) {
    $query = 'insert into ' . $this->table_prefix_ . 'projects (name, person_id) values (?, ?)';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return false;
    }

    $name = $project->getName();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'name', &$name),
					 array(ParamType::PARAM_TYPE_INT, 'person_id', &$user_id)))) {
      print($this->database->getError());
      return false;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return false;
    }

    $id = $this->database->getInsertId();
    $project->setId($id);

    return true;
  }

  private function enterTrack(&$track) {
    $query = 'insert into ' . $this->table_prefix_ . 'tracks (project_id, number) values (?, ?)';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return false;
    }

    $project_id = $track->getProject()->getId();
    $number = $track->getNumber();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'project_id', &$project_id),
                                         array(ParamType::PARAM_TYPE_INT, 'number', &$number)))) {
      print($this->database->getError());
      return false;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return false;
    }

    $id = $this->database->getInsertId();
    $track->setId($id);

    return true;
  }

  private function enterPoint(&$point) {
    $query = 'insert into ' . $this->table_prefix_ . 'points (project_id, track_id, number, longitude, latitude, height, `when`) values (?, ?, ?, ?, ?, ?, ?)';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return false;
    }

    $project_id = $point->getTrack()->getProject()->getId();
    $track_id = $point->getTrack()->getId();
    $number = $point->getNumber();
    $longitude = $point->getLongitude();
    $latitude = $point->getLatitude();
    $height = $point->getHeight();
    $when = $point->getWhen()->format('Y-m-d H:i:s');

    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'project_id', &$project_id),
                                         array(ParamType::PARAM_TYPE_INT, 'track_id', &$track_id),
                                         array(ParamType::PARAM_TYPE_INT, 'number', &$number),
                                         array(ParamType::PARAM_TYPE_STRING, 'longitude', &$longitude),
                                         array(ParamType::PARAM_TYPE_STRING, 'latitude', &$latitude),
                                         array(ParamType::PARAM_TYPE_STRING, 'height', &$height),
                                         array(ParamType::PARAM_TYPE_STRING, 'when', &$when)))) {
      print($this->database->getError());
      return false;
    }

    if(!$statement->execute()) {
      print($this->database->getError());
      print($statement->getError());
      return false;
    }

    $id = $this->database->getInsertId();
    $point->setId($id);

    return true;
  }

  private function begin() {
    $query = 'begin';

    $this->connect();
    $this->database->query($query);

    return true;
  }

  private function commit() {
    $query = 'commit';

    $this->connect();
    $this->database->query($query);

    return true;
  }
}
?>

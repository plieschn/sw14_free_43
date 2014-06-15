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
}

class Projects extends Content {
  public function get($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {
    if(count($path_array) > 2) {
      if($path_array[1] == 'View') {
        $this->view($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
      } else if($path_array[1] == 'Enter') {
        $this->enter($path_array, $baselink, $main_menu_items, $sub_menu_items, $content_factory, $smarty);
      }
    } else {

    }
  }

  private function view($path_array, $baselink, $main_menu_items, $sub_menu_items, &$content_factory, &$smarty) {

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
                 'point_objects' => $point_objects);
  }

  private function enterObjects($objects) {
    $projects = $objects['project_objects'];
    $tracks = $objects['track_objects'];
    $points = $objects['point_objects'];

    $this->begin();

    foreach($projects as $project) {
      if(!$this->projectExists($project)) {
        if(!$this->enterProject($project)) {
          return false;
        }
      } else {
        $this->setProjectId($project);
      }
    }

    $tracks_existed = array();
    foreach($tracks as $track) {
      if(!$this->trackExists($track)) {
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


  private function trackExists($track) {
    $query = 'select count(*) as amount from ' . $this->table_prefix_ . 'tracks where number = ?';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return;
    }

    $number = $track->getNumber();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_INT, 'number', &$number)))) {
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

  private function enterProject(&$project) {
    $query = 'insert into ' . $this->table_prefix_ . 'projects (name) values (?)';

    $this->connect();
    $statement = $this->database->prepare($query);
    if(!$statement->prepareWorked()) {
      print($this->database->getError());
      return false;
    }

    $name = $project->getName();
    if(!$statement->bindParameters(array(array(ParamType::PARAM_TYPE_STRING, 'name', &$name)))) {
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
                                         array(ParamType::PARAM_TYPE_INT, 'latitude', &$latitude),
                                         array(ParamType::PARAM_TYPE_INT, 'height', &$height),
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

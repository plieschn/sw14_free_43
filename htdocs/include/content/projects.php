<?php
namespace tsis\content;

require_once('content.php');
require_once('include/database/statement.php');

use \tsis\database\ParamType as ParamType;
use \DateTime as DateTime;
use \DOMDocument as DOMDocument;

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
    $points = $this->getPoints();
    $this->enterPoints($points);
  }

  private function getPoints() {
    $project_name = $_POST['project_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $file_content = $_POST['file_content'];

    $document = new DOMDocument();
    $document->loadXML($file_content);

    $whens_array = array();
    $coords_array = array();

    $whens = $document->getElementsByTagName('when');
    foreach($whens as $when) {
      array_push($whens_array, $when);
    }

    $coords = $document->getElementsByTagNameNS('http://www.google.com/kml/ext/2.2', 'coord');
    foreach($coords as $coord) {
      array_push($coords_array, $coord);
    }

    $points = array();
    $count = min(count($whens), count($coords));
    for($counter = 0; $counter < $count; ++$counter) {
      array_push($points, array('when' => $whens_array[$counter],
                                'coords' => $coords_array[$counter]));
    }
    return $points;
  }

  private function enterPoints($points) {
    
  }
}
?>

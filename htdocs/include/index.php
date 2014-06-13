<?php
namespace tsis;

require_once('main.php');

use \tsis\Main as Main;

class Index {
  public function index() {
    date_default_timezone_set('UTC');
    $main = new Main();
    $main->main();
  }
}
?>

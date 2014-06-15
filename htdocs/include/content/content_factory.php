<?php
namespace tsis\content;

require_once('about.php');
require_once('setup.php');
require_once('setup_automatic.php');
require_once('setup_manually.php');
require_once('setup_test.php');
require_once('projects.php');
require_once('login.php');
require_once('register.php');
require_once('logout.php');

class ContentFactory {
  public function __construct() {
    $this->sites_ = array('about' => new About(),
                          'setup' => new Setup(),
                          'setup_automatic' => new SetupAutomatic(),
                          'setup_manually' => new SetupManually(),
                          'setup_test' => new SetupTest(),
                          'projects' => new Projects(),
                          'login' => new Login(),
                          'register' => new Register(),
                          'logout' => new Logout());
  }

  public function getContent($site) {
    if(isset($this->sites_[$site]))
      return $this->sites_[$site];
    else
      return NULL;
  }

  public function mainMenuItems() {
    if(!isset($_SESSION['username'])) {
      $items = array('' => 'About',
                     'Setup' => 'Setup',
                     'Login' => 'Login',
                     'Register' => 'Register');
    } else {
      $items = array('' => 'About',
		     'Projects' => 'Projects',
                     'Logout' => 'Logout');
    }
    return $items;
  }
}
?>
<?php
namespace tsis;

require_once('include/content/content_factory.php');
require_once('include/uri/uri_decoder.php');
require_once('include/ext/smarty/Smarty.class.php');

use \tsis\content\ContentFactory as ContentFactory;
use \tsis\uri\UriDecoder as UriDecoder;
use \Smarty as Smarty;

class Main {
  private function resourceNotFound(&$smarty, $baselink) {
    header("HTTP/1.0 404 Not Found");
    $content_factory = new ContentFactory();
    $main_menu_items = $content_factory->mainMenuItems();
    $smarty->assign('baselink', $baselink);
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch('error_404.tpl');
    print($smarty_output);
  }

  private function unauthorized(&$smarty, $baselink) {
    header("HTTP/1.0 401 Unauthorized");
    $content_factory = new ContentFactory();
    $main_menu_items = $content_factory->mainMenuItems();
    $smarty->assign('baselink', $baselink);
    $smarty->assign('main_menu_items', $main_menu_items);
    $smarty_output = $smarty->fetch('error_401.tpl');
    print($smarty_output);
  }

  private function smarty() {
    $smarty = new Smarty();
    $smarty->setTemplateDir('include/smarty/templates');
    $smarty->setCompileDir('include/smarty/templates_c');
    $smarty->setConfigDir('include/smarty/configs');
    $smarty->setCacheDir('include/smarty/cache');

    return $smarty;
  }

  function main() {
    session_start();

    $uri_decoder = new UriDecoder();
    $path_array = $uri_decoder->getInternalPathArray();

    $baselink = $uri_decoder->getHttps() ? 'https://' : 'http://';
    $baselink .= $uri_decoder->getHttpHost();
    $baselink .= $uri_decoder->getRequestPathToApplication();

    $smarty = $this->smarty();

    if($path_array[0] != '' &&
       $path_array[0] != 'Setup' &&
       $path_array[0] != 'Projects' &&
       $path_array[0] != 'Login' &&
       $path_array[0] != 'Register' &&
       $path_array[0] != 'Logout') {
      $this->resourceNotFound($smarty, $baselink);
      return;
    }

    $content_factory = new ContentFactory();
    $main_menu_items = $content_factory->mainMenuItems();

    if($path_array[0] == '') {
      $content = $content_factory->getContent('about');
      if($content != NULL) {
        $main_menu_items = $content->setMainMenuItems($path_array, $baselink, $main_menu_items, $content_factory);
        $smarty_output = $content->get($path_array, $baselink, $main_menu_items, NULL, $content_factory, $smarty);
      } else {
        $this->resourceNotFound($smarty, $baselink);
      }
    } else if($path_array[0] == 'Setup') {
      $content = $content_factory->getContent('setup');
      if($content != NULL) {
        $main_menu_items = $content->setMainMenuItems($path_array, $baselink, $main_menu_items, $content_factory);
        $smarty_output = $content->get($path_array, $baselink, $main_menu_items, NULL, $content_factory, $smarty);
      } else {
        $this->resourceNotFound($smarty, $baselink);
      }
    } else if($path_array[0] == 'Projects') {
      $content = $content_factory->getContent('projects');
      if($content != NULL) {
        $main_menu_items = $content->setMainMenuItems($path_array, $baselink, $main_menu_items, $content_factory);
        $smarty_output = $content->get($path_array, $baselink, $main_menu_items, NULL, $content_factory, $smarty);
      } else {
        $this->resourceNotFound($smarty, $baselink);
      }
    } else if($path_array[0] == 'Login') {
      $content = $content_factory->getContent('login');
      if($content != NULL) {
        $main_menu_items = $content->setMainMenuItems($path_array, $baselink, $main_menu_items, $content_factory);
        $smarty_output = $content->get($path_array, $baselink, $main_menu_items, NULL, $content_factory, $smarty);
      } else {
        $this->resourceNotFound($smarty, $baselink);
      }
    } else if($path_array[0] == 'Register') {
      $content = $content_factory->getContent('register');
      if($content != NULL) {
        $main_menu_items = $content->setMainMenuItems($path_array, $baselink, $main_menu_items, $content_factory);
        $smarty_output = $content->get($path_array, $baselink, $main_menu_items, NULL, $content_factory, $smarty);
      } else {
        $this->resourceNotFound($smarty, $baselink);
      }
    } else if($path_array[0] == 'Logout') {
      $content = $content_factory->getContent('logout');
      if($content != NULL) {
        $main_menu_items = $content->setMainMenuItems($path_array, $baselink, $main_menu_items, $content_factory);
        $smarty_output = $content->get($path_array, $baselink, $main_menu_items, NULL, $content_factory, $smarty);
      } else {
        $this->resourceNotFound($smarty, $baselink);
      }
    }

    print($smarty_output);

  }
}
?>

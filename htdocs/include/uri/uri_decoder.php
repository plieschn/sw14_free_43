<?php
namespace tsis\uri;

class UriDecoder
{
  private $https_;
  private $http_host_;
  private $real_path_to_application_;
  private $request_path_to_application_;
  private $internal_path_;
  private $internal_path_array_;

  function __construct()  {
    $this->https_ = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
    $request_uri_decode = urldecode($_SERVER['REQUEST_URI']);
    $script_filename_decode = urldecode($_SERVER['SCRIPT_FILENAME']);
    $script_name_decode = urldecode($_SERVER['SCRIPT_NAME']);

    $this->http_host_ = $_SERVER['HTTP_HOST'];
    $this->real_path_to_application_ = realpath(dirname($script_filename_decode));

    $cmplen = self::strcmplen($request_uri_decode, $script_name_decode);

    $this->request_path_to_application_ = substr($request_uri_decode, 0, $cmplen);

    $question_mark = strpos($request_uri_decode, '?');

    if($question_mark)
      $internal_path = substr($request_uri_decode, $cmplen, $question_mark - $cmplen);
    else
      $internal_path = substr($request_uri_decode, $cmplen);

    $this->internal_path_ = $internal_path;
    $internal_path_array = explode('/', $internal_path);

    if(strlen($this->internal_path_) > 0)
      $this->internal_path_array_ = $internal_path_array;
  }

  public function getHttps()    {
    return $this->https_;
  }

  public function getHttpHost()  {
    return $this->http_host_;
  }

  public function getRealPathToApplication() {
    return $this->real_path_to_application_;
  }

  public function getRequestPathToApplication() {
    return $this->request_path_to_application_;
  }

  public function setRequestPathToApplication($request_path_to_application) {
    $this->request_path_to_application_ = $request_path_to_application;
  }

  public function getInternalPath() {
    return $this->internal_path_;
  }

  public function getInternalPathArray() {
    return $this->internal_path_array_;
  }

  public function strcmplen($str1, $str2, $offset = 0, $length = 0) {
    $counter = ($offset >= 0) ? ($offset) : strlen($str1) + $offset;
    $length = max(array(0 => strlen($str1), 1 => strlen($str2)));
    $len = 0;
    while($counter < strlen($str1) && $counter < strlen($str2) &&
          $str1[$counter] == $str2[$counter] && $len < $length)
      {
        ++$counter;
        ++$len;
      }
    return $len;
  }
}
?>

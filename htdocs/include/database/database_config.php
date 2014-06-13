<?php
namespace tsis\database;

class DatabaseConfig
{
  private $host_;
  private $user_;
  private $enc_password_;
  private $database_;
  private $table_prefix_;
  
  public function getHost() {
    return $this->host_;
  }
  
  public function setHost($host) {
    $this->host_ = $host;
  }
  
  public function getUser() {
    return $this->user_;
  }
  
  public function setUser($user) {
    $this->user_ = $user;
  }
  
  public function getEncPassword() {
    return $this->enc_password_;
  }
  
  public function setEncPassword($enc_password) {
    $this->enc_password_ = $enc_password;
  }
  
  public function getDatabase() {
    return $this->database_;
  }

  public function setDatabase($database) {
    $this->database_ = $database;
  }

	public function getTablePrefix() {
		return $this->table_prefix_;
	}

	public function setTablePrefix($table_prefix)	{
		$this->table_prefix_ = $table_prefix;
	}
 
  public function load() {
    $json = file_get_contents('include/config/db.json', true);
    $json_obj = json_decode($json, true);
    $this->host_ = $json_obj['host'];
    $this->user_ = $json_obj['user'];
    $this->enc_password_ = $json_obj['enc_password'];
    $this->database_ = $json_obj['database'];
		$this->table_prefix_ = $json_obj['table_prefix'];
  }
  
  public function save() {
    $json_obj = array('host' => $this->host_,
                      'user' => $this->user_,
                      'enc_password' => $this->enc_password_,
											'database' => $this->database_,
											'table_prefix' => $this->table_prefix_);
    $json = json_encode($json_obj);
    file_put_contents('includes/config/db.json', $json);
  }
}
?>

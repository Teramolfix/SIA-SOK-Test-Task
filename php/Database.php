<?php
class Database
{
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $database = "sia_sok";
  public $conn;

  public function getConnection() {
    $this->conn = null;

    try {
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
      if ($this->conn->connect_error) {
        throw new Exception("Connection failed: " . $this->conn->connect_error);
      }
    } catch (Exception $e) {
      echo "Connection error: " . $e->getMessage();
    }

    return $this->conn;
  }
}
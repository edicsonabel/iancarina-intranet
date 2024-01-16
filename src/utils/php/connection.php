<?php
/* Includes */
require_once(__DIR__ . '/../../../config.php');

/* Connection */
class Connection
{
  protected $SERVER = '';
  protected $NAME = '';
  protected $USER = '';
  protected $PASS = '';

  public function __construct(
    $server,
    $name,
    $user,
    $pass
  ) {
    $this->SERVER = $server;
    $this->NAME = $name;
    $this->USER = $user;
    $this->PASS = $pass;
  }

  public function getConnection()
  {
    $conn = null;
    try {
      // $conn = new PDO('sqlsrv:Server=' . $this->SERVER . ';Database=' . $this->NAME . ';TrustServerCertificate=true', $this->USER, $this->PASS);
      $conn = new PDO('pgsql:host=' . $this->SERVER . ';dbname=' . $this->NAME . '', $this->USER, $this->PASS);
    } catch (PDOException $e) {
      $data = array(
        'error' => $e->getMessage()
      );
      header('Content-Type: application/json');
      echo json_encode($data);
      $conn = null;
    }
    return $conn;
  }

  static function closeConnection(&$conn)
  {
    $conn = null;
  }
}
